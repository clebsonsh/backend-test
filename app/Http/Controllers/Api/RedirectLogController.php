<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RedirectLogResource;
use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectLogController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Redirect $redirect)
    {
        return RedirectLogResource::collection($redirect->logs);
    }
}
