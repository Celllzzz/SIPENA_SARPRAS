<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Semua Notifikasi') }}
            </h2>
            <form action="{{ route('notifikasi.markAllAsRead') }}" method="POST">
                @csrf
                <x-primary-button>Tandai Semua Dibaca</x-primary-button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-4">
                        @forelse ($notifikasis as $notifikasi)
                            <a href="{{ route('tindak-lanjut.edit', $notifikasi->pelaporan_id) }}"
                               class="block p-4 border rounded-lg hover:bg-gray-50 @if(!$notifikasi->is_read) bg-indigo-50 border-indigo-200 @endif">
                                <p class="font-medium text-gray-800">{{ $notifikasi->pesan }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $notifikasi->created_at->format('d M Y, H:i') }}</p>
                            </a>
                        @empty
                            <p class="text-center text-gray-500">Tidak ada notifikasi.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $notifikasis->links() }}
                    </div>
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
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif