<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            // Fields
            $table->increments('id');
            $table->char('name',60);
            $table->string('description')->nullable();
            $table->char('image',255)->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('taxonomy_type_id')->unsigned();
            $table->timestamps();

            // Foreign keys
            $table->foreign('parent_id')->references('id')->on('taxonomies')->onDelete('set null');
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
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('taxonomies');
    }
}
