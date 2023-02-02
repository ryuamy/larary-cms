<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDistricTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distric', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('city_id')->index();
            $table->string('uuid')->unique();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('administration_code', 10)->nullable(); //so far I only know it's required for Indonesia
            $table->string('postcode', 25)->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('distric');
    }
}
