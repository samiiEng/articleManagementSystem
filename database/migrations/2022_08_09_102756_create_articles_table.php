<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id('article_id');
            $table->string('title', 100);
            $table->longText('body');
            $table->string('category_department_ref_id', 50);
            $table->string('tag_ref_id', 50);
            $table->unsignedBigInteger('user_ref_id');
            $table->string('contributor_article_ref_id', 150)->nullable();
            $table->string('waiting_contributor_ref_id', 150)->nullable();
            $table->string('rejected_contributor_ref_id', 150)->nullable();
            $table->string('published_articles_ref_id', 150)->nullable()->comment('The id of published articles that are used in this article');
            $table->string('parent_ref_id')->nullable();
            $table->unsignedBigInteger('revision_ref_id')->nullable();
            $table->unsignedInteger('revision_number')->nullable();
            $table->dateTimeTz('publish_date')->nullable();
            $table->boolean('is_last_revision');
            $table->string('status', 50);
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
