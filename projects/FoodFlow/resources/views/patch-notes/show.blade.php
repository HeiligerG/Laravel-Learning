<div x-data="{ showModal: {{ $unseenPatchNotes->isNotEmpty() ? 'true' : 'false' }} }">
    <div x-show="showModal" id="patchNotesModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-brandDark">
            <div class="mt-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-100">Hallo, {{ auth()->user()->name }}! 👋</h3>
                    <button @click="showModal = false; markPatchNoteSeen();" class="text-gray-300 hover:text-gray-500">&times;</button>
                </div>
                <div class="mt-4 max-h-96 overflow-y-auto">
                    @if($unseenPatchNotes->isNotEmpty())
                        @php $patchNote = $unseenPatchNotes->first(); @endphp
                        <div class="bg-gray-700 p-4 mb-2 rounded">
                            <h2 class="text-xl font-bold text-white">🚀 Neues Update: {{ $patchNote->version }}</h2>
                            <p class="text-sm text-gray-300 italic">Veröffentlicht am: {{ \Carbon\Carbon::parse($patchNote->release_date)->format('d.m.Y') }}</p>
                            <p class="mt-2 text-gray-200">{!! nl2br(e($patchNote->description)) !!}</p>
                        </div>
                        <p class="text-sm text-gray-400">Danke, dass du FoodFlow nutzt! ❤️</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function markPatchNoteSeen() {
        fetch("{{ route('patch-notes.mark-seen') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({})
        }).then(response => response.json()).then(data => {
            console.log(data.message);
        });
    }
</script>
