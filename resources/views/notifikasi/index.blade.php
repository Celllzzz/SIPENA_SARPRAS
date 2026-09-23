<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    {{ __('Semua Notifikasi') }}
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Pemberitahuan aktivitas pelaporan dan perbaikan sarana
                </p>
            </div>
            @if(count($notifikasis) > 0)
                <form action="{{ route('notifikasi.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-3.5 py-1.5 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-teal-700 transition-colors shadow-sm">
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-5 sm:p-6">
                <div class="divide-y divide-gray-100">
                    @forelse ($notifikasis as $notifikasi)
                        <a href="{{ route('tindak-lanjut.edit', $notifikasi->pelaporan_id) }}"
                           class="flex items-start justify-between py-3.5 px-3 rounded-md transition-colors {{ !$notifikasi->is_read ? 'bg-teal-50/50 hover:bg-teal-50/80' : 'hover:bg-gray-50/80' }}">
                            <div class="flex items-start space-x-3">
                                <span class="mt-1.5 inline-block w-2 h-2 rounded-md flex-shrink-0 {{ !$notifikasi->is_read ? 'bg-teal-600' : 'bg-gray-300' }}"></span>
                                <div>
                                    <p class="text-xs sm:text-sm font-medium {{ !$notifikasi->is_read ? 'text-gray-900 font-semibold' : 'text-gray-700' }} leading-snug">
                                        {{ $notifikasi->pesan }}
                                    </p>
                                    <p class="text-[11px] text-gray-400 mt-1">
                                        {{ $notifikasi->created_at->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
                                    </p>
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-teal-700 ml-3 flex-shrink-0 self-center">
                                Buka &rarr;
                            </span>
                        </a>
                    @empty
                        <div class="py-10 text-center">
                            <p class="text-xs sm:text-sm text-gray-500">Tidak ada notifikasi saat ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100">
                    {{ $notifikasis->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 1500,
        showConfirmButton: false,
        confirmButtonColor: '#0D9488'
    });
</script>
@endif