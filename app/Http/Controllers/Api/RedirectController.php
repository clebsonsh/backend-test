<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRedirectRequest;
use App\Http\Requests\UpdateRedirectRequest;
use App\Http\Resources\RedirectResource;
use App\Models\Redirect;
use Illuminate\Http\Response;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RedirectResource::collection(Redirect::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRedirectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRedirectRequest $request)
    {
        $validated = $request->validated();

        Redirect::create($validated);

        return response()->json(['message' => 'Redirect created'], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRedirectRequest  $request
     * @param  \App\Models\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRedirectRequest $request, Redirect $redirect)
    {
        $validated = $request->validated();

        $redirect->update($validated);

        return response()->json(['message' => 'Redirect updated'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Redirect $redirect)
    {
        $redirect->update(['status' => 'inactive']);

        $redirect->delete();

        return response()->json(['message' => 'Redirect deleted'], Response::HTTP_OK);
    }
}
