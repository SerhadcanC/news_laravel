<?php
namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

Interface ImageInterface
{
    public function find(string $name): JsonResponse;
    public function delete(int $id): JsonResponse;
    public function update(int $id, array $data): JsonResponse;
}