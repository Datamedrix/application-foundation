<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2019 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

namespace DMX\Application\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use DMX\Application\Intl\LocaleManager;

class LocaleController extends AController
{
    /**
     * @var LocaleManager
     */
    protected $localeManager;

    /**
     * @var string
     */
    protected $redirectTo = '/about';

    /**
     * LocaleController constructor.
     *
     * @param LocaleManager $localeManager
     */
    public function __construct(LocaleManager $localeManager)
    {
        $this->localeManager = $localeManager;
    }

    /**
     * @param string $locale
     *
     * @return RedirectResponse
     */
    public function setLocale(string $locale): RedirectResponse
    {
        $this->localeManager->setLocaleAndPutIntoSession($this->localeManager->createLocale($locale));

        return redirect($this->redirectTo);
    }
}
