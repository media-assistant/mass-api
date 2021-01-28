<?php

namespace App\Services\Http\Responses;

use App\Services\Http\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

abstract class BaseResponse implements ResponseInterface
{
    private PsrResponseInterface $response;

    public function __construct(PsrResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse(): PsrResponseInterface
    {
        return $this->response;
    }
}
