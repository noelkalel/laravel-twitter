<div>
    <div class="border border-primary p-2 mb-4 rounded">
        <form wire:submit.prevent="store">
            <textarea 
                id="textarea"
                class="w-100 form-control mb-1" 
                placeholder="What's up?" 
                rows="4"
                wire:model="body"
                wire:keyup="charactersRemaining" 
            ></textarea>
                
            <span id="characters">{{ $characters }}</span> Character(s) Remaining <br>

            <div class="d-flex justify-content-between mt-1">
                <img 
                    src="{{ auth()->user()->avatar }}" 
                    alt="user-avatar"
                    class="rounded-circle mr-2" 
                    width="40" 
                    height="40">

                <button type="submit" class="btn btn-primary btn-sm">
                    Tweet Me
                </button>
            </div>

            @error('body')
                <div class="text-danger mt-2">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </form>
    </div>

    @if($tweets->count() > 0)
        @foreach($tweets as $tweet)
            <div class="border border-gray p-2 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                            <a href="{{ route('profile.show', $tweet->user->name) }}">
                                <img 
                                    src="{{ $tweet->user->avatar }}" 
                                    alt="user-avatar"
                                    class="rounded-circle me-2" 
                                    width="40" 
                                    height="40">
                            </a>
                        <h4 class="mb-0">
                            <a href="{{ route('profile.show', $tweet->user->name) }}" class="text-decoration-none text-dark">
                                {{ $tweet->user->name }}
                            </a>  
                        </h4>
                    </div>
                    <small>
                        {{ $tweet->created_at->diffForHumans() }}
                    </small>
                </div>

                <p class="my-2">
                    {{ $tweet->body }}
                </p>

                <div class="d-flex">
                    <button 
                        type="submit" 
                        class="btn btn-outline-primary me-2"
                        wire:click="like({{ $tweet->id }})"
                    >
                        <i class="fa fa-thumbs-up"></i> {{ $tweet->likes ? : 0 }}
                    </button>

                    <button 
                        type="submit" 
                        class="btn btn-outline-secondary me-2"
                        wire:click="dislike({{ $tweet->id }})"
                    >
                        <i class="fa fa-thumbs-down"></i> {{ $tweet->dislikes ? : 0 }}
                    </button>

                    @can('delete', $tweet)
                        <button 
                            type="submit" 
                            class="btn btn-outline-danger"
                            wire:click="delete({{ $tweet->id }})"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    @endcan
                </div>
            </div>
        @endforeach
    @else
        <p>No tweets atm!</p>
    @endif

    {{ $tweets->links() }}
</div>
