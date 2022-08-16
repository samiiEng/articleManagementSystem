<?php

namespace App\Repositories;

use App\Events\StoreArticleEvent;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Events\DeleteWaitingContributorEvent;

class ArticleRepository
{

    /*
     * Gives the last revision of the articles and if set only the published ones
     */
    public function index($user, $isPublished)
    {
        $isPublished = $isPublished ? " AND publish_date IS NOT NULL" : "";

        if ($user->role == 'normal') {
            //Gets his/her articles

            return DB::select("SELECT * FROM articles WHERE user_ref_id = ? AND is_last_revision = 1 $isPublished", [$user->id]);
        } elseif ($user->role == 'department_manager') {
            //Only gets the articles belong to the authors of this department

            $users = DB::select("SELECT user_id FROM users WHERE department_ref_id = ? AND is_last_revision = 1 $isPublished", [$user->department_ref_id]);
            $length = count($users);
            $i = 0;
            $conditions = "";
            $values = [];
            foreach ($users as $value) {
                $i++;
                if ($length == $i)
                    $conditions .= "user_ref_id = ? OR ";
                else
                    $conditions .= "user_ref_id = ?";
                $values[] = $value->id;
            }
            $conditions .= $isPublished;

            return DB::select("SELECT * FROM articles WHERE is_last_revision = 1 AND ($conditions))", $values);
        } else {
            //Gets all articles
            //The user is admin or the university manager
            return DB::select("SELECT * FROM articles");
        }
    }

    /*
     *CONVENTION ==> {
     * "author", "title", "contributors", "publishedArticles", "categories", "body",
     *  "tags", "messages" => [
     *      {"contributorID",
     *       "title",
     *       "body"}
     *    ]
     * }
     */

    public function create($validated)
    {

        //Definded now() out side of the loop for making the time in all of these columns (publish_date, created-at, ...) the same!
        $now = Carbon::now();
        //19 character unique article_code
        $articleCode = random_int(100000000000000000, 9111111111111111111);

        $bindings = [$articleCode, $validated['title'], $validated['body'] ?? "", $validated['categories'] ?? "",
            $validated['tags'] ?? "", $validated['author'], $validated['contributors'], $validated['publishedArticles'], 1, 'pending', $now];


        try {
            $model = DB::insert("INSERT INTO articles (article_code, title, body, category_department_ref_id,
                      tag_ref_id, user_ref_id, waiting_contributors_ref_id, published_articles_ref_id, is_last_revision,
                      status, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?)", $bindings);
        } catch (QueryException $e) {
            return $e->getMessage();
        }

        //dispatch an event
        $messages = $validated['messages'];
        $article = DB::select("SELECT * FROM articles WHERE article_code = $articleCode");


        event(new StoreArticleEvent($article, $messages));
        return "The Article is created successfully and the invitation messages are sent!";
    }

    /*
     * CONVENTION ==> [[ "field to set" => "?,", ... ],["field for where clause" => "? AND OR AND( OR( AND) OR) )AND( )OR(...", ...], [value1, value2, ...]]
     */
    public function update($items)
    {
        $set = "";
        $where = "";
        $values = [];

        foreach ($items[0] as $key => $value) {

            $set .= $key . " " . $value;
        }

        foreach ($items[1] as $key => $value) {
            $where .= $key . " " . $value;
        }

        foreach ($items[2] as $item) {
            $values[] = $item;
        }


        DB::update("UPDATE articles SET $set WHERE $where", $values);

        return "The article is updated!";
    }

    public function editArticle($article)
    {
        $contributors = explode(',', $article->waiting_contributors_ref_id);
        $result[] = $article;

        foreach ($contributors as $contributor) {
            $acceptedContributors = json_decode(DB::select("SELECT contributors_ref_id FROM articles WHERE article_id = ?", [$article->article_id])[0], true);
            foreach ($acceptedContributors as $key => $value) {
                $user = DB::select("SELECT username, first_name, last_name FROM users WHERE user_id = ?", [$key])[0];

                $result['contributorsArticles'][] = DB::select("SELECT title, body, article_code, article_id FROM articles WHERE article_id = ?", [$value])[0]
                    . $user . DB::select("SELECT name, english_name FROM departments WHERE department_id = ?", [$user->department_ref_id])[0];
            }

        }
        return $result;

    }

