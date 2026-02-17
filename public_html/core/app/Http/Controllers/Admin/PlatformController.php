<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller {
    public function index(Request $request) {
        $pageTitle   = 'All Platform';
        $allPlatform = Platform::orderBy('name')->get();
        return view('admin.platform.index', compact('pageTitle', 'allPlatform'));
    }
    public function status($id) {
        return Platform::changeStatus($id);
    }
}
