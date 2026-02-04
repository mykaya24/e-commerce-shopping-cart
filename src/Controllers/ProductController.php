<?php

namespace App\Controllers;

use App\Helpers\Response;

class ProductController
{
    public function index(): void
    {
        Response::success([
            ['id' => 1, 'name' => 'Kalem'],
            ['id' => 2, 'name' => 'Defter'],
        ],"The products were delivered.");
    }
}