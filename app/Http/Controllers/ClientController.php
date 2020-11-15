<?php

namespace App\Http\Controllers;

use App\Contracts\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Log as LogAlias;

class ClientController extends Controller
{

    private $logger;

    /**
     * ClientController constructor.
     * @param $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

}



