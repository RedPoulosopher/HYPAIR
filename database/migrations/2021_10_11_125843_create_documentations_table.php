<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentations', function (Blueprint $table) {
            $table->id();
	        $table->foreignId('association_id');
            $table->string('titre',128);
            $table->string('slug',128)->index();
            $table->text('description');
            $table->text('contenu_md');
            $table->json('categories')->nullable();
	        $table->string('langue')->default("fr");
            $table->tinyInteger('confidentialite')->unsigned()->default(0);
            $table->tinyInteger('visibilite')->default(0);
            $table->boolean('mise_en_avant')->default(0);
            $table->date('debut_mise_en_avant')->nullable()->default(null);
            $table->date('fin_mise_en_avant')->nullable()->default(null);
            $table->unsignedBigInteger('derive_de')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('documentations', function (Blueprint $table) {
            $table->foreign('derive_de')->references('id')->on('documentations')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentations');
    }
}
