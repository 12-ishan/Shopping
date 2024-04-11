<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->string('ug_college')->nullable();
            $table->string('ug_university')->nullable();
            $table->unsignedBigInteger('ug_degree')->nullable();
            $table->unsignedBigInteger('ug_mode')->nullable();
            $table->string('ug_enroll_year')->nullable();
            $table->string('ug_pass_year')->nullable();
            $table->string('ug_percentage')->nullable();
            $table->string('im_diploma_pursue')->nullable();
            $table->string('im_college')->nullable();
            $table->unsignedBigInteger('im_board')->nullable();
            $table->unsignedBigInteger('im_stream')->nullable();
            $table->string('im_percentage')->nullable();
            $table->string('im_enroll_year')->nullable();
            $table->string('im_pass_year')->nullable();
            $table->string('hg_school')->nullable();
            $table->unsignedBigInteger('hg_board')->nullable();
            $table->string('hg_percentage')->nullable();
            $table->unsignedBigInteger('hg_stream')->nullable();
            $table->string('hg_enroll_year')->nullable();
            $table->string('hg_pass_year')->nullable();
            $table->tinyInteger('status');
            $table->integer('sort_order');
            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('application')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academics');
    }
};
