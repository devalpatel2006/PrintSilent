<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Illuminate\Support\Facades\Session;

class RecordVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Ignore certain patterns if necessary, e.g. API or assets
        if (!$request->is('api/*') && !$request->is('_debugbar/*')) {
            // Consider checking if this is a new session or every request. 
            // Recording every request might clutter, but the user asked for "visitor record", 
            // usually you track unique visits by session or just all page views.
            // Let's track unique page views.

            $ip = $request->ip();
            $country = null;

            if ($ip) {
                // Check if Cloudflare headers are present
                $country = $request->header('CF-IPCountry');

                if (!$country) {
                    $country = \Illuminate\Support\Facades\Cache::remember('ip_country_' . $ip, now()->addDays(30), function () use ($ip) {
                        try {
                            $response = \Illuminate\Support\Facades\Http::timeout(1)->get("http://ip-api.com/json/{$ip}");
                            if ($response->successful() && $response->json('status') === 'success') {
                                return $response->json('country');
                            }
                        } catch (\Exception $e) {
                            // Silently fail if API is unreachable
                        }
                        return 'Unknown';
                    });
                }
            }

            Visitor::updateOrCreate(
                ['ip_address' => $ip],
                [
                    'country' => $country,
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'session_id' => Session::getId(),
                ]
            );
        }

        return $next($request);
    }
}
