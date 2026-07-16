<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task', function (Blueprint $col) {
            // 1. Hapus status Primary Key dari kolom item_code
            // (Beberapa DB membutuhkan drop primary manual)
            $col->dropPrimary(['item_code']);
            
            // 2. Buat kolom 'id' baru sebagai primary key auto-increment di paling awal
            $col->bigIncrements('id')->first();
        });
    }

    public function down(): void
    {
        Schema::table('task', function (Blueprint $col) {
            $col->dropColumn('id');
            $col->primary('item_code');
        });
    }
};