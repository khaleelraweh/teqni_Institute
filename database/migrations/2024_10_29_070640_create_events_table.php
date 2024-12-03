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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->json('title');
            $table->json('slug');
            $table->json('content');

            // SEO
            $table->json('metadata_title');
            $table->json('metadata_description');
            $table->json('metadata_keywords');
            // end SEO

            $table->unsignedBigInteger('section')->default(1); // 1 post 2 news
            $table->unsignedBigInteger('views')->default(0); // counting views

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // will be use always
            $table->boolean('status')->nullable()->default(true);
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
        Schema::dropIfExists('events');
    }
};
