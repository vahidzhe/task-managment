<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDueSoonNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskReminderNotification;
class NotifyTasksDueSoon extends Command
{
    protected $signature = 'tasks:notify-due-soon';
    protected $description = 'Notify users of tasks due soon (within 1 day)';

    public function handle()
    {
        $tasks = Task::where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDay())
            ->where('status', '!=', 'completed')
            ->with('assignee')
            ->get();

        foreach ($tasks as $task) {
            Notification::send($task->assignee, new TaskReminderNotification($task));
        }

        $this->info('Notifications sent for tasks due soon.');
    }
}
