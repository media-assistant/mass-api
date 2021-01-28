<?php

namespace App\Services\Http\Responses;

class StringResponse extends BaseResponse
{
    public function getData(): string
    {
        return $this->getResponse()->getBody()->getContents();
    }
}
