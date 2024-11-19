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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->json('title');
            $table->json('slug');
            $table->json('content');

            // SEO
            $table->json('metadata_title');
            $table->json('metadata_description');
            $table->json('metadata_keywords');
            // end SEO

            $table->unsignedBigInteger('section')->default(1); // 1 post 2 news 3 advertisment
            $table->unsignedBigInteger('views')->default(0); // counting views


            // will be use always
            $table->boolean('status')->nullable()->default(true);
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
        Schema::dropIfExists('posts');
    }
};
