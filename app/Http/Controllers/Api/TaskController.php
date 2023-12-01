<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();

        return $this->sendResponse(TaskResource::collection($tasks), 'Tasks retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $task_data = $request->all();
        $task_data = Category::setCategoryToData($task_data);
        $validator = Validator::make($task_data, [
            'title' => 'required|string',
            'is_complete' => 'boolean',
            'category_id' => 'nullable|exists:App\Models\Category,id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $task_data['user_id'] = Auth::id();
        $task = Task::create($task_data);

        return $this->sendResponse(new TaskResource($task), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validator = Validator::make(['task_id' => $id], [
            'task_id' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Product not found.');
        }

        return  $this->sendResponse(new TaskResource($task), 'Task retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $task_data = $request->all();
        $task_data = Category::setCategoryToData($task_data);
        $validator = Validator::make( $task_data, [
            'title' => 'required|string',
            'category_id' => 'exists:App\Models\Category,id'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task = Task::find($id);
        $task->update([
            'title' => $task_data['title'],
            'category_id' => $task_data['category_id'] ?? null
        ]);

        return $this->sendResponse(new TaskResource($task), 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task = Task::find($id);
        $task->delete();

        return $this->sendResponse([], 'Task deleted successfully.');
    }
}
