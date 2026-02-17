<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index(Request $request) {
        $pageTitle  = 'Categories';
        $categories = Category::searchable(['name'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'categories'));
    }

    public function store(Request $request, $id = 0) {

        $imageValidate = $id ? 'nullable' : 'required';
        $request->validate([
            'name'  => 'required|max:40|unique:categories,name,' . $id,
            'image' => [$imageValidate, new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($id) {
            $category     = Category::findOrFail($id);
            $notification = 'Category updated successfully';
            $oldImage     = $category->image;
        } else {
            $category     = new Category();
            $notification = 'Category added successfully.';
        }

        if ($request->hasFile('image')) {
            try {
                $category->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'), @$oldImage);
            } catch (\Exception $e) {
                $notify[] = ['error', 'Image could not be uploaded'];
                return back()->withNotify($notify);
            }
        }

        $category->name = $request->name;
        $category->slug = slug($request->name);
        $category->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function status($id) {
        return Category::changeStatus($id);
    }
}
