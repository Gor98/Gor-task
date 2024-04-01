<div class="card my-3 border-0 ">
    <div class="card-body">
        <p class="card-text"> Reply: {{ $message->message }}</p>
        @if ($message->replies->isNotEmpty())
            <div class="nested-replies">
                @foreach ($message->replies as $reply)
                    @include('partials.message_row', ['message' => $reply])
                @endforeach
            </div>
        @endif
    </div>
</div>