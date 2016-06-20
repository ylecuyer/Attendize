<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModelsToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('events', function ($table) {
            $table->string('invitation_mail_subject')->nullable();
            $table->string('invitation_model_id')->nullable();
      });

      Schema::create('invitations_models', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->integer('event_id');
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
      Schema::table('events', function ($table) {
            $table->dropColumn('invitation_mail_subject');
            $table->dropColumn('invitation_model_id');
      });

      Schema::drop('invitations_models');
    }
}
