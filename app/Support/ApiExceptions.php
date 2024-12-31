<?php

namespace App\Support;


use Illuminate\Auth\AuthenticationException;
use Mockery\Exception\BadMethodCallException;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ApiExceptions
{

    public static function apiException($e)
    {
        if ($e instanceof NotFoundHttpException) {
            return (new APIResponse())->setMessage(__('api.not_found'))
                // ->setErrors([
                //     'url' => __('api.This route not found')
                // ])
                ->setStatusNotFound()
                ->build();
            //return APIResponse::apiResponse([], __('api.not_found'), [], 404);
        }

        if ($e instanceof BindingResolutionException) {
            return (new APIResponse())->setMessage(__('api.server_error'))
                ->setErrors([
                    'error' => $e->getMessage()
                ])->setStatusServerError()
                ->build();
            //return APIResponse::apiResponse([], __('api.server_error'), [], 500);
        }

        if ($e instanceof ModelNotFoundException) {
            $message = array_reverse(explode('\\', $e->getMessage()));
            $message = explode(']', $message[0]);
            dd('as');
            return (new APIResponse())->setMessage(__('api.This :MODEL not found', ['MODEL' => $message[0]]))
                ->setStatusNotFound()
                ->build();
            //return APIResponse::apiResponse([], __('api.not_found'), [], 404);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return (new APIResponse())->setMessage(__('api.not_allowed_method'))
                ->setErrors([
                    'method' => __('api.This Method Not Allowed Here')
                ])
                ->setStatusNotAllowed()
                ->build();
            //return APIResponse::apiResponse([], __('api.not_allowed_method'), [], 405);
        }

        if ($e instanceof RouteNotFoundException) {
            return (new APIResponse())->setMessage(__('api.not_found_route'))
                ->setErrors([
                    'url' => __('api.This route not found')
                ])
                ->setStatusNotFound()
                ->build();
            //return APIResponse::apiResponse([], __('api.not_found_route'), [], 500);
        }

        if ($e instanceof AuthenticationException) {
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return (new APIResponse())->setMessage(__('api.unauthenticated'))
                    ->setStatusUnauthorized()
                    ->build();
            }
            //return APIResponse::apiResponse([], __('api.unauthenticated'), [], 401);
        }

        if ($e instanceof AccessDeniedHttpException) {
            return (new APIResponse())
                ->setMessage(__('api.this_action_is_unauthorized'))
                // ->setErrors($e->errors())
                ->setStatusAccessDenied()
                ->build();
            //return APIResponse::apiResponse([], __('api.this_action_is_unauthorized'), [], 403);
        }

        if ($e instanceof BadMethodCallException) {
            return (new APIResponse())
                ->setMessage(__('api.not_allowed_method'))
                // ->setErrors($e->errors())
                ->setStatusAccessDenied()
                ->build();
            //return APIResponse::apiResponse([], __('api.not_allowed_method'), [], 403);
        }
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return (new APIResponse())->setMessage(__('api.missing_data'))
                ->setErrors($e->errors())
                ->setStatus(422)
                ->build();
        }

        if ($e instanceof UserNotFound) {
            return (new APIResponse())->setMessage(__('api.missing_data'))
                ->setErrors([
                    'uid' => __('api.not_found')
                ])
                ->setStatus(422)
                ->build();
        }
    }
}
