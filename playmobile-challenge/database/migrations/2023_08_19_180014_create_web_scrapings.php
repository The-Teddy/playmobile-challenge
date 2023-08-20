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
        Schema::create('web_scrapings', function (Blueprint $table) {
            $table->string('type')->default('notice');
            $table->unsignedInteger('id');
            $table->string('title');
            $table->longText('description');
            $table->string('publication');
            $table->string('deadline')->nullable();
            $table->string('url');
            $table->string('self');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_scrapings');
    }
};
