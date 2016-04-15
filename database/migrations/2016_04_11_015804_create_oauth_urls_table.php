<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->commit('标题:');
            $table->string('redirect_url')->default('')->commit('目标地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oauth_urls');
    }
}
