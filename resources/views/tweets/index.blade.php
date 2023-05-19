@extends('layouts.app')

@section('content')
    
        {{-- store a tweet --}}
        <div class="border border-primary p-2 mb-4 rounded">
            <form action="{{ route('tweets.store') }}" method="POST">
                @csrf

                <textarea 
                    id="textarea"
                    name="body" 
                    maxlength="255"
                    class="w-100 form-control mb-1" 
                    placeholder="What's up?" 
                    rows="4"

                ></textarea>
                    
                <span id="characters">255 </span> Character(s) Remaining <br>

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
            </form>

            @error('body')
                <div class="text-danger mt-2">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>
        
        @include('tweets.timeline')
    
@endsection

@section('scripts')
    <script type="text/javascript">
        const textarea = document.getElementById('textarea');
        const characters = document.getElementById('characters');

        textarea.addEventListener('keyup', () => {
            var maxLength = textarea.maxLength;
            var current   = textarea.value.length;
            var remaining = maxLength - current;

            characters.innerText = remaining;
        });
    </script>
@endsection