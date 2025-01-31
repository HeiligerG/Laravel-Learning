<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-white">{{ __('Community-Management') }}</h2>
    </header>

    @php
        $currentCommunity = auth()->user()->currentCommunity;
    @endphp

    @if($currentCommunity)
        <div class="bg-slate-800/50 rounded-lg border border-slate-700 p-6">
            <h3 class="text-lg font-medium text-white mb-4">{{ __('Aktuelle Community') }}</h3>
            <div>
                <label class="text-sm text-gray-400">Name</label>
                <p class="text-white">{{ $currentCommunity->name }}</p>
                <div class="mt-4">
                    <label class="text-sm text-gray-400">Code</label>
                    <div class="flex items-center gap-2 relative">
                        <input type="text" value="{{ $currentCommunity->code }}"
                               class="w-full bg-slate-900 text-white border-0 rounded px-3 py-2" readonly>
                        <button onclick="navigator.clipboard.writeText('{{ $currentCommunity->code }}')"
                                class="absolute right-0 p-2 text-brandIndigo hover:text-brandIndigo/80 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-6">
        <h3 class="text-lg font-medium text-white mb-4">{{ __('Neue Community beitreten') }}</h3>
        <form action="{{ route('community.switch') }}" method="POST">
            @csrf
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="code"
                       placeholder="Community-Code eingeben"
                       class="w-full px-4 py-3 bg-slate-800/50 text-white placeholder-gray-400 rounded-lg border border-slate-700 focus:border-brandIndigo focus:ring-1 focus:ring-brandIndigo transition-colors">
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 bg-brandIndigo hover:bg-brandIndigo/80 text-white rounded-lg transition-all duration-200 font-medium">
                    Beitreten
                </button>
            </div>
        </form>
    </div>
</section>
