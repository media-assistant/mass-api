<?php

namespace App\Services\Http;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

interface ResponseInterface
{
    public function __construct(Response $response);

    public function getResponse(): PsrResponseInterface;

    /**
     * @return mixed
     */
    public function getData();
}
