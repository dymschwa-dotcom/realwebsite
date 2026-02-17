<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller {

    public function addFavorite(Request $request) {
        $validator = Validator::make($request->all(), [
            'influencerId' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $influencer = Influencer::active()->where('id', $request->influencerId)->first();

        if (!$influencer) {
            return response()->json(['success' => 'Influencer not found']);
        }

        $brand = auth()->user();

        $exists = Favorite::where('influencer_id', $influencer->id)->where('user_id', $brand->id)->exists();
        if ($exists) {
            return response(['error' => 'Already added favorite list']);
        }

        $favorite                = new favorite();
        $favorite->user_id       = $brand->id;
        $favorite->influencer_id = $influencer->id;
        $favorite->save();

        recentActivity($influencer->username . ' is added in your favorite list', $brand->id);
        return response()->json([
            'success'      => 'Added to favorite list',
            'influencerId' => $influencer->id,
        ]);
    }

    public function favoriteList() {
        $pageTitle = 'My Favorite List';
        $favorites = Favorite::where('user_id', auth()->id())->with(['influencer' => function ($query) {
            $query->withCount('reviews');
        },
        ])->searchable(['influencer:username'])->latest()->paginate(getPaginate());
        return view('Template::user.favorite.list', compact('pageTitle', 'favorites'));
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'influencerId' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $brand = auth()->user();
        Favorite::where('user_id', $brand->id)->where('influencer_id', $request->influencerId)->delete();
        recentActivity('Remove influencer from favorite list', $brand->id);
        return response()->json([
            'success'      => ' Removed from favorite list',
            'remark'       => 'remove',
            'influencerId' => $request->influencerId,
        ]);
    }

    public function remove($id) {
        Favorite::where('user_id', auth()->id())->where('id', $id)->delete();
        $notify[] = ['success', 'Removed from favorite list successfully'];
        return back()->withNotify($notify);
    }
}
