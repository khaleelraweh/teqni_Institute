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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();

            $table->json('name'); // اسم الذي يقول عنا 
            $table->json('title'); // صفتة الاستاذ الدكتور 
            $table->json('slug');
            $table->json('content'); // ماذا يقول 
            $table->string('image')->nullable();

            // SEO
            $table->json('metadata_title')->nullable();
            $table->json('metadata_description')->nullable();
            $table->json('metadata_keywords')->nullable();
            // end SEO


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
        Schema::dropIfExists('testimonials');
    }
};
