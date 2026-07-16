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
        Schema::create('task', function (Blueprint $table) {
            // 1. No (Diset integer biasa, bukan auto-increment primary)
            $table->integer('no')->nullable();

            // 2. Item Code (Set sebagai PRIMARY KEY menggunakan string)
            $table->string('item_code')->primary();

            // Kolom 3 - 12
            $table->string('brand_family')->nullable();          // 3. Brand / Family
            $table->string('market')->nullable();                // 4. Market
            $table->string('project_name')->nullable();          // 5. Project (Project Name)
            $table->string('ascis_pd')->nullable();              // 6. PD ASCIS (Sesuai nama variabel kamu: ascis_pd)
            $table->string('customer')->nullable();              // 7. Customer
            $table->string('cs_brand')->nullable();              // 8. CS Brand
            $table->string('cs_hw')->nullable();                 // 9. CS HW
            $table->string('cpi_hw')->nullable();                // 10. CPI HW
            $table->string('s5_internal_approval')->nullable();  // 11. S5 Internal Approval
            $table->string('ghw_set')->nullable();               // 12. GHW Set

            // Kolom 13 - 14 (Menggunakan tipe date agar format tanggal presisi)
            $table->date('information_received')->nullable();    // 13. Information Received
            $table->date('plm_released')->nullable();            // 14. PLM Released

            // Kolom 15 - 28
            $table->string('coi_number')->nullable();            // 15. COI Number
            $table->string('green_light')->nullable();           // 16. Green Light
            $table->string('td')->nullable();                    // 17. TD
            $table->string('machine')->nullable();               // 18. Machine
            $table->string('board')->nullable();                 // 19. Board
            $table->string('board_u_code')->nullable();          // 20. Board U Code
            $table->string('board_a_code')->nullable();          // 21. Board A Code
            $table->string('type_cm')->nullable();               // 22. Type CM
            $table->string('die_cut_number')->nullable();        // 23. Die Cut Number
            $table->string('s10_number')->nullable();            // 24. S10 Number
            $table->string('s11_number')->nullable();            // 25. S11 Number
            $table->string('s12_number')->nullable();            // 26. S12 Number
            $table->string('cylinder_supplier')->nullable();     // 27. Cylinder Supplier
            $table->string('repro_by')->nullable();              // 28. Repro By

            // Kolom 29 - 36
            $table->string('sequence_seq')->nullable();          // 29. Sequence (Seq)
            $table->string('colour')->nullable();                // 30. Colour
            $table->string('baan_cylinder')->nullable();         // 31. BAAN Cylinder
            $table->string('film_number')->nullable();           // 32. Film Number
            $table->string('ink_system')->nullable();            // 33. Ink System
            $table->string('ink_code')->nullable();              // 34. Ink Code
            $table->string('supplier_ink')->nullable();          // 35. Supplier Ink
            $table->string('baan_ink_code')->nullable();         // 36. BAAN Ink Code

            // Kolom 37 - 39
            $table->decimal('coverage_percent', 5, 2)->nullable(); // 37. Coverage (%)
            $table->decimal('usage_kg_th', 8, 3)->nullable();      // 38. Usage (Kg/TH)
            $table->string('angle_anilox')->nullable();            // 39. Angle / Anilox

            // Kolom 40 - 42
            $table->text('remark')->nullable();                  // 40. Remarks (Remark)
            $table->string('main_design_attachment')->nullable(); // 41. Main Design / Attachment
            
            // 42. Project Status & Core Kanban Statuses (Digabung dengan enum bawaan kamu)
            $table->enum('status', ['To Do', 'In Progress', 'Ready for QA', 'Completed'])->default('To Do'); // Mengisi 'Project Status'
            $table->enum('development_status', ['Active', 'Testing'])->default('Active');
            
            // Internal Sub-Process Tracking Grid Statuses
            $table->enum('layout_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->enum('baan_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->enum('promp_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->enum('job_bag_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');

            // SAP Number bawaan migration lama kamu agar tidak hilang
            $table->string('sap_number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};