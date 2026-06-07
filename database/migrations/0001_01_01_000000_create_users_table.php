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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // HAPUS: email dan email_verified_at
            // TAMBAH: username
            $table->string('username')->unique(); 
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // HAPUS bagian password_reset_tokens karena tidak butuh fitur reset password via email
        // Schema::create('password_reset_tokens', function (Blueprint $table) { ... });

        // PENTING: Biarkan bagian ini ada. Ini penanganan Session otomatis oleh Laravel
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        // Schema::dropIfExists('password_reset_tokens'); // Sesuaikan dengan yang dihapus di atas
        Schema::dropIfExists('sessions');
    }
};