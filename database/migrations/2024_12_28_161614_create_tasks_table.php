<?php

use App\Enum\TaskStatusEnum;
use App\Enum\TaskPriorityEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('due_date');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->enum('priority', TaskPriorityEnum::vals());
            $table->enum('status', TaskStatusEnum::vals());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
