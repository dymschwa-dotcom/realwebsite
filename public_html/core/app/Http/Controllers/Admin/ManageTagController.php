<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class ManageTagController extends Controller {

    public function tags(Request $request) {
        $pageTitle = 'Tags';
        $tags      = Tag::searchable(['name'])->latest()->paginate(getPaginate());
        return view('admin.tags.index', compact('pageTitle', 'tags'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|array|min:1',
        ]);
        $tagName = [];
        foreach ($request->name as $name) {
            $tagExist = Tag::where('name', $name)->exists();
            if ($tagExist) {
                continue;
            }
            $tagName[] = [
                'name'       => $name,
                'created_at' => now(),
            ];
        }
        if (!empty($tagName)) {
            Tag::insert($tagName);
        }

        $notify[] = ['success', 'Tag added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|unique:tags,name,' . $id,
        ]);

        $tag       = Tag::findOrFail($id);
        $tag->name = $request->name;
        $tag->save();

        $notify[] = ['success', 'Tag updated successfully'];
        return back()->withNotify($notify);
    }

    public function status($id) {
        return Tag::changeStatus($id);
    }
}
