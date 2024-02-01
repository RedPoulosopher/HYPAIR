<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            # Drop previous constraint
            $table->dropForeign(['event_id']);
            # Create new constraint with 'SET NULL' on delete
            $table->foreign('event_id')->nullable()->references('id')->on('evenements')->onUpdate('cascade')->onDelete('set null');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
