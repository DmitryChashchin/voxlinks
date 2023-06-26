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
        Schema::create('tag_todo', function (Blueprint $table) {
            $table->bigInteger('tag_id')->unsigned();
            $table->bigInteger('todo_id')->unsigned();

           
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('todo_id')->references('id')->on('todos')->onDelete('cascade');

         
            $table->primary(['tag_id', 'todo_id']);

    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_todo');
    }
};
