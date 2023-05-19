@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        <div class="d-flex flex-column">
            <h4 class="mb-0">
                {{ $user->name }}'s profile
            </h4>

            <p class="mb-0">
                Joined {{ $user->created_at->diffForHumans() }}
            </p>
        </div>

        <div class="d-flex">
            @can('edit', $user)
                <div class="me-1">
                    <a href="{{ route('profile.edit', $user->name) }}" class="btn btn-primary btn-sm">
                        Edit Profile
                    </a>
                </div>
            @endcan
            
            @auth
                @if(!auth()->user()->is($user))
                    <div class="ms-1">
                        <form action="{{ route('follow.store', $user->name) }}" method="post">
                            @csrf

                            <button type="submit" class="btn btn-light btn-sm">
                                {{ auth()->user()->following($user) ? 'Unfollow' : 'Follow Me' }}
                            </button>   
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <p class="my-2">
        {{ $user->overview }}
    </p>
    
    @include('tweets.timeline')
@endsection