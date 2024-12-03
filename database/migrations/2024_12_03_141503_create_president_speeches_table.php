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
        Schema::create('president_speeches', function (Blueprint $table) {
            $table->id();


            $table->json('title');
            $table->json('slug');
            $table->json('content');

            $table->string('promotional_image')->nullable();

            // SEO
            $table->json('metadata_title')->nullable();
            $table->json('metadata_description')->nullable();
            $table->json('metadata_keywords')->nullable();
            // end SEO

            // will be use always
            $table->boolean('status')->default(true);
            $table->dateTime('published_on')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // end of will be use always
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('president_speeches');
    }
};
