<?php

namespace Kanhaiyanigam05\Http\Controllers;

use Kanhaiyanigam05\Canvas;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ViewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return Application|Factory|View
     */
    public function __invoke()
    {
// dd('dsad');

        return view('canvas::layout')->with([
            'jsVars' => [
                'languageCodes' => Canvas::availableLanguageCodes(),
                'maxUpload' => config('canvas.upload_filesize'),
                'path' => Canvas::basePath(),
                'roles' => Canvas::availableRoles(),
                'timezone' => config('app.timezone'),
                'translations' => Canvas::availableTranslations(request()->user('canvas')->locale),
                'unsplash' => config('canvas.unsplash.access_key'),
                'user' => request()->user('canvas'),
                'version' => Canvas::installedVersion(),
            ],
        ]);
    }
}
