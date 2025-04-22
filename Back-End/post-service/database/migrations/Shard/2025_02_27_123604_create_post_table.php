<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = Schema::getConnection()->getName();

        if (! Schema::connection($connection)->hasTable('posts')) {
            Schema::connection($connection)->create('posts', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('title');
                $table->text('body');
                $table->boolean('sticky')->default(false);
                $table->uuid('created_by');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        $connection = Schema::getConnection()->getName();
        Schema::connection($connection)->dropIfExists('posts');
    }
};
