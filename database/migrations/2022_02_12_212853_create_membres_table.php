<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
	        $table->string('association_uid',128)->references('uid')->on('associations')->onUpdate('cascade')->onDelete('cascade');
	        $table->foreignId('user_id')->constrained();
	        $table->foreignId('role_id')->constrained();
            $table->json('competences')->nullable();
            $table->date('date_rejoint')->nullable()->useCurrent();
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
        Schema::dropIfExists('membres');
    }
}
