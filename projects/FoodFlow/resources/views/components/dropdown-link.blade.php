<a {{ $attributes->merge(['class' => 'block w-full px-4 py-2.5
    text-left text-sm font-medium
    text-gray-700
    rounded-md
    transition-colors transition-transform duration-200
    hover:bg-brandIndigo/90 hover:text-white hover:shadow-md hover:scale-105
    focus:outline-none focus:ring-2 focus:ring-brandIndigo focus:text-white
    active:bg-brandIndigo/80']) }}>{{ $slot }}</a>
