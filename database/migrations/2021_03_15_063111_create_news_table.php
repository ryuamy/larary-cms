<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('uuid')->unique();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->mediumText('content');
            $table->string('featured_image', 255)->nullable();
            $table->string('seo_title', 100)->nullable();
            $table->string('seo_description', 100)->nullable();
            $table->text('seo_focus_keyphrase')->nullable();
            $table->string('seo_tagline', 255)->nullable();
            $table->string('seo_facebook_title', 100)->nullable();
            $table->string('seo_facebook_description', 100)->nullable();
            $table->string('seo_twitter_title', 100)->nullable();
            $table->string('seo_twitter_description', 100)->nullable();
            $table->integer('seo_allow_search_engine_result')->default(1);
            $table->integer('seo_allow_search_engine_follow')->default(1);
            $table->integer('status')->default(0);
            $table->integer('created_by')->nullable()->index();
            $table->integer('updated_by')->nullable()->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
