<?php

namespace App\Repositories;

use App\Events\StoreArticleEvent;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ArticleRepository
{

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
            $validated['tags'] ?? "", $validated['author'], $validated['contributors'], 1, 'pending', $now];


        try {
            $model = DB::insert("INSERT INTO articles (article_code, title, body, category_department_ref_id,
                      tag_ref_id, user_ref_id, waiting_contributors_ref_id, is_last_revision,
                      status, created_at) VALUES (?,?,?,?,?,?,?,?,?,?)", $bindings);
        } catch (QueryException $e) {
            return $e->getMessage();
        }

        //dispatch an event
        $messages = $validated['messages'];
        $article = DB::select("SELECT article_id FROM articles WHERE article_code = $articleCode");
        $articleID = $article[0]->article_id;

        event(new StoreArticleEvent($model, $messages, $articleID));
        return "The Article is created successfully and the invitation messages are sent!";
    }

    public function update($validated)
    {

    }

    public function find()
    {

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
        $contributors = explode(',', $article[0]->contributors_ref_id);
        $waitingContributors = explode(',', $article[0]->waiting_contributors_ref_id);
        $rejectedContributors = explode(',', $article[0]->rejected_contributors_ref_id);
        $hasAlreadyDeletedFromWaitingListByAuthor = false;

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

}
