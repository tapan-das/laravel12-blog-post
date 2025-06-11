<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPages;
use App\Models\BlogComments;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = BlogPages::latest()->paginate(6);
        //dd($posts);
        //$post = BlogPages::where('slug', $slug)->with('comments')->firstOrFail();
        return view('welcome', compact('posts'));
        //return view('home');
    }
    public function show($slug)
    {             
        $blogcontent = BlogPages::where('page_slug', $slug)
                        ->firstOrFail();
                        
        $userdetails = BlogComments::where('blog_page_id',$blogcontent->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('blogdetails', compact('blogcontent','userdetails'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        BlogComments::create([
            'blog_page_id' => $request->blog_page_id,
            'user_name' => $request->name,
            'user_email' => $request->email,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Your comment has been posted.');
    }

}
