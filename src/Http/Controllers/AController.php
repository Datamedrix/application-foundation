<?php

namespace DMX\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use DMX\Application\Http\Support\ViewData;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller.
 */
abstract class AController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Container for view data.
     *
     * @var ViewData|null
     */
    private $viewData = null;

    /**
     * Namespace where your views are located.
     *
     * @var string|null
     */
    protected $viewNamespace = null;

    /**
     * @var bool|null
     */
    private $isTheDebugBarAvailable = null;

    /**
     * @return ViewData
     */
    protected function viewData(): ViewData
    {
        if ($this->viewData === null) {
            $this->viewData = new ViewData();
        }

        return $this->viewData;
    }

    /**
     * @return bool
     */
    protected function isTheDebugBarAvailable(): bool
    {
        if ($this->isTheDebugBarAvailable === null) {
            $this->isTheDebugBarAvailable = false;
            if (config('app.debug') === true && app()->environment() === 'local') {
                $this->isTheDebugBarAvailable = app()->has('Barryvdh\Debugbar\LaravelDebugbar');
            }
        }

        return $this->isTheDebugBarAvailable;
    }

    /**
     * Determines the view directory name based on the given controller name.
     *
     * Example:
     * - Controller-Class: FooController
     * ---> foo
     *
     * @param string $controllerName
     *
     * @return string
     */
    protected function determineViewDirectoryName(string $controllerName): string
    {
        if (($strPos = strrpos($controllerName, 'Controller')) !== false) {
            if ($strPos + 10 === strlen($controllerName)) {
                $controllerName = substr($controllerName, 0, -10);
            }
        }

        return lcfirst($controllerName);
    }

    /**
     * Determines the view name based on the given method name.
     *
     * Example:
     * - Controller-Class: FooController
     * - Method-Name: bar()
     * ---> foo.bar
     *
     * @param string $methodName
     *
     * @return string
     */
    protected function determineViewName(string $methodName): string
    {
        $controllerName = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, get_called_class());
        $controllerName = basename($controllerName);

        return $this->determineViewDirectoryName($controllerName) . '.' . $methodName;
    }

    /**
     * Returns a view response.
     * If the the view name is empty the name will be determined based on the controller and method name which called view().
     *
     * Example:
     * - Controller-Class: FooController
     * - Method which called view(): bar()
     * ---> foo.bar
     *
     * @param string|null $viewName
     * @param array       $viewData
     *
     * @return ViewContract
     */
    protected function view(?string $viewName = null, array $viewData = []): ViewContract
    {
        $viewData = array_merge([
                'viewData' => $this->viewData(),
            ],
            $viewData
        );

        if ($viewName === null) {
            $viewName = $this->determineViewName(getCaller()['function'] ?? 'UNKNOWN');
        }

        if (is_file($viewName)) {
            return view()->file($viewName, $viewData);
        }

        if ($this->viewNamespace !== null) {
            $viewName = trim($this->viewNamespace) . '::' . $viewName;
        }

        return view($viewName, $viewData);
    }

    /**
     * Returns a JSON response.
     *
     * @param array $data
     * @param int   $httpStatus
     * @param array $headers
     * @param int   $options
     *
     * @return JsonResponse
     */
    protected function json(array $data, int $httpStatus = HttpResponse::HTTP_OK, array $headers = [], int $options = 0): JsonResponse
    {
        return response()->json($data, $httpStatus, $headers, $options);
    }

    /**
     * Create an error response. (=aborting the data processing).
     *
     * @param string $message
     * @param int    $httpErrorCode
     * @param array  $headers
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function error(string $message, int $httpErrorCode = HttpResponse::HTTP_INTERNAL_SERVER_ERROR, array $headers = [])
    {
        abort($httpErrorCode, $message, $headers);
    }

    /**
     * Adds a message to the MessagesCollector of the LaravelDebugbar if your are run your application on the 'local' environment.
     *
     * The barryvdh/laravel-debugbar package is required.
     * If this package is not installed, your message will be forwarded to dev/null!
     *
     * @param mixed  $message A message can be anything from an object to a string.
     * @param string $label   'emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug' or 'log'
     */
    protected function debugBar($message, string $label = 'info')
    {
        if ($this->isTheDebugBarAvailable() === true) {
            try {
                /** @var \Barryvdh\Debugbar\LaravelDebugbar $debugBar */
                $debugBar = app(\Barryvdh\Debugbar\LaravelDebugbar::class);
                $debugBar->addMessage($message, $label);
            } catch (\Exception $exception) {
                error_log('Try to add some message to the debug bar, but the related package is not available/installed!');
            }
        }
    }
}
