<?php

namespace App\Http\Livewire;

use App\Models\Tweet;
use Livewire\Component;

class Tweets extends Component
{
    public $body;
    public $characters = 255;

    protected $rules = [
        'body' => 'required|string|max:255|min:3'
    ];

    public function charactersRemaining()
    {
        $this->characters = 255 - strlen($this->body);
    }

    public function store()
    {
        $this->validate();  

        auth()->user()->tweets()->create([
            'body' => $this->body
        ]);

        $this->dispatchBrowserEvent('toastr:success', [
            'message' => 'Tweet Published!'
        ]);

        $this->body = '';
        $this->characters = 255;
    }

    public function like($id)
    {
        $tweet = Tweet::findOrFail($id);

        if($tweet->isLikedByOwner()){
            $tweet->isLikedByOwner()->delete();

            $this->dispatchBrowserEvent('toastr:success', [
                'message' => 'Your like was removed!'
            ]);
        } else {
            $tweet->like();

            $this->dispatchBrowserEvent('toastr:success', [
                'message' => 'Tweet Liked!'
            ]);
        }        
    }

    public function dislike($id)
    {
        $tweet = Tweet::findOrFail($id);

        if($tweet->isDislikedByOwner()){
            $tweet->isDislikedByOwner()->delete();

            $this->dispatchBrowserEvent('toastr:success', [
                'message' => 'Your dislike was removed!'
            ]);
        } else {
            $tweet->dislike();

            $this->dispatchBrowserEvent('toastr:success', [
                'message' => 'Tweet Disliked!'
            ]);
        }
    }

    public function delete($id)
    {
        $tweet = Tweet::findOrFail($id);

        $tweet->delete();

        $this->dispatchBrowserEvent('toastr:success', [
            'message' => 'Tweet Deleted!'
        ]);
    }

    public function render()
    {
        $tweets = auth()->user()->timeline();

        return view('livewire.tweets', compact('tweets'));
    }
}
