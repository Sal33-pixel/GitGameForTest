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
      //sleep(3);
      $data = new main_topics_name();
      $data->topics_name = $main_topics_name->main_topics_name;
      $data->save();
      return response()->json(['success' => 1]);
    }

    public function admin_save_topics_name(Request $topics_name)
    {
      //sleep(3);
      $data = new main_topics_name();
      $data->topics_name = $topics_name->topics_name;
      //$data->parent_id =
      //$data->save();
      return response()->json(['success' => 1]);
    }

    public function admin_main_topics_list()
    {
      $topics_list = DB::table('all_topics')->where('parent_id', 0)->select('id','topics_name')->get();
      return response()->json([
        'success' => 1,
        'topics_list' => $topics_list
    ]);
    }

}
