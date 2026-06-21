<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->enum('phase', ['Plan', 'Test', 'Develop', 'Launch'])->default('Plan');
            $table->string('task_title'); // Contoh: Prototype, Integration, Assembly
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('progress_percent')->default(0); // 0 sampai 100
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timelines');
    }
};