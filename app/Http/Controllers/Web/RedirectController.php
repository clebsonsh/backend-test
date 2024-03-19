<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use App\Helpers\UrlParser;

class RedirectController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Redirect $redirect)
    {
        if (!$redirect->isActive()) {
            abort(404, 'Redirect not found');
        }

        $redirect->logs()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer' => request()->header('referer') ?? '',
            'query_params' => UrlParser::getQueryStringFromArray(request()->query()),
        ]);

        $redirect->update(['last_accessed_at' => now()]);

        $redirectUrl = UrlParser::buildUrl($redirect->url, request()->query());

        return redirect()->away($redirectUrl);
    }
}
