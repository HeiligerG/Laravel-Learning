<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6">
    @forelse ($foodItems as $item)
        @php
            $expirationDate = $item->expiration_date;
            $isExpired = $expirationDate < now();
            $isExpiringSoon = !$isExpired && $expirationDate->diffInDays(now()) <= 7;
        @endphp

        <div class="bg-green-800 text-gray-100 rounded-lg shadow-lg p-4 border {{ $isExpired ? 'border-red-500' : ($isExpiringSoon ? 'border-yellow-500' : 'border-green-700') }}">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                @if ($isExpired)
                    <span class="text-red-500 text-sm font-bold">Abgelaufen</span>
                @elseif ($isExpiringSoon)
                    <span class="text-yellow-400 text-sm font-bold">Bald ablaufend</span>
                @endif
            </div>
            <p class="mt-2 text-sm">
                <strong>Kategorie:</strong> {{ $item->category->name }}
            </p>
            <p class="text-sm">
                <strong>Standort:</strong> {{ $item->location->name }}
            </p>
            <p class="text-sm">
                <strong>Verfallsdatum:</strong> {{ $expirationDate->format('d.m.Y') }}
            </p>
            <p class="text-sm">
                <strong>Menge:</strong> {{ $item->quantity }}
            </p>

            <div class="mt-4 flex justify-end">
                <form action="{{ route('foodItems.destroy', $item) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700 transition">
                        Löschen
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-300">
            <p>Keine Lebensmittel gefunden.</p>
        </div>
    @endforelse
</div>
