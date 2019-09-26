<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2018 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 *
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

return [
    'info' => [
        'title' => 'Server Information',
        'breadcrumb' => 'Server Information',
    ],
    'about' => [
        'title' => 'About',
        'breadcrumb' => 'About',
        'card' => [
            'title' => [
                'maintenance' => 'The application is down for maintenance!',
                'application' => 'Application Settings',
                'locale' => 'Locale Settings',
                'framework' => 'Framework',
            ],
        ],
        'header' => [
            'formats' => 'Formats',
            'examples' => 'Examples',
        ],
        'label' => [
            'name' => 'Name',
            'environment' => 'Environment',
            'locale' => 'Locale',
            'number' => 'Number',
            'currency' => 'Currency',
            'date' => 'Date',
            'datetime' => 'Datetime',
            'timestamp' => 'Timestamp',
            'time' => 'Time',
            'integer' => 'Integer',
            'float' => 'Float',
        ],
        'text' => [
            'framework' => ':name Version :version',
        ],
    ],
];
