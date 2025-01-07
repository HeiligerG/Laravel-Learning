<x-layout>
    <div class="bg-blue-900 h-24 px-4 flex items-center justify-center text-white mb-4 rounded">
        <x-search />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse($jobs as $job)
                <x-jobs-card :job="$job" />
             @empty
             <p>No Jobs available</p>
        @endforelse
    </div>
    {{$jobs->links()}}
</x-layout>

