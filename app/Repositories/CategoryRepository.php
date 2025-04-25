<?php
namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CategoryRepository implements CategoryInterface
{
    protected $category;
    protected $image;

    public function __construct(Category $category, Image $image)
    {
        $this->category = $category;
        $this->image = $image;
    }

    public function all(): Collection
    {
        return $this->category::all();
    }

    public function find(int $id): ?Category
    {
        return $this->category->find($id);
    }

    public function findOrAll(int $id = 0): JsonResponse
    {
        if($id != 0)
        {
            $category=$this->find($id);
        } else {
            $category=$this->all();
        }
        if($category)
        {
            return response()->json([
                'status' => true,
                'data' => $category
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Category not found'
        ]);
    }

    public function create(array $data)
    {
        $this->category::create($data);
    }

    public function update(int $id, array $data): JsonResponse
    {
        $category = $this->category->find($id);
        if(!$category) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 400);
        }
        $category->name = $data['name'] ?? $category->name;
        $category->description = $data['description'] ?? $category->description;
        $category->title = $data['title'] ?? $category->title;
        $category->main_category_id = $data['main_category_id'] ?? $category->main_category_id;

        if(isset($data['image_id']))
        {
            $image = $this->image->find($data['image_id']);

            if(!$image)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Image not found'
                ], 400);
            }

            $category->image_id = $image->id;
        }
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $category = $this->find($id);

        if(!$category)
        {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 400);
        }
        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}