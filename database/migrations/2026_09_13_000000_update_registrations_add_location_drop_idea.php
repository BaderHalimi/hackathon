<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // مكان الحضور (فرع الفعالية) — يُختار من الأماكن التي يحدّدها الأدمن
            $table->string('attendance_location', 120)->nullable()->after('experience');
        });

        Schema::table('registrations', function (Blueprint $table) {
            // لم نعد نطلب فكرة المشروع؛ تُعلن تحديات الهاكاثون خلال الفعالية
            $table->dropColumn('idea');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->text('idea')->nullable()->after('team_members');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('attendance_location');
        });
    }
};