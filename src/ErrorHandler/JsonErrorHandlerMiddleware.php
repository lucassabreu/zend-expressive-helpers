<?php

namespace ZendExpressiveHelpers\ErrorHandler;

class JsonErrorHandlerMiddleware implements \Interop\Http\ServerMiddleware\MiddlewareInterface
{
    public function process(
        \Psr\Http\Message\ServerRequestInterface $request,
        \Interop\Http\ServerMiddleware\DelegateInterface $delegate
    ) {
        try {
            $response = $delegate->process($request);
            return $response;
        } catch (Exception\MiddlewareException $e) {
            $content = [
                'status'   => $e->getStatusCode(),
                'message'  => $e->getMessage(),
            ];
            $content = array_merge($e->getAdditionalData(), $content);

            return new \Zend\Diactoros\Response\JsonResponse($content, $e->getStatusCode());
        }
    }
}
