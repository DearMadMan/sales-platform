<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->commit("上级地区ID");
            $table->string('name')->commit("地区名称");
            $table->integer('lft')->commit("左值");
            $table->integer('rgt')->commit("右值");
            $table->integer('level_id')->commit("节点ID");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('regions');
    }
}
