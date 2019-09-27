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

use Illuminate\Support\Carbon;
use Fox\Application\Version\VersionManager;
use Illuminate\Contracts\View\View as ViewContract;

class AboutController extends AController
{
    /**
     * @return ViewContract
     */
    public function index(): ViewContract
    {
        $now = Carbon::now();
        $viewData = [
            'framework' => [
                'name' => 'Laravel',
                'version' => app()->version(),
            ],
            'app' => [
                'name' => config()->get('app.name', 'Laravel'),
                'environment' => app()->environment(),
                'locale' => locale(),
                'version' => app(VersionManager::class)->getCurrentVersion(),
            ],
            'examples' => [
                'currentDate' => format_date($now, 'date'),
                'currentDatetime' => format_date($now, 'datetime'),
                'currentTimestamp' => format_date($now, 'timestamp'),
                'currentTime' => format_time($now),
                'positiveInteger' => format_number(123456789),
                'negativeInteger' => format_number(-123456789),
                'positiveFloat' => format_number(123456789.1234),
                'negativeFloat' => format_number(-123456789.1234),
                'positiveCurrency' => format_currency(1150.6348),
                'negativeCurrency' => format_currency(-1150.6348),
            ],
        ];

        return $this->view('about::index', $viewData);
    }

    /**
     * @return ViewContract
     */
    public function phpinfo(): ViewContract
    {
        $allowedServerInformation = [
            'OS',
            'PROCESSOR_ARCHITECTURE',
            'PROCESSOR_IDENTIFIER',
            'PROCESSOR_LEVEL',
            'PROCESSOR_REVISION',
            'GATEWAY_INTERFACE',
            'SERVER_ADDR',
            'SERVER_NAME',
            'SERVER_SOFTWARE',
            'SERVER_PROTOCOL',
            'SERVER_PORT_SECURE',
            'SERVER_PORT',
            'SERVER_ADMIN',
            'SERVER_SIGNATURE',
            'HTTPS',
            'DOCUMENT_ROOT',
            'HTTP_HOST',
        ];

        return view(
            'about::phpinfo',
            [
                'phpInfo' => $this->capturePhpInfo(),
                'serverInfo' => array_intersect_key($_SERVER, array_flip($allowedServerInformation)),
            ]
        );
    }

    /**
     * @return string
     */
    private function capturePhpInfo(): string
    {
        ob_start();
        phpinfo();

        $info = ob_get_contents();
        ob_end_clean();

        return preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $info);
    }
}
