<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use App\Models\Image;
use App\Http\Requests\ImageNameRequest;
use App\Http\Requests\ImageIdRequest;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    private $disk_name = 'public';
    private $disk = null;
    public function __construct()
    {
        $this->disk = Storage::disk($this->disk_name);
    }

    public function create_temp_url(Request $request) 
    {
        return response()->json([
            'status' => 'success',
            'url' => Storage::temporaryUrl($request->filename, now()->addMinutes($request->minutes))
        ]);
    }

    public function download(Request $request)
    {
        return Storage::download($request->path);
    }

    public function upload(UploadRequest $request)
    {
        try{
            $year = now()->format('Y');
            $month = now()->format('m');
            $path = $request->file('file')->store("uploads/images/$year/$month", $this->disk_name);

            $image_model = Image::create([
                'name' => $request->name,
                'path' => $path
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Image uploaded successfully',
                'path' => $path
            ]);

        } catch (\Exception $e) {
            $this->disk->delete($path);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function find_by_name(ImageNameRequest $request)
    {
        $images = Image::where('name', 'like', "%$request->name%")->get();
        if($images->isEmpty())
        {
            return response()->json([
                'status' => false,
                'message' => 'Image not found',
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'Image found',
            'path' => $images
        ]);
    }

    public function delete_image(ImageIdRequest $request)
    {
        try
        {
            $image = Image::find($request->id);
            if(!$image)
            {
                throw new \Exception('Image not found', 404);
            }
            $this->disk->delete($image->path);
            $image->delete();
            return response()->json([
                'status' => true,
                'message' => 'Image deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update_image(ImageIdRequest $request)
    {
        try
        {
            $image = Image::find($request->id);
            if(!$image)
            {
                throw new \Exception('Image not found', 404);
            }
            $this->disk->delete($image->path);
            $path = $request->file('file')->store("uploads/images", $this->disk_name);
            $image->path = $path;
            $image->save();
            return response()->json([
                'status' => true,
                'message' => 'Image updated successfully',
                'path' => $path
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
