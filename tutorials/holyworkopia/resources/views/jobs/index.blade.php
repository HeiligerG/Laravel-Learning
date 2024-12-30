<x-layout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse($jobs as $job)
                <x-jobs-card :job="$job" />
             @empty
             <p>No Jobs available</p>
        @endforelse
    </div>
    {{$jobs->links()}}
</x-layout>