    public function updateArticle()
    {

    }

    public function find($id)
    {
        return DB::select("SELECT * FROM articles WHERE article_id = ?", [$id]);
    }

    public function softDelete()
    {

    }

    public function forceDelete()
    {

    }

    public function restoreDeleted()
    {

    }

    public function invitationResponse($articleID, $userID, $parameter)
    {
        $article = DB::select("SELECT contributors_ref_id, waiting_contributors_ref_id, rejected_contributors_ref_id FROM articles WHERE article_id = ?", [$articleID]);
        $contributors = !empty($article[0]->contributors_ref_id) ? explode(',', $article[0]->contributors_ref_id) : [];
        $waitingContributors = !empty($article[0]->waiting_contributors_ref_id) ? explode(',', $article[0]->waiting_contributors_ref_id) : [];
        $rejectedContributors = !empty($article[0]->rejected_contributors_ref_id) ? explode(',', $article[0]->rejected_contributors_ref_id) : [];
        $hasAlreadyDeletedFromWaitingListByAuthor = false;;
        $i = 0;
        foreach ($waitingContributors as $waitingContributor) {
            if ($waitingContributor == $userID) {
                unset($waitingContributors[$i]);
                $hasAlreadyDeletedFromWaitingListByAuthor = true;
                break;
            }
            ++$i;
        }

        if ($hasAlreadyDeletedFromWaitingListByAuthor) {

            //Updating the waiting_conributors_id to the new list without that id
            $waitingContributors = implode(',', $waitingContributors);
            DB::update("UPDATE articles SET waiting_contributors_ref_id = $waitingContributors WHERE article_id = ?", [$articleID]);

            //Updating the accept/rejected_conributors_id to the new list with that id
            if ($parameter == 'accept') {
                $contributors[] = $userID;
                $contributors = implode(',', $contributors);
                DB::update("UPDATE articles SET contributors_ref_id = $contributors WHERE article_id = ?", [$articleID]);
            } else {
                $rejectedContributors[] = $userID;
                $rejectedContributors = implode(',', $rejectedContributors);
                DB::update("UPDATE articles SET rejected_contributors_ref_id = $rejectedContributors  WHERE article_id = ?", [$articleID]);
            }

        }
        return "The clicked invitation link is successfully processed!";

    }

    public function deleteContributor($request)
    {
        //We can only delete the rejected and waiting contributors.
        $article = DB::select("SELECT * FROM articles WHERE article_id = ?", [$request['articleID']]);

        $waitingContributors = explode(',', $article[0]->waiting_contributors_ref_id);
        $rejectedContributors = explode(',', $article[0]->rejected_contributors_ref_id);

        foreach ($request['contributors'] as $contributor) {
            if ($contributor['isWaiting']) {
                $contributorID = array($contributor['contributorID']);
                $waitingContributors = implode(',', array_diff($waitingContributors, $contributorID));

                DB::update("UPDATE articles SET waiting_contributors_ref_id = ? WHERE article_id = ?", [$waitingContributors, $request['articleID']]);

                //Event for deleting the invitation link that has been sent
                event(new DeleteWaitingContributorEvent($article[0]->article_id, $contributor['contributorID'], json_decode($article[0]->invitation_messages_ref_id, true)));

            } else {
                $contributorID = array($contributor['contributorID']);
                $rejectedContributors = implode(',', array_diff($rejectedContributors, $contributorID));

                DB::update("UPDATE articles SET rejected_contributors_ref_id = ? WHERE article_id = ?", [$rejectedContributors, $request['articleID']]);

                //The invitation is seen and responded by the user so deleting the invitation is pointless.
            }

        }

        return "The operation was successful!";
    }

}
