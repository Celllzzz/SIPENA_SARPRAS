@props([
    'rows' => 5,
    'cols' => 5
])

<div {{ $attributes->merge(['class' => 'w-full animate-pulse space-y-3']) }}>
    {{-- Header Skeleton --}}
    <div class="h-10 bg-gray-100 rounded-md w-full flex items-center px-4 space-x-4 border border-gray-200/60">
        <div class="h-3 bg-gray-200 rounded-md w-8"></div>
        <div class="h-3 bg-gray-200 rounded-md flex-1"></div>
        <div class="h-3 bg-gray-200 rounded-md w-28 hidden sm:block"></div>
        <div class="h-3 bg-gray-200 rounded-md w-24 hidden md:block"></div>
        <div class="h-3 bg-gray-200 rounded-md w-20"></div>
    </div>

    {{-- Rows Skeleton --}}
    <div class="divide-y divide-gray-100 border border-gray-200 rounded-md overflow-hidden bg-white">
        @for ($i = 0; $i < $rows; $i++)
            <div class="p-4 flex items-center space-x-4">
                <div class="h-3.5 bg-gray-200 rounded-md w-6"></div>
                <div class="flex-1 space-y-2">
                    <div class="h-3.5 bg-gray-200 rounded-md w-3/4"></div>
                    <div class="h-2.5 bg-gray-100 rounded-md w-1/2"></div>
                </div>
                <div class="h-3.5 bg-gray-200 rounded-md w-28 hidden sm:block"></div>
                <div class="h-5 bg-gray-200 rounded-md w-24 hidden md:block"></div>
                <div class="h-7 bg-gray-200 rounded-md w-16"></div>
            </div>
        @endfor
    </div>
</div>
