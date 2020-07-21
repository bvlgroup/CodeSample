<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_main', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cd_group', 3);
            $table->string('cd_main', 6)->unique();
            $table->string('cd_main_name')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('cd_group')
                  ->references('cd_group')->on('code_group')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_main');
    }
}
