<?php
namespace App\Repositories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\ImageInterface;
use Illuminate\Http\JsonResponse;

class ImageRepository implements ImageInterface
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function where(string $name): Collection
    {
        return $this->image::where('name', 'like', "%$name%")->get();
    }

    public function find_by_id(int $id)
    {
        return $this->image::find($id);
    }

    public function find(string $name): JsonResponse
    {
        $image = $this->where($name);

        if(!$image)
        {
            return response()->json([
                'status' => false,
                'message' => 'Image not found'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Image found',
            'data' => $image
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $image = $this->image->find_by_id($id);
        if(!$image)
        {
            return response()->json([
                'status' => false,
                'message' => 'Image not exists'
            ], 400);
        }
        $image->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully'
        ]);
    }

    public function update(int $id, array $data): JsonResponse
    {
        $image = $this->find_by_id($id);
        if(!$image)
        {
            return response()->json([
                'status' => false,
                'message' => 'Image not exists'
            ], 400);
        }
        $image->name = $data['name'] ?? $image->name;
        $image->path = $data['path'] ?? $image->path;

        return response()->json([
            'status' => true,
            'message' => 'Image updated successfully',
        ]);
    }
}