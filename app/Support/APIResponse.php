<?php

namespace App\Support;


use Symfony\Component\HttpFoundation\Response;

class APIResponse
{
    private $message;
    private $data;
    private $errors;
    private $status;
    private $attributes;
    private $formatErrors = true;
    static private $instance = null;


    static function newInstance() {
        if (static::$instance === null) {
            static::$instance = new APIResponse();
        }
        return static::$instance;
    }

    function addAttribute(string $attribute, $data) {
        $this->attributes[$attribute] = $data;
        return $this;
    }

    function getAttributes() {
        return $this->attributes ?? [];
    }

    function setStatusErrorConditional() {
        if (!is_array($this->errors)) {
            throw new \Exception("Errors array is empty, set it at first.");
        }
        if (count($this->errors)) {
            $this->setStatusError();
        } else {
            $this->setStatusOK();
        }
        return $this;
    }

    function setStatus(int $status) {
        $this->status = $status;
        return $this;
    }

    function setStatusOK() {
        $this->setStatus(Response::HTTP_OK);
        return $this;
    }

    function setStatusError() {
        $this->setStatus(Response::HTTP_BAD_REQUEST);
        return $this;
    }

    function setStatusUnauthorized() {
        $this->setStatus(Response::HTTP_UNAUTHORIZED);
        return $this;
    }

    function setStatusNotAllowed() {
        $this->setStatus(Response::HTTP_METHOD_NOT_ALLOWED);
        return $this;
    }

    function setStatusNotFound() {
        $this->setStatus(Response::HTTP_NOT_FOUND);
        return $this;
    }

    function setStatusServerError() {
        $this->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        return $this;
    }

    function setStatusAccessDenied() {
        $this->setStatus(Response::HTTP_FORBIDDEN);
        return $this;
    }

    function isOk($message = '') {
        $this->setStatus(Response::HTTP_OK);
        $this->setMessage($message);
        return $this;
    }

    function isError($message = '') {
        $this->setStatus(Response::HTTP_BAD_REQUEST);
        $this->setMessage($message);
        return $this;
    }

    function getStatus() {
        return $this->status;
    }

    function setMessage(string $message) {
        $this->message = $message;
        return $this;
    }

    function getMessage() {
        return $this->message ?? '';
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    function getData() {
        return $this->data ?? [];
    }

    function setErrors(array $errors) {
        $this->errors = $errors;
        return $this;
    }

    function getErrors() {
        $errors = $this->errors ?? [];
        $fullErrors = [];
        if ($this->formatErrors === true) {
            foreach ($errors as $key => $message) {
                $fullErrors[] = [
                    'key' => $key,
                    'value' => $message,
                ];
            }
            return $fullErrors;
        }
        return $errors;
    }

    function formatErrors() {
        $this->formatErrors = true;
        return $this;
    }

    function build() {
        $json = [
            'code'      => (int) $this->getStatus(),
            'message'   => $this->getMessage(),
            'errors'    => $this->getErrors(),
            'data'      => $this->getData(),
        ];
        $this->appendDebug($json);
        $_json = array_merge($json, $this->getAttributes());
        return response()->json($_json, (int) $this->getStatus());
    }

    private function appendDebug(&$json) {
        if (env('APP_API_DEBUG')) {
            $actionParts = explode('@', request()->route()->getActionName());
            $class = $actionParts[0];
            $method = $actionParts[1];
            $reflector = new \ReflectionClass($class);
            $methodReflector = new \ReflectionMethod($class, $method);
            $debug['route'] = [
                'controller' => request()->route()->getAction(),
                'path' => $reflector->getFileName(),
                'method' => $method,
                'line' => $methodReflector->getStartLine()
            ];
        }
        if (isset($debug)) {
            $json['debug'] = $debug;
        }
    }
}
