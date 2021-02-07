<?php

namespace App\Http\Controllers\Requests;

use App\Enums\ItemType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PutRequestRequest;
use App\Http\Resources\RequestResource;
use App\Library\Auth;
use App\Models\Request\Request;
use App\Models\Request\RequestStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserRequestController extends Controller
{
    public const RELATIONS = ['status'];

    public function requests(): AnonymousResourceCollection
    {
        return RequestResource::collection(Request::with(self::RELATIONS)->get());
    }

    public function put(PutRequestRequest $request): JsonResponse
    {
        $user = Auth::forceUser();

        $validated = $request->validated();

        $image     = collect($validated['item']['images'])->firstWhere('coverType', 'poster');
        $image_url = $image['url'] ?? '/images/shiba_poster.jpg';

        $tvdb_id = $validated['item']['tvdb_id'] ?? null;
        $tmdb_id = $validated['item']['tmdb_id'] ?? null;

        $type    = null === $tvdb_id ? ItemType::Movie : ItemType::Serie;
        $item_id = null === $tvdb_id ? $tmdb_id : $tvdb_id;

        abort_if(
            Request::where('type', $type)->where('item_id', $item_id)->exists(),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            'Request already exists'
        );

        $request = new Request([
            'type'              => $type,
            'item_id'           => $item_id,
            'text'              => $validated['item']['text'],
            'image_url'         => $image_url,
            'request_status_id' => RequestStatus::REQUEST,
            'created_by'        => $user->id,
            'updated_by'        => $user->id,
        ]);

        $request->save();
        $request->load(self::RELATIONS);

        return response()->json(RequestResource::make($request), Response::HTTP_CREATED);
    }

    public function delete(Request $request): Response
    {
        $user = Auth::forceUser();

        abort_if(! $user->hasRole('admin') && $request->created_by !== $user->id, Response::HTTP_FORBIDDEN);

        return response('', $request->delete() ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
