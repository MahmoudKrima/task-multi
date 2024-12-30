<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Console\Command;
use App\Events\TaskReminderEvent;
use App\Notifications\DueDateReminderNotification;

class SendDueDateReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-due-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for tasks due in the next 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::whereDate('due_date', '>=', Carbon::today())
                     ->whereDate('due_date', '<=', Carbon::tomorrow())
                     ->with('users')
                     ->get();

        foreach ($tasks as $task) {
            if ($task->users->isEmpty()) {
                continue;
            }

            foreach ($task->users as $user) {
                $data = [
                    'user_id' => $user->id,
                    'task_title' => $task->title,
                    'due_date' => $task->due_date->toDateString(),
                    'message' => "Reminder: Your task '{$task->title}' is due tomorrow.",
                ];
                $user->notify(new DueDateReminderNotification($task));
                event(new TaskReminderEvent($data));
            }
        }

        $this->info('Due date reminders sent successfully.');
    }
}
