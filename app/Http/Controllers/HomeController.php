<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\main_topics_name;

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

     public function topics_list()
     {
       $topics_array = [];

       $main_topics_list = DB::table('all_topics')->where('parent_id', 0)->select('id','topics_name')->get();

       foreach($main_topics_list as $row){
         $topics_array[$row->topics_name]['count'] = $topics_list = DB::table('all_topics')->where('parent_id', $row->id)->count();
         $topics_array[$row->topics_name]['id'] = $row->id;
       }

       return response()->json([
         'success' => 'Main list load ok.',
         'topics_list' => $topics_array
       ]);
     }

     public function topics_al_list(Request $request)
     {
       //sleep(5);
       $al_topics_list = DB::table('all_topics')->where('parent_id', $request->id)->select('id','topics_name')->get();
       //$al_topics_list = $request->id;
       return response()->json([
         'success'        =>  "Al menü betöltve.",
         'al_topics_list' =>  $al_topics_list
       ]);
     }

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
