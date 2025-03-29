<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function test_methodu()
    {
        $user = User::find(10);
        $news = $user->news()->first();
        $images = $news->images()->get();
        dd($user, $news, $images);
    }

    public function create_user(): User
    {
        return User::firstOrCrate([
            'name' => 'Test User',
        ], [
            'email' => 'testuser@github.com',
            'password' => Hash::make('123')
        ]);
    }
}
