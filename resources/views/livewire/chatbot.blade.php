<div>
    <!-- Bouton du chatbot -->
    <div class="fixed bottom-6 right-6 z-50">
        <button wire:click="toggleChat" 
                class="w-14 h-14 bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 flex items-center justify-center relative group">
            <i class="fas fa-robot text-2xl"></i>
            <span class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-gray-800 text-white text-xs px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none">
                Assistant Santé IA
            </span>
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
        </button>
    </div>

    <!-- Fenêtre du chatbot -->
    @if($isOpen)
    <div class="fixed bottom-24 right-6 z-50 w-80 md:w-96 bg-white rounded-2xl shadow-2xl overflow-hidden transition-all duration-300 transform scale-100 origin-bottom-right">
        
        <!-- En-tête -->
        <div class="bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-sm">Assistant SanteRDV</h3>
                    <p class="text-white/70 text-[10px]">En ligne • Réponse immédiate</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button wire:click="clearChat" class="text-white/70 hover:text-white transition">
                    <i class="fas fa-trash-alt text-xs"></i>
                </button>
                <button wire:click="toggleChat" class="text-white/70 hover:text-white transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <!-- Zone des messages -->
        <div class="h-96 overflow-y-auto p-4 bg-gray-50" x-data x-init="() => {
            $wire.on('scrollToBottom', () => {
                setTimeout(() => {
                    const container = document.querySelector('.overflow-y-auto');
                    if (container) container.scrollTop = container.scrollHeight;
                }, 100);
            });
        }">
            @foreach($messages as $message)
                <div class="mb-3 {{ $message['type'] == 'user' ? 'text-right' : 'text-left' }}">
                    <div class="inline-block max-w-[80%]">
                        <div class="rounded-xl p-3 {{ $message['type'] == 'user' ? 'bg-[#1a6fff] text-white' : 'bg-white shadow-sm border border-gray-100 text-gray-700' }}">
                            <p class="text-sm whitespace-pre-line">{!! nl2br(e($message['content'])) !!}</p>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1 {{ $message['type'] == 'user' ? 'text-right' : 'text-left' }}">
                            {{ $message['time'] }}
                        </p>
                    </div>
                </div>
            @endforeach
            
            @if($isTyping)
                <div class="text-left mb-3">
                    <div class="inline-block bg-white rounded-xl p-3 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-1">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Zone de saisie -->
        <div class="p-3 border-t border-gray-100 bg-white">
            <div class="flex items-center gap-2">
                <input type="text" 
                       wire:model="newMessage" 
                       wire:keydown.enter="sendMessage"
                       placeholder="Écrivez votre message..."
                       class="flex-1 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a6fff] focus:border-transparent">
                <button wire:click="sendMessage" 
                        class="w-10 h-10 bg-[#1a6fff] text-white rounded-xl hover:bg-[#0d5ae0] transition flex items-center justify-center">
                    <i class="fas fa-paper-plane text-sm"></i>
                </button>
            </div>
            <p class="text-[10px] text-gray-400 text-center mt-2">
                <i class="fas fa-shield-alt"></i> Sécurisé • Confidentialité garantie
            </p>
        </div>
    </div>
    @endif
</div>
