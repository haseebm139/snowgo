<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Notification;
use App\Http\Controllers\API\BaseController as BaseController;

class ServiceProviderController extends BaseController
{
    function reviews(){
        try {

            $reviews = Task::where('service_provider_id',auth()->user()->id)->select('id','stars','review')->whereNotNull('stars')
            ->whereNotNull('review')->get();
            if (!isset($reviews[0])) {
                return $this->sendError('Reviews Not Found');
            }
            return $this->sendResponse($reviews, '');
        } catch (\Throwable $e) {
            return $this->sendError('Some thing went worng contact with Admin');
        }

    }
}
