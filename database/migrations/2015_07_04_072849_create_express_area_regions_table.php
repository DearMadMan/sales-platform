<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressAreaRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('express_area_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('express_area_id')->comment("快递配置信息ID(结算相关配置)");
            $table->integer('region_id')->comment("地区ID");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('express_area_regions');
    }
}
