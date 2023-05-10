<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    // show rating in admin:
    function index() {
        $ratings = Rating::paginate(10);
        return view('Admin.admin-rating', [
            'ratings' => $ratings,
        ]);
    }
    // delete rating in admin:
    function destroy(Request $request) {
        $getRow = Rating::find($request->id)->delete();

        if ($getRow == 0) {
            return redirect()->route('Admin.admin-view-rating')->with('unsuccess', 'Delete Unsuccess');
        }

        return redirect()->route('Admin.admin-view-rating')->with('success', 'Delete Success');
    }
    
    
}
