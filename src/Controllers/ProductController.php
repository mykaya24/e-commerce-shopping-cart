<?php

namespace App\Controllers;

use App\Exceptions\DomainException;
use App\Helpers\Response;
use App\Services\ProductService;
use App\Repositories\ProductRepository;
use Throwable;

class ProductController
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService(
            new ProductRepository()
        );
    }

    public function index(array $parameters): void
    {
        try{
            $products = $this->productService->getProducts($parameters);
            Response::success($products,"process done"); 
        } catch (DomainException $e) {
            Response::error(
                $e->getErrorCode(),
                $e->getMessage(),
                $e->getStatusCode()
            );

        } catch (Throwable $e) {
            Response::error(
                'INTERNAL_ERROR',
                'An unexpected error occurred.',
                500
            );
        }
        
    }
    public function show(int $id): void
    {
        try{
            $product = $this->productService->getProductById($id);
            Response::success($product,"process done");
        } catch (DomainException $e) {
            Response::error(
                $e->getErrorCode(),
                $e->getMessage(),
                $e->getStatusCode()
            );

        } catch (Throwable $e) {
            Response::error(
                'INTERNAL_ERROR',
                'An unexpected error occurred.',
                500
            );
        }
    }
    public function getAllCategory(): void
    {
        try{
            $categories = $this->productService->getAllCategory();
            Response::success($categories,"process done");
        } catch (DomainException $e) {
            Response::error(
                $e->getErrorCode(),
                $e->getMessage(),
                $e->getStatusCode()
            );

        } catch (Throwable $e) {
            print_r($e);
            Response::error(
                'INTERNAL_ERROR',
                'An unexpected error occurred.',
                500
            );
        }    
    }
    

}