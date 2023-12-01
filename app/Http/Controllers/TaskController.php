<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if ($request->has('category_id')) {
            $validator = Validator::make( $request->all(), [
                'category_id' => 'required|nullable|exists:App\Models\Category,id',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors()->first());
            }
        }

        $tasks      = Task::where('user_id', Auth::id());
        if ($request->has('category_id')) $tasks = $tasks->where( 'category_id', $request->category_id);

        $tasks = $tasks->orderBy('is_complete', 'asc')
                       ->orderBy('created_at', 'desc')
                       ->paginate(5);
        $categories = Category::getCategoriesForUser();

        return view('tasks', ['tasks' => $tasks ?? null, 'categories' => $categories ?? []]);
    }

    public function createTaskIndex(): View
    {
        return view('create_task', ['categories' => Category::where('user_id', Auth::id())->get()]);
    }


    public function createTask(Request $request): RedirectResponse
    {

        $task_data = $request->all();
        $task_data = Category::setCategoryToData($task_data);

        $validator = Validator::make($task_data, [
            'title' => 'required|string',
            'is_complete' => 'boolean',
            'category_id' => 'nullable|exists:App\Models\Category,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->first());
        }

        $task_data['user_id'] = Auth::id();
        unset($task_data['_token']);
        Task::createTask($task_data);
        return redirect('/');
    }

    public function deleteTask(Request $request): JsonResponse
    {
        $validator = Validator::make( $request->all(), [
            'task_id' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()]);
        }

        $task = Task::find($request->task_id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully', 'redirect' => '/']);
    }

    public function completeTask(Request $request): JsonResponse
    {
        $validator = Validator::make( $request->all(), [
            'task_id' => 'required|exists:tasks,id',
            'is_complete' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()]);
        }

        $task = Task::find($request->task_id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        if ($task->is_complete != $request->is_complete)
            $task->update(['is_complete' => $request->is_complete]);

        return response()->json(['message' => 'Task edited successfully', 'redirect' => '/']);
    }

    public function showTask($id): View
    {
        $validator = Validator::make(['task_id' => $id], [
            'task_id' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails())
        {
            abort(404);
        }
        $task = Task::where('id', $id)->where('user_id', Auth::id())->first();
        $categories = Category::getCategoriesForUser();
        if (!$task) abort(404);
        return view('edit_task', ['task' => $task, 'categories' => $categories]);
    }

    public function updateTask(Request $request, string $id): RedirectResponse
    {
        $task_data       = $request->all();
        $task_data       = Category::setCategoryToData($task_data);
        $task_data['id'] = $id;
        $validator = Validator::make($task_data, [
            'id' => 'required|exists:tasks,id',
            'title' => 'required|string',
            'category_id' => 'exists:App\Models\Category,id'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator->errors()->first());
        }
        $task = Task::where('id', $task_data['id'])->where('user_id', Auth::id())->first();
        $task->update([
           'title' => $task_data['title'],
           'category_id' => $task_data['category_id'] ?? null,
        ]);

        return redirect('/');
    }
}
