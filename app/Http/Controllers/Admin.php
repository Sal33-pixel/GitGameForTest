<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\main_topics_name;

class Admin extends Controller
{
    public function __construct()
    {

    }

    public function admin_save_main_topics_name(Request $main_topics_name)
    {
      $data = new main_topics_name();
      $data->topics_name = $main_topics_name->main_topics_name;
      $data->save();
      return response()->json(['success' => 'main_topics_name SAVE']);
    }

    public function admin_save_topics_name(Request $request)
    {
      $data = new main_topics_name();
      $data->topics_name = $request->topics_name;
      $data->parent_id = $request->list_id;
      $data->save();
      return response()->json(['success' => 'topics_name SAVE']);
    }

    public function admin_main_topics_list()
    {
      $topics_list = DB::table('all_topics')->where('parent_id', 0)->select('id','topics_name')->get();
      return response()->json([
        'success' => 'Main list load ok.',
        'topics_list' => $topics_list
    ]);
    }

}
