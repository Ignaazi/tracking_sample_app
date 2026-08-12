<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task', function (Blueprint $table) {
            $table->timestamp('pd_prepared_at')->nullable();
            $table->unsignedBigInteger('pd_prepared_by')->nullable();

            $table->timestamp('qa_checked_at')->nullable();
            $table->unsignedBigInteger('qa_checked_by')->nullable();

            $table->timestamp('planner_approved_at')->nullable();
            $table->unsignedBigInteger('planner_approved_by')->nullable();

            $table->foreign('pd_prepared_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('qa_checked_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('planner_approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('task', function (Blueprint $table) {
            $table->dropForeign(['pd_prepared_by']);
            $table->dropForeign(['qa_checked_by']);
            $table->dropForeign(['planner_approved_by']);
            $table->dropColumn([
                'pd_prepared_at', 'pd_prepared_by',
                'qa_checked_at', 'qa_checked_by',
                'planner_approved_at', 'planner_approved_by'
            ]);
        });
    }
};