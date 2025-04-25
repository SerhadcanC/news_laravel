<?php
namespace App\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

Interface CategoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Category;
    public function findOrAll(int $id = 0): JsonResponse;
    public function create(array $data);
    public function update(int $id, array $data): JsonResponse;
    public function delete(int $id): JsonResponse;
}