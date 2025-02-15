@foreach ($chats as $chat)
        <li class="mb-3 {{ $chat->sender === $me ? 'my-message' : 'message' }}">
            <div class="chat-box rounded">
                <p class="mb-1">
                    @nl2br($chat->message) 
                </p>
            </div>
            <i class="fa-solid fa-sort-down"></i>
        </li>
@endforeach
