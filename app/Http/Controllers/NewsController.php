<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

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
        $user->auth()->user();
        $news = News::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_id' => $request->image_id,
            'category_id' => $request->category_id,
            'slug' => $request->slug,
            'content' => $request->content,
            'user_id' => $user->id
        ], 400);

        return response()->json([
            'status' => true,
            'message' => 'News created successfully',
            'data' => $news
        ], 400);
    }

    public function update_news(Request $request, int $id)
    {
        $news = News::find($id);
        if(!$news)
        {
            return response()->json([
                'status' => false,
                'message' => 'News not found'
            ], 400);
        }
        $news->title = $request->title ?? $news->title;
        $news->description = $request->description ?? $news->description;
        $news->image_id = $request->image_id ?? $news->image_id;
        $news->category_id = $request->category_id ?? $news->category_id;
        $news->slug = $request->slug ?? $news->slug;
        $news->content = $request->content ?? $news->content;
        $news->user_id = $request->user_id ?? $news->user_id;
        $news->save();

        return response()->json([
            'status' => true,
            'message' => 'News updated successfully',
            'data' => $news
        ], 400);
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
