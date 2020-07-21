<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner', function (Blueprint $table) {
            $table->increments('id');

            $table->string('cate_code_1',3)->nullable();
            $table->foreign('cate_code_1')
                  ->references('cd_group')->on('code_group')
                  ->onDelete('set null');

            $table->string('cate_code_2', 6)->nullable();
            $table->foreign('cate_code_2')
                  ->references('cd_main')->on('code_main')
                  ->onDelete('set null');

            $table->string('banner_image')->nullable();
            $table->string('banner_thumb')->nullable();
            $table->string('link_url')->nullable();
            $table->string('banner_title')->nullable();
            $table->string('banner_text')->nullable();
            $table->dateTime('banner_start')->nullable();
            $table->dateTime('banner_end')->nullable();
            $table->char('is_visible', 1)->default("N");

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner');
    }
}
