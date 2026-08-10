<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('timelines', function (Blueprint $table) {
            // Relasi ke tabel tasks
            $table->foreignId('task_id')->nullable()->constrained('task')->onDelete('cascade')->after('id');
            
            // Menyimpan section (layout, baan, promp, job_bag)
            $table->string('section_key')->nullable()->after('task_id'); 
            
            // Mengizinkan tanggal null agar fleksibel jika belum di-set di awal
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
            
            // Status penyelesaian item
            $table->boolean('is_completed')->default(false)->after('progress_percent');
        });
    }

    public function down(): void
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->dropForeign(['task_id']);
            $table->dropColumn(['task_id', 'section_key', 'is_completed']);
        });
    }
};