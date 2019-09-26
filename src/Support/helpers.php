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

if (!function_exists('getCaller')) {
    /**
     * @param string|null $function
     * @param array|null  $stack
     *
     * @return array|null
     */
    function getCaller(?string $function = null, ?array $stack = null): ?array
    {
        if ($stack === null) {
            $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 4);
        }

        if ($function === null) {
            // We need $function to be a function name to retrieve its caller. If it is omitted, then we need to first find
            // what function called getCaller(), and substitute that as the default $function.
            // Remember that invoking getCaller() recursively will add another instance of it to the function stack, so tell
            // getCaller() to use the current stack.
            $caller = getCaller(__FUNCTION__, $stack);
            $function = $caller['function'] ?? null;
        }

        if (!empty($function)) {
            for ($i = 0; $i < count($stack); ++$i) {
                $currFunction = $stack[$i];
                // Make sure that a caller exists, a function being called within the main script won't have a caller.
                if ($currFunction['function'] == $function && ($i + 1) < count($stack)) {
                    return [
                        'class' => !empty($stack[$i + 1]['class']) ? $stack[$i + 1]['class'] : null,
                        'function' => !empty($stack[$i + 1]['function']) ? $stack[$i + 1]['function'] : null,
                    ];
                }
            }
        }

        return null;
    }
}
