<?php

namespace App\Support\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

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
    public function version(Request $request): string|null
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
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'rol' => function () use ($request) {
                    $user = auth()->user();

                    return $user ? [
                        'roles' => $request->user()->getRoleNames(),
                    ] : null;
                },
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'success' => session('success') ?: '',
                'error' => session('error') ?: '',
            ],

            '$t' => [
                'labels' => __('labels'),
                'products' => __('products'),
                'cart' => __('cart'),
                /*'fields' => __('fields'),
                'products' => __('products'),
                'customers' => __('customers'),
                'categories' => __('categories'),
                'cart' => __('cart'),*/
            ],
        ]);
    }
}
