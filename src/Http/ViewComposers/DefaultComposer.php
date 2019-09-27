<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2018 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

namespace DMX\Application\Http\ViewComposers;

use Illuminate\Contracts\View\View as ViewContract;

class DefaultComposer
{
    /**
     * @param ViewContract $view
     *
     * @return ViewContract
     */
    public function compose(ViewContract $view): ViewContract
    {
        $viewParameters = [
            'layout' => config('app-foundation.layout', 'layouts::default'),
            'currentRoute' => [
                'name' => null,
                'uri' => null,
            ],
            'locale' => locale(),
        ];
        $request = request();

        if ($request !== null && $request->route() !== null) {
            $viewParameters = array_merge(
                $viewParameters,
                [
                    'currentRoute' => [
                        'name' => $request->route()->getName(),
                        'url' => $request->url(),
                    ],
                ]
            );
        }

        return $view->with($viewParameters);
    }
}
