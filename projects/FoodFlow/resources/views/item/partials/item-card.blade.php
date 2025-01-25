@php
    $expirationDate = $item->expiration_date;
    $isExpired = $expirationDate < now();
    $daysUntilExpiration = now()->diffInDays($expirationDate, false);
    $isExpiringSoon = !$isExpired && $daysUntilExpiration <= 7 && $daysUntilExpiration >= 0;
    $statusColor = $isExpired ? 'bg-red-500' : ($isExpiringSoon ? 'bg-amber-400' : 'bg-emerald-400');
    $statusText = $isExpired ? 'Abgelaufen' : ($isExpiringSoon ? 'Bald ablaufend' : '');
    $borderColor = $isExpired ? 'border-red-500/30' : ($isExpiringSoon ? 'border-amber-400/30' : 'border-brandIndigo/30');
@endphp

<a href="{{ route('foodItems.show', $item) }}" class="block">
    <div class="bg-darkCard rounded-xl shadow-xl border {{ $borderColor }} hover:border-brandIndigo transition-all duration-300 group">
        <div class="p-5">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-bold text-white group-hover:text-brandIndigo transition-colors">{{ $item->name }}</h3>
                @if($statusText)
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }} text-brandDark shadow-lg">
                        {{ $statusText }}
                    </span>
                @endif
            </div>

                        <div class="space-y-3 text-gray-300">
                            <div class="flex items-center gap-2">
                                <span class="text-brandIndigo">•</span>
                                <span class="text-sm">{{ $item->category->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-brandIndigo">•</span>
                                <span class="text-sm">{{ $item->location->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-brandIndigo">•</span>
                                <span class="text-sm">{{ $expirationDate->format('d.m.Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-brandIndigo">•</span>
                                <span class="text-sm">{{ $item->quantity }}</span>
                            </div>
                        </div>

                        <div class="mt-3 flex justify-center">
                            <form action="{{ route('foodItems.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-red-500 hover:text-white py-2.5 px-4 rounded-lg transition-all duration-300 flex items-center justify-center gap-2 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Löschen
                                </button>
                            </form>
                            <form action="{{ route('foodItems.edit', $item) }}">
                                @csrf
                                @method('UPDATE')
                                <button type="submit" class="w-full text-white-500 hover:text-white py-2.5 px-4 rounded-lg transition-all duration-300 flex items-center justify-center gap-2 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Editieren
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </a>
