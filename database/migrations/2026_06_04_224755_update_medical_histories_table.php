<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_histories', function (Blueprint $table) {

            // إضافة الربط بالـ appointment
            $table->foreignId('appointment_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('doctor_id')
                ->nullable()
                ->after('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            // تعديل الحقول
            $table->text('diagnosis')->nullable()->change();
            $table->text('treatment')->nullable()->change();

            // حذف الحقول اللي مش هنحتاجها
            if (Schema::hasColumn('medical_histories', 'doctor_name')) {
                $table->dropColumn('doctor_name');
            }

            if (Schema::hasColumn('medical_histories', 'visit_date')) {
                $table->dropColumn('visit_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('medical_histories', function (Blueprint $table) {

            $table->string('doctor_name')->nullable();
            $table->date('visit_date')->nullable();

            $table->dropConstrainedForeignId('appointment_id');
            $table->dropConstrainedForeignId('doctor_id');
        });
    }
};