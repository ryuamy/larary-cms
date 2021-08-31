<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->integer('status')->default(0); //0=inactive, 1=active
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });

        /**
         * Please add this when creating new migration.
         * To automatic add new module
         */
        // DB::table('modules')->insert([
        //     'name' => 'Example',
        //     'slug' => 'example',
        //     'status' => 1,
        //     'created_by' => 1,
        //     'updated_by' => 1,
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');

        /**
         * Please add this when creating new migration.
         * To automatic delete new module
         */
        //softdelete
        // DB::table('modules')->where('slug', 'example')->update(['deleted_at' => date('Y-m-d H:i:s')]);
        //harddelete
        // DB::table('modules')->where('slug', 'example')->delete();
    }
}
