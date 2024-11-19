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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();

            $table->json('title');
            $table->json('slug');
            $table->json('subtitle');
            $table->json('description');

            $table->string('icon')->nullable();

            $table->json('btn_title');
            $table->string('url')->nullable();
            $table->boolean('show_btn_title')->default(true); // عرض العنوان والتصفاصيل 

            $table->string('target')->default('_self');
            $table->unsignedBigInteger('section')->default(1);

            $table->boolean('show_info')->default(true); // عرض العنوان والتصفاصيل 

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
        Schema::dropIfExists('sliders');
    }
};
