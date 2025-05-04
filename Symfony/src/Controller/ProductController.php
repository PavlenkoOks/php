<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    private string $storagePath = __DIR__ . '/../../var/data/products.json';

    #[Route('/products', name: 'product_list', methods: [Request::METHOD_GET])]
    public function list(): JsonResponse
    {
        $items = $this->fetchAll();
        return $this->json(['data' => $items]);
    }

    #[Route('/products/{uid}', name: 'product_single', methods: [Request::METHOD_GET])]
    public function fetchOne(string $uid): JsonResponse
    {
        $items = $this->fetchAll();
        $entry = $this->locateById($uid, $items);

        if (!$entry) {
            return $this->json(['error' => "No product with ID {$uid} found"], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['data' => $entry]);
    }

    #[Route('/products', name: 'product_add', methods: [Request::METHOD_POST])]
    public function add(Request $req): JsonResponse
    {
        $payload = json_decode($req->getContent(), true);
        $items = $this->fetchAll();

        if (empty($payload['name'])) {
            return $this->json(['error' => 'Name field is mandatory'], Response::HTTP_BAD_REQUEST);
        }

        $entry = [
            'id' => uniqid(),
            'name' => $payload['name'],
            'description' => $payload['description'] ?? '',
        ];

        $items[] = $entry;
        $this->persist($items);

        return $this->json(['data' => $entry], Response::HTTP_CREATED);
    }

    #[Route('/products/{uid}', name: 'product_edit', methods: [Request::METHOD_PUT, Request::METHOD_PATCH])]
    public function edit(string $uid, Request $req): JsonResponse
    {
        $items = $this->fetchAll();
        $pos = $this->locateIndex($uid, $items);

        if ($pos === null) {
            return $this->json(['error' => "Cannot update; product with ID {$uid} not found"], Response::HTTP_NOT_FOUND);
        }

        $update = json_decode($req->getContent(), true);
        $items[$pos]['name'] = $update['name'] ?? $items[$pos]['name'];
        $items[$pos]['description'] = $update['description'] ?? $items[$pos]['description'];

        $this->persist($items);

        return $this->json(['data' => $items[$pos]]);
    }

    #[Route('/products/{uid}', name: 'product_remove', methods: [Request::METHOD_DELETE])]
    public function remove(string $uid): JsonResponse
    {
        $items = $this->fetchAll();
        $pos = $this->locateIndex($uid, $items);

        if ($pos === null) {
            return $this->json(['error' => "Product with ID {$uid} does not exist"], Response::HTTP_NOT_FOUND);
        }

        array_splice($items, $pos, 1);
        $this->persist($items);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    private function fetchAll(): array
    {
        if (!is_file($this->storagePath)) {
            return [];
        }

        $json = file_get_contents($this->storagePath);
        return json_decode($json, true) ?? [];
    }

    private function persist(array $entries): void
    {
        file_put_contents($this->storagePath, json_encode($entries, JSON_PRETTY_PRINT));
    }

    private function locateById(string $uid, array $entries): ?array
    {
        foreach ($entries as $entry) {
            if ($entry['id'] === $uid) {
                return $entry;
            }
        }
        return null;
    }

    private function locateIndex(string $uid, array $entries): ?int
    {
        foreach ($entries as $i => $entry) {
            if ($entry['id'] === $uid) {
                return $i;
            }
        }
        return null;
    }
}
