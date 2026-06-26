<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_specs', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('sap_code')->unique();
            $table->string('brand');
            $table->string('model_type');
            $table->text('dimensions')->nullable(); // Spesifikasi ukuran P x L x T
            $table->text('requirements')->nullable(); // Kebutuhan material/teknis
            $table->string('image_path')->nullable(); // Menyimpan nama file foto item
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_specs');
    }
};