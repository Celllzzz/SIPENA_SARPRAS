<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ekspor Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Pilih Opsi Ekspor</h3>
                    <p class="text-sm text-gray-600 mb-6">Pilih jenis laporan, rentang tanggal, dan format file yang diinginkan.</p>

                    <form method="POST" action="{{ route('ekspor.export') }}" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="report_type" :value="__('Jenis Laporan')" />
                            <select id="report_type" name="report_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="laporan_kerusakan">Laporan Kerusakan</option>
                                <option value="pemeliharaan_rutin">Jadwal Pemeliharaan Rutin</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" required />
                            </div>
                             <div>
                                <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" required />
                            </div>
                        </div>

                        <div>
                            <x-input-label :value="__('Format File')" />
                            <div class="mt-2 space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-indigo-600" name="format" value="pdf" checked>
                                    <span class="ml-2">PDF</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-indigo-600" name="format" value="excel">
                                    <span class="ml-2">Excel</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Unduh Laporan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}'
    });
</script>
@endif