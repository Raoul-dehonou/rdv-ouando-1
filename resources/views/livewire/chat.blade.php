<div class="flex flex-col h-full bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
        <h2 class="font-semibold flex items-center">
            <i class="fas fa-comments text-teal-600 mr-2"></i>
            Discussion avec {{ $user->name }}
        </h2>
    </div>

    <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messagesContainer">
        @foreach($chatMessages as $msg)
            <div class="flex {{ $msg['sender_id'] === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%] {{ $msg['sender_id'] === auth()->id() ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-800' }} rounded-2xl px-4 py-2 shadow">
                    @if(!empty($msg['image']))
                        <img src="{{ Storage::url($msg['image']) }}" alt="Image" class="max-w-full rounded-lg mb-2 max-h-48 object-cover">
                    @endif
                    @if(!empty($msg['content']))
                        <p>{{ $msg['content'] }}</p>
                    @endif
                    <p class="text-xs {{ $msg['sender_id'] === auth()->id() ? 'text-teal-100' : 'text-gray-500' }} mt-1">
                        {{ \Carbon\Carbon::parse($msg['created_at'])->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="p-4 border-t bg-gray-50">
        <form wire:submit.prevent="sendMessage" class="flex flex-col gap-2" id="chatForm">
            <div class="flex gap-2">
                <input type="text" 
                       wire:model="newMessage" 
                       id="messageInput"
                       placeholder="Écrivez votre message..."
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-teal-500 focus:border-teal-500"
                       autocomplete="off">
                <label for="imageInput" class="cursor-pointer px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-image"></i>
                </label>
                <input type="file" id="imageInput" wire:model="image" class="hidden" accept="image/*">
                <button type="submit" id="sendButton" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
                    <i class="fas fa-paper-plane"></i> Envoyer
                </button>
            </div>
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @if($image)
                <div class="text-sm text-gray-500">Image sélectionnée : {{ $image->getClientOriginalName() }}</div>
            @endif
        </form>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', function () {
        const container = document.getElementById('messagesContainer');
        const input = document.getElementById('messageInput');
        const button = document.getElementById('sendButton');

        function scrollToBottom() {
            if (container) container.scrollTop = container.scrollHeight;
        }

        scrollToBottom();

        Livewire.on('messageSent', () => {
            scrollToBottom();
            if (input) input.focus();
        });

        if (input) {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (button) button.click();
                }
            });
        }

        const observer = new MutationObserver(function() {
            scrollToBottom();
        });
        if (container) observer.observe(container, { childList: true, subtree: true });
    });

    window.addEventListener('load', function() {
        const container = document.getElementById('messagesContainer');
        if (container) container.scrollTop = container.scrollHeight;
    });
</script>
