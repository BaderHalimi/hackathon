<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            $table->string('reference')->unique();
            $table->string('participation_type', 20);

            // بيانات مقدّم الطلب (أو قائد الفريق)
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 30);
            $table->string('university');
            $table->string('major');
            $table->string('study_year', 40)->nullable();
            $table->text('skills');
            $table->string('track');
            $table->string('experience', 40)->nullable();
            $table->string('portfolio', 255)->nullable();
            $table->string('source', 80)->nullable();

            // بيانات الفريق (فقط عند التسجيل كفريق)
            $table->string('team_name')->nullable();
            $table->unsignedTinyInteger('team_size')->nullable();
            $table->json('team_members')->nullable();

            // تفاصيل المشروع
            $table->text('idea')->nullable();

            // معلومات تقنية للمتابعة
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();

            $table->timestamps();

            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
