<?php

namespace App\Library;

class Debug
{
    /**
     * @param mixed $data
     */
    public static function dd($data): void
    {
        echo json_encode($data);
        exit();
    }
}
