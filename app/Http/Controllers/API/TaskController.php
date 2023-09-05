<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Notification;
use App\Http\Controllers\API\BaseController as BaseController;
class TaskController extends BaseController
{
    /* Create New Task */
    function createTask(Request $request) {
        $data = $request->except(['images'],$request->all());
        $data['customer_id']= auth()->user()->id;
        $service_provider = User::select('name')->where('id',$request->service_provider_id)->first();
        $data['status']='booked';
        $task = Task::create($data);
        $task['service_provider_name'] =$service_provider->name??null;
        Notification::create([
            'user_id'=> $task->customer_id,
            'task_id'=> $task->id,
            'type'=> 'booking',
            'description'=> 'Your Have Book '.$task['service_provider_name'],
        ]);

        return $this->sendResponse($task, 'Task Created successfully.');

    }
}
