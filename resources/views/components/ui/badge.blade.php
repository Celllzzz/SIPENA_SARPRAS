@props(['type' => 'default'])

@php
    $baseClasses = 'px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-md border';
    
    $typeClasses = match($type) {
        'verifikasi' => 'bg-amber-50 text-amber-800 border-amber-200/80',
        'dalam_perbaikan', 'perbaikan' => 'bg-blue-50 text-blue-800 border-blue-200/80',
        'selesai' => 'bg-emerald-50 text-emerald-800 border-emerald-200/80',
        'ditolak' => 'bg-red-50 text-red-800 border-red-200/80',
        'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200/80',
        'warning' => 'bg-amber-50 text-amber-800 border-amber-200/80',
        'danger' => 'bg-red-50 text-red-800 border-red-200/80',
        default => 'bg-gray-50 text-gray-700 border-gray-200',
    };
@endphp

<span class="{{ $baseClasses }} {{ $typeClasses }}">
    {{ $slot }}
</span>
