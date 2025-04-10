<?php

use App\Models\Post;
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
        Schema::create('likes', function (Blueprint $table) {
            $table->uuid('user_id'); // UUID for the user
            $table->foreignIdFor(Post::class, 'post_id');
            $table->boolean('is_like')->default(true); // Boolean for like (true) or dislike (false)
            $table->timestamps();


            $table->primary(['user_id', 'post_id']); // Composite primary key to prevent duplicate entries for the same user/post pair
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
