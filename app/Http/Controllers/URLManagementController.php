<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class URLManagementController extends Controller
{
    //
    public function index()
    {
        $urls = Url::all();
        return view('welcome',compact('urls'));
    }

    public function addURL(Request $request)
    {
        $url =  new Url;
        $url->short_code = Str::random(5);
        $url->url = $request->url;
        $url->last_visited_time = Carbon::now();
        $url->save();
        $urls = Url::all();
        return redirect()->back();
    }

    public function visitUrl($id)
    {
        $url = Url::find($id);
        $url->last_visited_time = Carbon::now();
        $url->visit_count = ($url->visit_count ?? 0) + 1;
        $url->save();
        return Redirect::to($url->url.'/'.$url->short_code);
    }
}
