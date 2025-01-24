<a {{ $attributes->merge(['class' => '
   block w-full px-4 py-3
   text-sm font-medium
   text-gray-300
   bg-darkCard/50
   rounded-lg
   transition-all duration-200
   hover:bg-brandIndigo hover:text-white hover:translate-x-1
   focus:outline-none focus:ring-2 focus:ring-brandIndigo focus:ring-offset-2 focus:ring-offset-darkCard
   active:bg-brandIndigo/90
']) }}>
    {{ $slot }}
</a>
