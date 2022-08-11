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
            $table->string('category_ref_id', 50);
            $table->string('tag_ref_id', 50);
            $table->string('status', 50);
            $table->unsignedBigInteger('user_ref_id');
            $table->string('article_ref_id', 50)->nullable();
            $table->string('waiting_contributor_ref_id', 50)->nullable();
            $table->string('rejected_contributor_ref_id', 50)->nullable();
            $table->unsignedBigInteger('parent_ref_id')->nullable();
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
