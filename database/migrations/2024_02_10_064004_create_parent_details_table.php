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
        Schema::create('parent_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('father_salutation')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_email')->nullable();
            $table->bigInteger('father_mobile')->nullable();
            $table->unsignedBigInteger('father_is_working')->nullable();
            $table->unsignedBigInteger('mother_salutation')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_email')->nullable();
            $table->bigInteger('mother_mobile')->nullable();
            $table->unsignedBigInteger('mother_is_working')->nullable();
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
        Schema::dropIfExists('parent_details');
    }
};
