<?php

namespace App\Http\Controllers;

use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use App\Models\Image;
use App\Http\Requests\ImageNameRequest;
use App\Http\Requests\ImageIdRequest;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    protected $imageRepository;
    private $disk_name = 'public';
    private $disk = null;
    public function __construct(ImageRepository $imageRepository)
    {
        $this->disk = Storage::disk($this->disk_name);
        $this->imageRepository = $imageRepository;
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
        return $this->imageRepository->find($request->name);
    }

    public function delete_image(ImageIdRequest $request)
    {
        $this->imageRepository->delete($request->id);
    }

    public function update_image(ImageIdRequest $request)
    {
        $this->imageRepository->update($request->id, $request->all());
    }

}
