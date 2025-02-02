<div id="patchNotesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-brandDark">
        <div class="mt-3">
            <div class="flex items-center justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-100">Update Notes</h3>
            </div>
            <div class="mt-4 max-h-96 overflow-y-auto">
                @foreach($unseenPatchNotes as $note)
                    <div class="mb-4 p-4 border border-gray-700 rounded">
                        <h4 class="text-md font-semibold">Version {{ $note->version }}</h4>
                        <div class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($note->release_date)->format('d.m.Y') }}</div>
                        <div class="mt-2 text-gray-300 whitespace-pre-line">
                            {!! nl2br(e($note->description)) !!}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="markAsSeen()" class="bg-brand hover:bg-brand/80 text-white font-bold py-2 px-4 rounded">
                    Verstanden
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal() {
        document.getElementById('patchNotesModal').classList.remove('hidden');
    }

    function hideModal() {
        document.getElementById('patchNotesModal').classList.add('hidden');
    }

    Promise.all([
        @foreach($unseenPatchNotes as $note)
        fetch('/patch-notes/{{ $note->id }}/seen', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }),
        @endforeach
    ]).then(() => {
        hideModal();
    });

    document.addEventListener('DOMContentLoaded', showModal);
</script>
