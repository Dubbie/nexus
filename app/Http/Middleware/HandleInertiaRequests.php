<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        if ($user) {
            $user->load('roles.permissions');
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
            ],
        ];
    }

    public function isExternal($url)
    {
        $internalHost = parse_url(config('app.url'), PHP_URL_HOST);
        $internalPort = parse_url(config('app.url'), PHP_URL_PORT);

        $host = parse_url($url, PHP_URL_HOST);
        $port = parse_url($url, PHP_URL_PORT);

        return $host !== $internalHost || $port !== $internalPort;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $parentResponse = parent::handle($request, $next);

        $location = $parentResponse->headers->get('Location');

        if ($location && $this->isExternal($location)) {
            if (request()->inertia()) {
                return inertia()->location($location);
            }


            return redirect()->to($location);
        }

        return $parentResponse;
    }
}
