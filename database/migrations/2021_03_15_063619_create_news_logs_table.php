<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNewsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->index();
            $table->integer('news_id')->index();
            $table->string('action', 255);
            $table->text('action_detail');
            $table->string('ipaddress', 255);
            $table->integer('created_by')->nullable()->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_logs');
    }
}
