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
            Schema::create('project', function (Blueprint $table) { 
$table->id();
$table->string('title');
$table->text('description')->nullable(); 
$table->date('deadline')->nullable();
$table->enum('status', ['planning', 'active', 'on_hold', 'completed'])->default('planning');
$table->timestamps();
$table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
