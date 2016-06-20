<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHtmlFieldsToInvitationsModelsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invitations_models', function(Blueprint $table) {

            $table->string('html_file_name')->nullable();
            $table->integer('html_file_size')->nullable()->after('html_file_name');
            $table->string('html_content_type')->nullable()->after('html_file_size');
            $table->timestamp('html_updated_at')->nullable()->after('html_content_type');

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invitations_models', function(Blueprint $table) {

            $table->dropColumn('html_file_name');
            $table->dropColumn('html_file_size');
            $table->dropColumn('html_content_type');
            $table->dropColumn('html_updated_at');

        });
    }

}