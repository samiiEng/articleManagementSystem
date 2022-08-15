<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ArticleRepository
{

    /*
     *CONVENTION ==> {
     * "author", "title", "contributors", "publishedArticles", "categories",
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
        $bindings = [random_int(100000000000000000, 9111111111111111111), $validated['title'], $validated['body'] ?? "", $validated['categories']  ?? "",
            $validated['tags'] ?? "", $validated['author'], $validated['contributors'], $now, 1, 'pending', $now];


        try {
            $model = DB::insert("INSERT INTO articles (article_code, title, body, category_department_ref_id,
                      tag_ref_id, user_ref_id, waiting_contributors_ref_id, publish_date, is_last_revision,
                      status, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?)", $bindings);
        } catch (QueryException $e) {
            return $e->getMessage();
        }

        //send message to event


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
}
