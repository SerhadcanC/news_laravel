<?php
namespace App\Interfaces;

use App\Models\MainCategory;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;

Interface MainCategoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?MainCategory;
    public function findOrAll(int $id = 0): JsonResponse;
}