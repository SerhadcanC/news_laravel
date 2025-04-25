<?php
namespace App\Repositories;

use App\Interfaces\MainCategoryInterface;
use App\Models\MainCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class MainCategoryRepository implements MainCategoryInterface
{
    protected $mainCategory;

    public function __construct(MainCategory $mainCategory)
    {
        $this->mainCategory = $mainCategory;
    }

    public function all(): Collection
    {
        return $this->mainCategory::all();
    }

    public function find(int $id): ?MainCategory
    {
        return $this->mainCategory::find($id);
    }

    public function findOrAll(int $id = 0): JsonResponse
    {
        if($id = 0)
        {
            $mainCategory = $this->all();
        } else {
            $mainCategory = $this->find($id);
        }

        if(!$mainCategory)
        {
            return response()->json([
                'status' => false,
                'message' => 'Main Category not found'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'data' => $mainCategory
        ]);
    }
}