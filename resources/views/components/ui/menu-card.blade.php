@props(['title', 'icon' => null, 'href' => null, 'isDropdown' => false])

@if($isDropdown)
<div x-data="{ open: false }" class="relative w-full">
    <button @click="open = !open" @click.away="open = false" type="button" class="w-full min-h-[50px] flex items-center justify-between bg-white text-gray-800 px-4 py-3 rounded-md shadow-sm border border-gray-200 hover:border-teal-500 hover:bg-gray-50/50 transition focus:outline-none focus:ring-2 focus:ring-teal-500/20 group">
        @if($icon)
            <div class="mr-3 text-teal-700 flex-shrink-0">
                {{ $icon }}
            </div>
        @endif
        <span class="font-heading font-semibold text-sm text-gray-800 group-hover:text-teal-700 transition-colors text-left flex-1">
            {{ $title }}
        </span>
        <svg class="w-4 h-4 text-gray-400 group-hover:text-teal-600 transition-transform flex-shrink-0 ml-2" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100" 
         x-transition:enter-start="transform opacity-0 scale-95" 
         x-transition:enter-end="transform opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-75" 
         x-transition:leave-start="transform opacity-100 scale-100" 
         x-transition:leave-end="transform opacity-0 scale-95" 
         class="absolute left-0 right-0 z-30 mt-1.5 rounded-md shadow-lg bg-white border border-gray-200 py-1 overflow-hidden" 
         style="display: none;">
        {{ $slot }}
    </div>
</div>
@else
<a href="{{ $href ?? '#' }}" class="w-full min-h-[50px] flex items-center justify-between bg-white text-gray-800 px-4 py-3 rounded-md shadow-sm border border-gray-200 hover:border-teal-500 hover:bg-gray-50/50 transition focus:outline-none focus:ring-2 focus:ring-teal-500/20 group">
    @if($icon)
        <div class="mr-3 text-teal-700 flex-shrink-0">
            {{ $icon }}
        </div>
    @endif
    <span class="font-heading font-semibold text-sm text-gray-800 group-hover:text-teal-700 transition-colors text-left flex-1">
        {{ $title }}
    </span>
    <svg class="w-4 h-4 text-gray-400 group-hover:text-teal-600 group-hover:translate-x-0.5 transition-all flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
</a>
@endif
