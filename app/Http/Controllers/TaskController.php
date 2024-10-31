<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskUpdatedNotification;
use Carbon\Carbon;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $query = Task::query();


        if ($request->has('date')) {
            $query->whereDate('due_date', $request->input('date'));
        }

        $tasks = $query->get();
        return response()->json($tasks);
    }

    public function storeAndAssign(Request $request)
    {
       
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'creator_id' => auth()->id(),
        ]);

        
        $user = User::find($request->user_id);

       
        $task->assignee_id = $user->id;
        $task->save();

        
        Notification::send($user, new TaskAssignedNotification($task));

        return response()->json([
            'message' => 'The task was created and assigned successfully.',
            'task' => $task,
        ], 201);
    }



    
    public function update(Request $request, Task $task)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);


        $task->update($request->only('title', 'description', 'due_date'));

        return response()->json($task);
    }

 
    public function updateTaskStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|string|in:completed,pending',
        ]);

      
        $task->status = $request->status;
        $task->save();

        
        if ($task->status == 'completed') {
            Notification::send($task->creator, new TaskUpdatedNotification($task));
        }

        return response()->json(['message' => 'Task status updated successfully.']);
    }

 
    public function getTasksByUser(User $user)
    {
        $tasks = Task::where('assignee_id', $user->id)->get();
        return response()->json($tasks);
    }
}
