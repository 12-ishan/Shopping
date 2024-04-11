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
        Schema::create('awards_recognition', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->string('ar_name')->nullable();
            $table->string('ar_first')->nullable();
            $table->string('ar_level_first')->nullable();
            $table->string('ar_fr_year')->nullable();
            $table->string('ar_second')->nullable();
            $table->string('ar_level_second')->nullable();
            $table->string('ar_sr_year')->nullable();
            $table->string('lp_lang1')->nullable();
            $table->string('lp_lang2')->nullable();
            $table->string('lp_p_lang1')->nullable();
            $table->string('lp_p_lang2')->nullable();
            $table->string('ho_hobby1')->nullable();
            $table->string('ho_hobby2')->nullable();
            $table->string('ho_hobby3')->nullable();
            $table->string('ho_hobby4')->nullable();
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
        Schema::dropIfExists('awards_recognition');
    }
};
