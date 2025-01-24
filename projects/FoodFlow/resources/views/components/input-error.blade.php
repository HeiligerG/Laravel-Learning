@props(['messages'])

@if ($messages && count($messages) > 0)
    <ul {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
        @foreach ((array) $messages as $message)
            <li class="text-sm text-red-400 bg-red-500/10 px-3 py-1.5 rounded-lg border border-red-500/20">
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
