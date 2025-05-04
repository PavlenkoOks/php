<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController
{
    private $jsonPath;

    public function __construct()
    {
        $this->jsonPath = storage_path('app/products.json');
    }

    private function getProducts()
    {
        if (!file_exists($this->jsonPath)) {
            file_put_contents($this->jsonPath, '[]');
        }
        return json_decode(file_get_contents($this->jsonPath), true);
    }

    private function saveProducts($products)
    {
        file_put_contents($this->jsonPath, json_encode($products, JSON_PRETTY_PRINT));
    }

    public function index()
    {
        $products = $this->getProducts();
        return response()->json(['data' => $products], Response::HTTP_OK);
    }

    public function show($id)
    {
        $products = $this->getProducts();
        $product = collect($products)->firstWhere('id', $id);

        if (!$product) {
            return response()->json([
                'error' => 'Product not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $product], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $products = $this->getProducts();
        
        $newProduct = [
            'id' => uniqid(),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price')
        ];

        $products[] = $newProduct;
        $this->saveProducts($products);

        return response()->json(['data' => $newProduct], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $products = $this->getProducts();
        $index = collect($products)->search(function ($product) use ($id) {
            return $product['id'] === $id;
        });

        if ($index === false) {
            return response()->json([
                'error' => 'Product not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $products[$index] = array_merge($products[$index], [
            'name' => $request->input('name', $products[$index]['name']),
            'description' => $request->input('description', $products[$index]['description']),
            'price' => $request->input('price', $products[$index]['price'])
        ]);

        $this->saveProducts($products);

        return response()->json(['data' => $products[$index]], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $products = $this->getProducts();
        $filtered = array_values(array_filter($products, function ($product) use ($id) {
            return $product['id'] !== $id;
        }));

        if (count($filtered) === count($products)) {
            return response()->json([
                'error' => 'Product not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->saveProducts($filtered);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
} 