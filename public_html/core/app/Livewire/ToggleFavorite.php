<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Favorite;
use App\Models\Influencer;

class ToggleFavorite extends Component
{
    public $influencerId;
    public $isFavorited = false;

    public function mount($influencerId)
    {
        $this->influencerId = $influencerId;
        
        if (auth()->check()) {
            $this->isFavorited = Favorite::where('user_id', auth()->id())
                                       ->where('influencer_id', $this->influencerId)
                                       ->exists();
        }
    }

    public function toggleFavorite()
    {
        if (!auth()->check()) {
            return redirect()->route('user.login');
        }

        $userId = auth()->id();

        if ($this->isFavorited) {
            Favorite::where('user_id', $userId)
                    ->where('influencer_id', $this->influencerId)
                    ->delete();
            $this->isFavorited = false;
            // Optionally: recentActivity('Remove influencer from favorite list', $userId);
        } else {
            Favorite::create([
                'user_id' => $userId,
                'influencer_id' => $this->influencerId
            ]);
            $this->isFavorited = true;
            
            // Optionally add activity log
            // $influencer = Influencer::find($this->influencerId);
            // recentActivity($influencer->username . ' is added in your favorite list', $userId);
        }
    }

    public function render()
    {
        return view('livewire.toggle-favorite');
    }
}
