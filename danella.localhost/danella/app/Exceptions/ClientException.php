<?php

namespace App\Exceptions;

use CodeIgniter\Debug\BaseExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class ClientException extends BaseExceptionHandler implements ExceptionHandlerInterface
{
    // You can override the view path.
    protected ?string $viewPath = APPPATH . 'Views/404';

    public function handle(
        Throwable $exception,
        RequestInterface $request,
        ResponseInterface $response,
        int $statusCode,
        int $exitCode
    ): void {
        $this->render($exception, $statusCode, $this->viewPath . "error_{$statusCode}.php");

        exit($exitCode);
    }
}