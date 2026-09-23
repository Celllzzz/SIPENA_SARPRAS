<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    {{ __('Buat Laporan Kerusakan Baru') }}
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Kirimkan permohonan perbaikan sarana atau prasarana
                </p>
            </div>
            <a href="{{ route('pelaporan.index') }}" class="text-xs sm:text-sm font-semibold text-teal-700 hover:text-teal-800 transition-colors">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 sm:p-8">
                <div class="mb-6">
                    <h2 class="font-heading font-bold text-base sm:text-lg text-gray-900">Formulir Pelaporan</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Isi seluruh informasi sarana atau prasarana yang mengalami kerusakan di bawah ini.</p>
                </div>

                <form id="pelaporanForm" action="{{ route('pelaporan.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_pelapor" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Nama Pelapor</label>
                                <input id="nama_pelapor" class="block w-full bg-gray-50 border border-gray-300 rounded-md text-xs sm:text-sm text-gray-500 cursor-not-allowed px-3 py-2" type="text" value="{{ Auth::user()->name }}" disabled />
                            </div>

                            <div>
                                <label for="sarana" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                    Nama Sarana / Prasarana <span class="text-red-500">*</span>
                                </label>
                                <input id="sarana" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3 py-2 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="text" name="sarana" value="{{ old('sarana') }}" placeholder="Contoh: AC Ruang Guru, Meja Siswa" required />
                            </div>
                        </div>

                        <div>
                            <label for="lokasi" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Lokasi Spesifik <span class="text-red-500">*</span>
                            </label>
                            <input id="lokasi" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3 py-2 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Gedung A, Lantai 2, Ruang Kelas 10-A" required />
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Deskripsi Kerusakan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 p-3 focus:border-teal-500 focus:ring-teal-500 shadow-sm" placeholder="Jelaskan secara rinci kondisi kerusakan yang terjadi..." required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <div>
                            <label for="bukti" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Bukti Foto / Berkas Kerusakan <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex items-center justify-center w-full">
                                <label for="bukti" class="flex flex-col items-center justify-center w-full min-h-[140px] border-2 border-gray-300 border-dashed rounded-md cursor-pointer bg-gray-50/50 hover:bg-gray-100/50 hover:border-teal-500 transition p-4">
                                    <div class="flex flex-col items-center justify-center text-center" id="upload-placeholder">
                                        <p class="text-xs sm:text-sm text-gray-700 font-medium">Klik untuk memilih berkas atau seret berkas ke sini</p>
                                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, PDF (Maksimal 2 MB)</p>
                                    </div>
                                    <img id="image-preview" src="" alt="Pratinjau Bukti" class="hidden max-h-40 w-auto object-contain rounded-md border border-gray-200" />
                                    <input id="bukti" name="bukti" type="file" class="hidden" accept=".jpg,.jpeg,.png,.pdf" />
                                </label>
                            </div> 
                            <p id="file-name" class="mt-1.5 text-xs font-medium text-teal-700"></p>
                        </div>

                        {{-- Linear Progress Bar (> 3 - 10 detik) saat Mengunggah Berkas --}}
                        <div id="upload-progress-container" class="hidden p-4 rounded-md border border-teal-200 bg-teal-50/50 space-y-2">
                            <div class="flex justify-between items-center text-xs font-semibold text-teal-800">
                                <span id="upload-status-text">Mengunggah bukti foto & menyiapkan data...</span>
                                <span id="upload-percentage">0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-md h-2 overflow-hidden">
                                <div id="upload-progress-bar" class="bg-teal-600 h-2 rounded-md transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 pt-4 border-t border-gray-100 gap-3">
                        <a href="{{ route('pelaporan.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" id="submitBtn" class="inline-flex items-center justify-center px-5 py-2 bg-teal-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wider hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition shadow-sm">
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("pelaporanForm");
    const fileInput = document.getElementById("bukti");
    const imagePreview = document.getElementById("image-preview");
    const uploadPlaceholder = document.getElementById("upload-placeholder");
    const fileNameDisplay = document.getElementById("file-name");

    fileInput.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            fileNameDisplay.textContent = `Berkas terpilih: ${file.name}`;

            const imageTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
            if (imageTypes.includes(file.type)) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove("hidden");
                    uploadPlaceholder.classList.add("hidden");
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add("hidden");
                uploadPlaceholder.classList.remove("hidden");
            }
        } else {
            fileNameDisplay.textContent = "";
            imagePreview.classList.add("hidden");
            uploadPlaceholder.classList.remove("hidden");
        }
    });

    if (form) {
        form.addEventListener("submit", function (e) {
            let sarana = document.querySelector("[name='sarana']").value.trim();
            let lokasi = document.querySelector("[name='lokasi']").value.trim();
            let deskripsi = document.querySelector("[name='deskripsi']").value.trim();
            let bukti = fileInput.value.trim();

            let errorMessage = "";
            if (!sarana) errorMessage = "Nama sarana wajib diisi!";
            else if (!lokasi) errorMessage = "Lokasi wajib diisi!";
            else if (!deskripsi) errorMessage = "Deskripsi kerusakan wajib diisi!";
            else if (!bukti) errorMessage = "Bukti berkas wajib diunggah!";

            if (errorMessage) {
                e.preventDefault();
                Swal.fire({
                    icon: "warning",
                    title: "Lengkapi Formulir",
                    text: errorMessage,
                    confirmButtonColor: "#0D9488",
                    confirmButtonText: "Mengerti"
                });
                return;
            }

            e.preventDefault();
            const progressContainer = document.getElementById("upload-progress-container");
            const progressBar = document.getElementById("upload-progress-bar");
            const percentageText = document.getElementById("upload-percentage");
            const submitBtn = document.getElementById("submitBtn");

            progressContainer.classList.remove("hidden");
            submitBtn.disabled = true;
            submitBtn.classList.add("opacity-75", "cursor-not-allowed");

            let percent = 0;
            const interval = setInterval(() => {
                percent += Math.floor(Math.random() * 15) + 10;
                if (percent >= 100) {
                    percent = 100;
                    clearInterval(interval);
                    progressBar.style.width = "100%";
                    percentageText.textContent = "100%";
                    setTimeout(() => {
                        form.submit();
                    }, 400);
                } else {
                    progressBar.style.width = percent + "%";
                    percentageText.textContent = percent + "%";
                }
            }, 180);
        });
    }
});
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: "success",
        title: "Berhasil!",
        text: "{{ session('success') }}",
        confirmButtonColor: "#0D9488"
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: "error",
        title: "Gagal!",
        text: "{{ session('error') }}",
        confirmButtonColor: "#0D9488"
    });
</script>
@endif