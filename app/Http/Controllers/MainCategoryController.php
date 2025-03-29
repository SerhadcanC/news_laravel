<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Models\Image;

class MainCategoryController extends Controller
{
    public function get_main_categories(int $id=0)
    {
        if($id!=0)
        {
            $main_category = MainCategory::find($id);
        } else {
            $main_category = MainCategory::all();
        }
        return response()->json([
            'status' => true,
            'message' => 'Main categories listed successfully',
            'data' => $main_category
        ], 400);
    }

    public function create_main_category(Request $request)
    {
        $main_category = MainCategory::create([
            'name' => $request->name,
            'slug' => $request->slug
        ], 400);

        return response()->json([
            'status' => true,
            'message' => 'Main category created successfully',
            'data' => $main_category
        ], 400);
    }

    public function update_main_category(Request $request, int $id)
    {
        $main_category = MainCategory::find($id);
        if(!$main_category)
        {
            return response()->json([
                'status' => false,
                'message' => 'Main category not found'
            ], 400);
        }
        $main_category->name = $request->name ?? $main_category->name;
        $main_category->slug = $reqeust->slug ?? $main_category->slug;
        if(isset($request->image_id))
        {
            $image = Image::find($request->image_id);
            if(!$image)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Image not found'
                ], 400);
            }
            $main_category->image_id = $image->id;
        }
        $main_category->save();

        return response()->json([
            'status' => true,
            'message' => 'Main category updated successfully',
            'data' => $main_category
        ], 400);
    }

    public function update_image(Request $request, int $id)
    {
        $main_category = MainCategory::find($id);
        if(!$main_category)
        {
            return response()->json([
                'status' => false,
                'message' => 'Main category not found'
            ], 400);
        }
        $main_category->image_id = $request->image_id ?? $main_category->image_id;
        $main_category->save();

        return response()->json([
            'status' => true,
            'message' => 'Image updated successfully',
            'data' => $main_category
        ], 400);
    }

    public function delete_main_category(Request $request)
    {
        $main_category = MainCategory::find($request->id);
        if(!$main_category)
        {
            return response()->json([
                'status' => false,
                'message' => 'Main category not found'
            ], 400);
        }

        $main_category->delete();
    }
}
