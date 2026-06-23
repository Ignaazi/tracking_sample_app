<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // UPDATED: Mengubah nama tabel dari 'tasks' menjadi 'task'
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            
            // Core Project Identity
            $table->string('project_name');
            $table->string('customer');
            $table->string('item_code');
            $table->string('sap_number');
            $table->string('brand_family');
            $table->string('market');
            
            // Technical Specification Fields (Dibuat nullable agar fleksibel)
            $table->string('ascis_pd')->nullable();
            $table->string('cs_brand')->nullable();
            $table->string('cs_hw')->nullable();
            $table->string('ghw_set')->nullable();
            
            // Core Kanban Board & System Status
            $table->enum('status', ['To Do', 'In Progress', 'Ready for QA', 'Completed'])->default('To Do');
            $table->enum('development_status', ['Active', 'Testing'])->default('Active');
            
            // Internal Sub-Process Tracking Grid Statuses
            $table->enum('layout_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->enum('baan_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->enum('promp_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->enum('job_bag_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            
            // Additional Notes
            $table->text('remark')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // UPDATED: Menyesuaikan drop tabel ke bentuk tunggal 'task'
        Schema::dropIfExists('task');
    }
};