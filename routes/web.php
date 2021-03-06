<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2019 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 *
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use \Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'DMX\Application\Http\Controllers',
    'middleware' => 'web',
    ], function () {
        // about page
        Route::get('/about', 'AboutController@index')->name('about');

        // change current locale page
        Route::get('/locale/{locale}', 'LocaleController@setLocale')->name('setLocale');
    }
);

Route::group([
    'namespace' => 'DMX\Application\Http\Controllers',
    'middleware' => ['web', 'auth'],
    ], function () {
        // PHP information page
        Route::get('/phpinfo', 'AboutController@phpinfo')->name('phpinfo');
    }
);

