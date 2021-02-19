<?php

namespace App\Observers;

use App\Models\Request\Request;
use App\Models\Request\RequestStatus;
use App\Services\Requests\RequestPutter;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class RequestObserver
{
    public function updated(Request $request): void
    {
        if ($request->wasChanged('request_status_id')) {
            $this->handleStatusChange($request);
        }
    }

    private function handleStatusChange(Request $request): void
    {
        if (RequestStatus::APPROVED === $request->request_status_id) {
            try {
                RequestPutter::put($request);

                $request->request_status_id = RequestStatus::DOWNLOADING;
                $request->save();
            } catch (BadResponseException $exception) {
                $errors = collect(json_decode($exception->getResponse()->getBody()->getContents()));

                if (! $errors->contains(fn (object $error) => Str::contains($error->errorMessage, 'already been added'))) {
                    $this->logError($request, $exception);

                    return;
                }

                $request->request_status_id = RequestStatus::DONE;
                $request->save();
            } catch (Throwable $throwable) {
                $this->logError($request, $throwable);
            }
        }
    }

    private function logError(Request $request, Throwable $throwable): void
    {
        Log::error("Error adding request ({$request->text}): {$throwable->getMessage()}");

        $request->request_status_id = RequestStatus::ERROR;
        $request->save();
    }
}
