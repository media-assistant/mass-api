<?php

namespace App\Http\Controllers\Requests;

use App\Http\Controllers\Controller;
use App\Http\Resources\RequestResource;
use App\Library\Auth;
use App\Models\Request\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminRequestController extends Controller
{
    public function updateStatus(HttpRequest $http_request, Request $request): JsonResource
    {
        $validated = $http_request->validate([
            'status' => 'required|exists:request_statuses,id',
        ]);

        $request->request_status_id = $validated['status'];
        $request->updated_by        = Auth::forceUser()->id;
        $request->save();

        $request->load(UserRequestController::RELATIONS);

        return RequestResource::make($request);
    }
}
