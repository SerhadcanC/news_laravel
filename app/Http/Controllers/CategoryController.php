<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Image;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function get_categories(int $id=0)
    {
        if($id!=0)
        {
            $category = Category::find($id);
        } else {
            $category = Category::all();
        }
        return response()->json([
            'status' => true,
            'message' => 'Categories listed succesfully',
            'data' => $category
        ]);
    }

    public function create_category(CreateCategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'main_category_id' => $request->main_category_id,
            'image_id' => $request->image_id,
            'slug' => $request->slug,
            'title' => $request->title,
            'description' => $request->description
        ]);
    }

    public function update_category(UpdateCategoryRequest $request, int $id)
    {
        $category = Category::find($id);
        
        if(!$category) 
        {
            return response()->json([
                'status' => false,
                'massage' => 'Category not found'
            ],400);
        }

        $category->name = $request->name ?? $category->name;
        $category->description = $request->description ?? $category->description;
        $category->title = $request->title ?? $category->title;
        $category->main_category_id = $request->main_category_id ?? $category->main_category_id;
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
            $category->image_id = $image->id;
        }
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    public function update_image(Request $request, int $id)
    {
        $category=Category::find($id);
        if(!$category)
        {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 400);
        }

        $image = Image::find($request->image_id);
        if(!$image)
        {
            return response()->json([
                'status' => false,
                'message' => 'Image not found'
            ], 400);
        }

        $category->$image_id = $request->$image_id ?? $category->$image_id;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Image updated successfully',
            'data' => $category
        ], 400);
    }

    public function update_main_category(Request $request,int $id)
    {
        $category = Category::find($id);
        
        if(!$category) 
        {
            return response()->json([
                'status' => false,
                'massage' => 'Category not found'
            ],400);
        }

        $main_category = MainCategory::find($request->main_category_id);
        if(!$main_category)
        {
            return response()->json([
                'status' => false,
                'message' => 'Main category not found'
            ],400);
        }
        
        $category->main_category_id = $request->main_category_id ?? $category->main_category_id;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Main category updated successfully',
            'data' => $category
        ]);
    }

    public function delete_category(int $id)
    {
        $category = Category::find($id);

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
