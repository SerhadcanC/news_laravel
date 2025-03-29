<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use App\Models\Image;
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
            'url' => Storage::temporaryUrl($request->filename, now()->addSecond($request->second))
        ]);
    }

    public function download(Request $request)
    {
        abort_if(!$this->disk->exists($request->path), 404, 'file not found');
        abort_if(!$request->hasValidSignature(), 403, 'Timeout or invalid signature');
        return Storage::download($request->path);
    }

    public function upload(UploadRequest $request)
    {
        try{
            $path = $request->file('file')->store('uploads/images', $this->disk_name);

            $image_model = Image::create([
                'name' => $request->name,
                'path' => $path
            ]);

            return response()->json([
                'status' => 'success',
                'path' => $path
            ]); 

        } catch (\Exception $e) {
            $this->disk->delete($path);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        
    }

}
