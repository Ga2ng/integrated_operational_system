<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldLog($request, $response)) {
            return $response;
        }

        ActivityLog::query()->create([
            'user_id' => $request->user()?->id,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'route_name' => $request->route()?->getName(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_payload' => $this->sanitizedPayload($request),
            'description' => $this->description($request),
            'created_at' => Carbon::now(),
        ]);

        return $response;
    }

    private function shouldLog(Request $request, Response $response): bool
    {
        if (! $request->user()) {
            return false;
        }

        if (in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'], true)) {
            return false;
        }

        if ($response->getStatusCode() >= 500) {
            return false;
        }

        return true;
    }

    private function sanitizedPayload(Request $request): array
    {
        return collect($request->except([
            '_token',
            'password',
            'password_confirmation',
            'current_password',
        ]))
            ->take(30)
            ->toArray();
    }

    private function description(Request $request): string
    {
        $routeName = $request->route()?->getName();

        if ($routeName) {
            return sprintf('%s %s', $request->method(), $routeName);
        }

        return sprintf('%s %s', $request->method(), $request->path());
    }
}
