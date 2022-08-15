<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ArticleRepository
{
    public function create($validated)
    {

        //Definded now() out side of the loop for making the time in all of these columns (publish_date, created-at, ...) the same!
        $now = Carbon::now();
        $validated = $validated[0];
        $bindings[] = [random_int(10000000000000000000, 99999999999999999999), $validated->title, $validated->body, $validated->categories,
            $validated->tags, $validated->author, $validated->contributors, $now, 1, 'pending', $now];


        try {
            DB::insert("INSERT INTO articles (article_code, title, body, category_department_ref_id,
                      tag_ref_id, user_ref_id, waiting_contributors_ref_id, publish_date, is_last_version,
                      status, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?)", $bindings);
        } catch (QueryException $e) {
            return $e->getMessage();
        }

        //send message to even

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
