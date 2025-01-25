<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse ($foodItems as $item)
        @include('item.partials.item-card', ['item' => $item])
    @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-400 text-lg">Keine Lebensmittel gefunden.</p>
        </div>
    @endforelse
</div>

@if($foodItems->hasPages())
    <div class="mt-8">
        {{ $foodItems->onEachSide(2)->links() }}
    </div>
@endif
