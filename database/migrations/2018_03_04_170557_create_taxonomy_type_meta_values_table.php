<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomyTypeMetaValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomy_type_meta_values', function (Blueprint $table) {
            // Fields
            $table->increments('id');
            $table->integer('taxonomy_id')->unsigned();
            $table->integer('taxonomy_type_meta_id')->unsigned();
            $table->string('value')->nullable();

            // Primary key
            $table->unique(['taxonomy_id', 'taxonomy_type_meta_id'], 'taxonomy_type_meta_value_unique'); // It's not allowed to repeat those two keys together

            // Foreign keys
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
            $table->foreign('taxonomy_type_meta_id')->references('id')->on('taxonomy_type_metas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxonomy_type_meta_values');
    }
}
