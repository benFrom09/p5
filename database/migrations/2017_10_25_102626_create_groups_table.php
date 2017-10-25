<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('user_email',150);
           

            $table->timestamps();
        });

        Schema::table('groups', function (Blueprint $table) {
            
            $table->foreign('user_email')->references('email')->on('users')
                    ->onDelete('restrict');
            

        });

        Schema::create('user_group', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('group_id')->unsigned(); //unsigned to avoid maria db errors
            $table->integer('user_id')->unsigned();
            $table->timestamps();


        }) ;

        

        Schema::table('user_group', function (Blueprint $table) {

            $table->foreign('group_id')->references('id')->on('groups')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_group');
        Schema::dropIfExists('groups');
    }
}
