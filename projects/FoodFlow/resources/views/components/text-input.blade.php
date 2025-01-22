@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full mt-2 p-3 bg-green-900 text-gray-100 placeholder-gray-400 rounded-lg border border-green-700 focus:ring-2 focus:ring-green-500 focus:outline-none']) }}>
