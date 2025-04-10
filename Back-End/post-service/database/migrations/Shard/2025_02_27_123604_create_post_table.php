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
        $shards = config('sharding.connections');
        foreach ($shards as $shard) {
            Schema::connection($shard)->create('posts', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('title');
                $table->text('body');
                $table->boolean('sticky')->default(false);
                $table->uuid('created_by');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $shards = config('sharding.connections');

        foreach ($shards as $shard) {
            Schema::connection($shard)->dropIfExists('posts');
        }
    }
};
