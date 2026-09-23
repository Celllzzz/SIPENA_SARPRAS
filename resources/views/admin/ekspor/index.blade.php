<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                {{ __('Ekspor Laporan') }}
            </h1>
            <p class="text-xs text-gray-500 mt-1">
                Unduh rekapitulasi data pelaporan kerusakan dan jadwal pemeliharaan fasilitas
            </p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 sm:p-8">
                <div class="mb-6">
                    <h2 class="font-heading font-bold text-base sm:text-lg text-gray-900">Pilih Parameter Ekspor</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Tentukan jenis data, rentang periode, dan format dokumen yang akan diunduh.</p>
                </div>

                <form id="eksporForm" method="POST" action="{{ route('ekspor.export') }}" class="space-y-5" data-no-spinner>
                    @csrf
                    <div>
                        <label for="report_type" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Jenis Laporan <span class="text-red-500">*</span>
                        </label>
                        <select id="report_type" name="report_type" class="block w-full border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3 bg-white" required>
                            <option value="laporan_kerusakan">Laporan Kerusakan</option>
                            <option value="pemeliharaan_rutin">Jadwal Pemeliharaan Rutin</option>
                            <option value="pemeliharaan_darurat">Catatan Pemeliharaan Darurat</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <input id="start_date" class="block w-full border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3" type="date" name="start_date" required />
                        </div>
                        <div>
                            <label for="end_date" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <input id="end_date" class="block w-full border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3" type="date" name="end_date" required />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                            Format Berkas
                        </label>
                        <div class="flex items-center gap-6 mt-1 text-xs sm:text-sm">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" class="w-4 h-4 text-teal-600 focus:ring-teal-500 border-gray-300" name="format" value="pdf" checked>
                                <span class="ml-2 font-medium text-gray-700">PDF (.pdf)</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" class="w-4 h-4 text-teal-600 focus:ring-teal-500 border-gray-300" name="format" value="excel">
                                <span class="ml-2 font-medium text-gray-700">Excel (.xlsx)</span>
                            </label>
                        </div>
                    </div>

                    {{-- Linear Progress Bar (> 3 - 10 detik) saat Ekspor Berkas --}}
                    <div id="export-progress-container" class="hidden p-4 rounded-md border border-teal-200 bg-teal-50/50 space-y-2">
                        <div class="flex justify-between items-center text-xs font-semibold text-teal-800">
                            <span id="export-status-text">Menyiapkan rekapitulasi data dan berkas laporan...</span>
                            <span id="export-percentage">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-md h-2 overflow-hidden">
                            <div id="export-progress-bar" class="bg-teal-600 h-2 rounded-md transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" id="exportBtn" class="inline-flex items-center justify-center px-5 py-2 bg-teal-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wider hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition shadow-sm">
                            Unduh Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('eksporForm');
        const progressContainer = document.getElementById('export-progress-container');
        const progressBar = document.getElementById('export-progress-bar');
        const percentageText = document.getElementById('export-percentage');
        const exportBtn = document.getElementById('exportBtn');
        const statusText = document.getElementById('export-status-text');

        if (form) {
            form.addEventListener('submit', function (e) {
                progressContainer.classList.remove('hidden');
                exportBtn.disabled = true;
                exportBtn.classList.add('opacity-75', 'cursor-not-allowed');

                let percent = 0;
                statusText.textContent = "Menghimpun data laporan...";
                
                const interval = setInterval(() => {
                    percent += Math.floor(Math.random() * 20) + 12;
                    if (percent >= 50 && percent < 80) {
                        statusText.textContent = "Mengonversi format dokumen berkas...";
                    }
                    if (percent >= 100) {
                        percent = 100;
                        clearInterval(interval);
                        progressBar.style.width = '100%';
                        percentageText.textContent = '100%';
                        statusText.textContent = "Mengunduh berkas laporan...";
                        setTimeout(() => {
                            form.submit();
                            setTimeout(() => {
                                progressContainer.classList.add('hidden');
                                exportBtn.disabled = false;
                                exportBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                                progressBar.style.width = '0%';
                                percentageText.textContent = '0%';
                            }, 3000);
                        }, 400);
                    } else {
                        progressBar.style.width = percent + '%';
                        percentageText.textContent = percent + '%';
                    }
                }, 160);
            });
        }
    });
</script>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#0D9488'
    });
</script>
@endif