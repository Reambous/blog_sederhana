<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total data
        $totalBlogs = Blog::count();
        $totalTags = Tag::count();
        $totalComments = Comment::count();

        // Mengambil 5 komentar terbaru untuk ditampilkan di dashboard
        $recentComments = Comment::with('blog')->latest()->take(5)->get();

        return view('dashboard.index', compact('totalBlogs', 'totalTags', 'totalComments', 'recentComments'));
    }
}
