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
        Schema::create('report_inscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')->references('id')->on('reports');
            $table->unsignedBigInteger('inscription_id');
            $table->foreign('inscription_id')->references('id')->on('inscriptions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_inscriptions');
    }
};
