<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Auth;
use App\Models\MasterData\Category;
use App\Models\Setting;
use DB;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            //session
            'session' => [
                'status'    => fn () => $request->session()->get('status'),
                'success'   => fn () => $request->session()->get('success'),
                'error'     => fn () => $request->session()->get('error'),
                'failed'     => fn () => $request->session()->get('failed'),
            ],
            'auth'  =>[
                'user' => auth()->user() ? auth()->user() : null,
            ],
            'app' => [
                'url' => config('app.url'),
            ],
            'voucherCategories' => DB::table('categories')->where('development_status', 'production')->orderBy('created_at', 'ASC')->get(),
            'setting' => Setting::first() ?? []
        ]);
    }
}
