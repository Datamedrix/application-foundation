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

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\View\View as ViewContract;

class ProfileComposer
{
    /**
     * @var AuthManager
     */
    protected $auth;

    /**
     * ProfileComposer constructor.
     *
     * @param AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param ViewContract $view
     *
     * @return ViewContract
     */
    public function compose(ViewContract $view): ViewContract
    {
        $viewParameters = [
            'isLoggedIn' => false,
            'userName' => null,
            'userEmail' => null,
        ];

        if ($this->auth->guard()->check()) {
            $viewParameters = [
                'isLoggedIn' => true,
                'userName' => $this->auth->guard()->user()->name,
                'userEmail' => $this->auth->guard()->user()->email,
            ];
        }

        return $view->with($viewParameters);
    }
}
