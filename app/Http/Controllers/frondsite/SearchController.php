<?php

namespace App\Http\Controllers\frondsite;

use App\Http\Controllers\Controller;

use App\Models\menus;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function searchLive1(Request $request)
    {
        $keyword = $request->input('keyword');

        if ($keyword === '') {
            return response('');
        }

        $menus = menus::where('nama', 'like', "%$keyword%")->get();

        return view('frondsite.partials.result', compact('menus'));
    }
    
    public function searchLive2(Request $request)
    {
        $keyword = $request->input('keyword');

        if ($keyword === '') {
            return response('');
        }

        $menus = menus::where('nama', 'like', "%$keyword%")->get();

        return view('frondsite.partials.result', compact('menus'));
    }
   
}
