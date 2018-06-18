<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomyTypeMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomy_type_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name',40);
            $table->integer('taxonomy_type_id')->unsigned();
            $table->boolean('is_mandatory')->default(0);

            $table->foreign('taxonomy_type_id')->references('id')->on('taxonomy_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxonomy_type_metas');
    }
}
