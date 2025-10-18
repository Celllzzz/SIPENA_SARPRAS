<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Laporan Kerusakan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Detail Laporan</h3>
                    <p class="text-sm text-gray-600 mb-6">Isi semua kolom di bawah ini dengan detail kerusakan yang Anda temukan.</p>

                    <form id="pelaporanForm" action="{{ route('pelaporan.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        {{-- Layout Grid untuk form --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="col-span-1">
                                <x-input-label for="nama_pelapor" :value="__('Nama Pelapor')" />
                                <x-text-input id="nama_pelapor" class="block mt-1 w-full bg-gray-100" type="text" :value="Auth::user()->name" disabled />
                            </div>

                            <div class="col-span-1">
                                <x-input-label for="sarana" :value="__('Nama Sarana / Prasarana')" />
                                <x-text-input id="sarana" class="block mt-1 w-full" type="text" name="sarana" :value="old('sarana')" placeholder="Contoh: Proyektor, AC, Meja" />
                            </div>

                            <div class="col-span-2">
                                <x-input-label for="lokasi" :value="__('Lokasi Spesifik')" />
                                <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" placeholder="Contoh: Ruang A, Gedung A Lantai 2" />
                            </div>

                            <div class="col-span-2">
                                <x-input-label for="deskripsi" :value="__('Deskripsi Kerusakan')" />
                                <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="col-span-2">
                                <x-input-label for="bukti" :value="__('Bukti Kerusakan (jpg, png, pdf, max 2MB)')" />
                                <div class="mt-1 flex items-center justify-center w-full">
                                    <label for="bukti" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau seret file</p>
                                            <p class="text-xs text-gray-500">JPG, PNG, PDF (MAX. 2MB)</p>
                                        </div>
                                        {{-- Image preview will be shown here --}}
                                        <img id="image-preview" src="" alt="Preview Bukti" class="hidden h-full w-full object-contain p-2"/>
                                        <input id="bukti" name="bukti" type="file" class="hidden" accept=".jpg,.jpeg,.png,.pdf" />
                                    </label>
                                </div> 
                                <p id="file-name" class="mt-2 text-sm text-gray-500"></p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 gap-4">
                            <x-secondary-button :href="route('dashboard')">
                                {{ __('Batal') }}
                            </x-secondary-button>

                            <x-primary-button>
                                {{ __('Kirim Laporan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
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

    // Handle file input change for preview
    fileInput.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            // Display file name
            fileNameDisplay.textContent = `File terpilih: ${file.name}`;

            // Check if the file is an image for preview
            const imageTypes = ["image/jpeg", "image/png", "image/gif"];
            if (imageTypes.includes(file.type)) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove("hidden");
                    uploadPlaceholder.classList.add("hidden");
                };
                reader.readAsDataURL(file);
            } else {
                // If not an image, hide preview and show placeholder
                imagePreview.classList.add("hidden");
                uploadPlaceholder.classList.remove("hidden");
            }
        } else {
            // Reset if no file is chosen
            fileNameDisplay.textContent = "";
            imagePreview.classList.add("hidden");
            uploadPlaceholder.classList.remove("hidden");
        }
    });

    // Handle form submission with validation
    if (form) {
        form.addEventListener("submit", function (e) {
            let sarana = document.querySelector("[name='sarana']").value.trim();
            let lokasi = document.querySelector("[name='lokasi']").value.trim();
            let deskripsi = document.querySelector("[name='deskripsi']").value.trim();
            let bukti = fileInput.value.trim();

            let errorMessage = "";
            if (!sarana) errorMessage = "Nama sarana wajib diisi!";
            else if (!lokasi) errorMessage = "Lokasi wajib diisi!";
            else if (!deskripsi) errorMessage = "Deskripsi wajib diisi!";
            else if (!bukti) errorMessage = "Bukti wajib diupload!";

            if (errorMessage) {
                e.preventDefault();
                Swal.fire("Lengkapi Data", errorMessage, "warning");
                return;
            }

            // If validation passes, show loading indicator
            Swal.fire({
                title: "Mengirim data...",
                text: "Harap tunggu sebentar",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    }
});
</script>

{{-- Display success/error messages from session --}}
@if(session('success'))
<script>
    Swal.fire("Sukses!", "{{ session('success') }}", "success");
</script>
@endif

@if(session('error'))
<script>
    Swal.fire("Gagal!", "{{ session('error') }}", "error");
</script>
@endif