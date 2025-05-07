<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\View\ProductsView;

readonly class GetProductsController
{
    public function __construct(
        private ProductsView $productsView
    ) {
    }

    public function get(RequestInterface $request): ResponseInterface
    {
        $response = new JsonResponse();

        $rawRequest = json_decode($request->getBody()->getContents(), true);
        $category = $queryParams['category'] ?? null;

        if (empty($category)) {
            $response = new JsonResponse();
            $response->getBody()->write(
                json_encode(
                    [
                        'message' => 'Category not found'
                    ],
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );

            return $response
                ->withHeader('Content-Type', 'application/json; charset=utf-8')
                ->withStatus(404);
        }

        $response->getBody()->write(
            json_encode(
                $this->productsView->toArray($category),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );

        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(200);
    }
}
