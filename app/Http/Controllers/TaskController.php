<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\HttpResponse;

use Auth;

class TaskController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         
        return TaskResource::collection(
            Task::where("user_id",Auth::user()->id)->get()
        );
    }

  
    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());
        $task = Task::create([
            "user_id"=>Auth::id(),
            "name"=>$request->name,
            "description"=>$request->description,
            "priority"=>$request->priority,
        ]);
        return new TaskResource($task);
    }

   
    

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if(Auth::user()->id!==$task->user_id){
            return $this->error("","You are not authorized to make this request",403);
        }
        
        return new TaskResource($task);

    }

    /**
     * Show the form for editing the specified resource.
     */
     

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if(Auth::user()->id !== $task->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }

        $task->update($request->all());

        return new TaskResource($task);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Task $task)
    {
        if(Auth::user()->id !== $task->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }

        $task->delete();

        return response(null,200);
    }
}
