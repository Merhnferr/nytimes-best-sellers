<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\RequestException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {});
    }

    public function render($request, Throwable $e): JsonResponse
    {
        return match (true) {
            $e instanceof ValidationException => $this->renderValidationException($e),
            $e instanceof NotFoundHttpException => $this->renderNotFoundHttpException($e),
            $e instanceof RequestException => $this->renderHttpClientException($e),
            default => $this->renderRegularException($e)
        };
    }

    private function renderValidationException(ValidationException $exception): JsonResponse
    {
        return $this->renderResponse(
            trans('messages.general.invalidDataGiven'),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $exception->errors(),
        );
    }

    private function renderNotFoundHttpException(NotFoundHttpException $exception): JsonResponse
    {
        return $this->renderResponse(
            $exception->getMessage(),
            Response::HTTP_NOT_FOUND,
        );
    }

    private function renderHttpClientException(RequestException $exception): JsonResponse
    {
        return $this->renderResponse(
            trans('messages.nytimes.apiRequestFault'),
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $exception->response->json()
        );
    }

    private function renderRegularException(Throwable $exception): JsonResponse
    {
        return $this->renderResponse($exception->getMessage());
    }

    private function renderResponse(
        string $message,
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        mixed $details = null
    ): JsonResponse {
        return new JsonResponse([
            'data' => [
                'message' => $message,
                'details' => $details,
            ],
        ], $statusCode);
    }
}
