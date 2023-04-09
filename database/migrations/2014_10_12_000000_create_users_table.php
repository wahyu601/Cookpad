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
        Schema::create('user', function (Blueprint $table) {
            $table->id(); //kolom id, format integer primary key autoincrement
            $table->string('nama');
            $table->string('email')->unique(); //kolom email, format varchar bersifat unik
            $table->enum('role',['admin','user'])->default('user'); //kolom role, format enum (pilihan) dengan nilai bawaan "user"
            $table->string('password'); //kolom password format varchar
            $table->string('email_validate')->nullable(); //kolom email_validate, format varchar
            $table->enum('status',['aktif','non-aktif'])->default('non-aktif'); //kolom status, format enum (pilihan) dengan nilai bawaan "non-aktif"
            $table->dateTime('last_login'); // kolom last_login, format dateTime (mirip timestamp)
            $table->timestamps(); //kolom created_at dan update_at, format timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
