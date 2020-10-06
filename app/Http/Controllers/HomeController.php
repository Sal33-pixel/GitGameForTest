<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index_right_menu()
     {
       $user_count = DB::table('users')->count();
       $main_topics = DB::table('all_topics')->where('parent_id', 0)->count();
       $topics = DB::table('all_topics')->where('parent_id', '>', 0)->count();
       $comment_count = DB::table('comments')->count();

         return [
           'user_count'     => $user_count,
           'main_topics'    => $main_topics,
           'topics'         => $topics,
           'comment_count'  => $comment_count
         ];
     }

    public function index()
    {
        return view('home');
    }
}
