<?php

namespace App\Http\Middleware;

use App\Models\ApiLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $response=$next($request);
        $endTime = microtime(true);
        $duration=round(($endTime-$startTime)*1000,2);

        $userId = Auth::id();
        ApiLog::create([
            'user_id'=> $userId,
            'method'=>$request->method(),
            'path'=>$request->path(),
            'full_url'=>$request->fullUrl(),
            'request_payload'=>$this->getRequestPayload($request),
            'response_preview'=>$this->getResponsePreview($response),
            'status_code'=>$response->getStatusCode(),
            'user_agent'=>$request->header('User-Agent'),
            'ip'=>$request->ip(),
            'duration_ms'=>$duration,
            'created_at'=>now(),
        ]);

        Log::channel('api_requests')->info('API Request Logged', [
            'user_id' =>  $userId,
            'method' => $request->method(),
            'path' => $request->path(),
            'status_code' => $response->getStatusCode(),
            'duration_ms' => $duration,
        ]);

        return $response;
    }

    private function getRequestPayload(Request $request)
    {
        $payload = [];

        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            $payload = $request->all();
        }

        unset($payload['password'], $payload['password_confirmation']);

        return $payload;
    }
    private function getResponsePreview(Response $response)
    {
        $content = $response->getContent();

        if (strlen($content) > 1000) {
            return substr($content, 0, 1000) . '...';
        }

        return $content;
    }

}
