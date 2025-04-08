<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function get_news(int $id=0)
    {
        if($id!=0)
        {
            $news = News::find($id);
        } else {
            $news = News::all();
        }
        if(!$news)
        {
            return response()->json([
                'status' => false,
                'message' => 'News not found'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'News listed successfully',
            'data' => $news
        ], 400);
    }

    public function create_news(Request $request)
    {
        try {
            $user = Auth::user();
            if(!$user)
            {
                throw new \Exception('User not found');
            }

            $image = Image::find($request->image_id);
            if(!$image)
            {
                throw new \Exception('Image not found');
            }

            $news = News::create([
                'title' => $request->title,
                'description' => $request->description,
                'slug' => $request->slug,
                'content' => $request->content,
                'image_id' => $image->id,
                'category_id' => $request->category_id,
                'user_id' => $user->id
            ]);

        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'News not created',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'News created successfully',
            'data' => $news
        ]);
    }

    public function update_news(Request $request, int $id)
    {
        try {
            $news = News::find($id);
            if(!$news)
            {
                throw new \Exception('News not found');
            }

            $news->title = $request->title ?? $news->title;
            $news->description = $request->description ?? $news->description;
            $news->slug = $request->slug ?? $news->slug;
            $news->content = $request->content ?? $news->content;
            if(isset($request->image_id))
            {
                $image = Image::find($request->image_id);
                if(!$image)
                {
                    throw new \Exception('Image not found');
                }
                $news->image_id = $image->id;
            }
            if(isset($request->category_id))
            {
                $category = Category::find($request->category_id);
                if(!$category)
                {
                    throw new \Exception('Category not found');
                }
                $news->category_id = $request->category_id;
            }
            $news->save();

        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'News not updated',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'News updated successfully',
            'data' => $news
        ]);
    }

    public function delete_news(int $id)
    {
        $news = News::find($id);
        if(!$news)
        {
            return response()->json([
                'status' => false,
                'message' => 'News not found'
            ], 400);
        }
        $news->delete();

        return response()->json([
            'status' => true,
            'message' => 'News deleted successfully'
        ], 400);
    }

}
