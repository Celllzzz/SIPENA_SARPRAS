@props([
    'title', 
    'value', 
    'variant' => 'default',
    'colorClass' => null,
    'textColor' => null,
    'icon' => null
])

@php
$variants = [
    'default' => [
        'card' => 'bg-white border border-gray-200 text-gray-900',
        'title' => 'text-gray-500',
        'value' => 'text-gray-900',
        'iconBg' => 'bg-gray-100 text-gray-600',
    ],
    'blue' => [
        'card' => 'bg-blue-600 text-white border-transparent',
        'title' => 'text-blue-100',
        'value' => 'text-white',
        'iconBg' => 'bg-white/20 text-white',
    ],
    'amber' => [
        'card' => 'bg-amber-500 text-white border-transparent',
        'title' => 'text-amber-100',
        'value' => 'text-white',
        'iconBg' => 'bg-white/20 text-white',
    ],
    'sky' => [
        'card' => 'bg-sky-600 text-white border-transparent',
        'title' => 'text-sky-100',
        'value' => 'text-white',
        'iconBg' => 'bg-white/20 text-white',
    ],
    'emerald' => [
        'card' => 'bg-emerald-600 text-white border-transparent',
        'title' => 'text-emerald-100',
        'value' => 'text-white',
        'iconBg' => 'bg-white/20 text-white',
    ],
];

$selected = $variants[$variant] ?? $variants['default'];

$cardClasses = $colorClass ?? $selected['card'];
$valueClasses = $textColor ?? $selected['value'];
$titleClasses = $selected['title'];
$iconBgClasses = $selected['iconBg'];
@endphp

<div {{ $attributes->merge(['class' => "$cardClasses p-5 rounded-md shadow-sm border flex items-center justify-between transition-transform duration-150 hover:-translate-y-0.5"]) }}>
    <div>
        <h3 class="text-2xl sm:text-3xl font-heading font-bold {{ $valueClasses }}">{{ $value }}</h3>
        <p class="mt-1 text-xs sm:text-sm font-medium {{ $titleClasses }}">{{ $title }}</p>
    </div>
    @if($icon)
        <div class="w-10 h-10 rounded-md {{ $iconBgClasses }} flex items-center justify-center flex-shrink-0 ml-3">
            {{ $icon }}
        </div>
    @endif
</div>
