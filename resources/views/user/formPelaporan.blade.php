<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pelaporan') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form id="pelaporanForm" 
                      action="{{ route('pelaporan.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      novalidate>
                    @csrf

                    {{-- Nama Pelapor --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Nama Pelapor</label>
                        <input type="text" value="{{ Auth::user()->name }}"
                               class="w-full border-gray-300 rounded mt-1 bg-gray-100" disabled>
                    </div>

                    {{-- Sarana --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Nama Sarana / Prasarana</label>
                        <input type="text" name="sarana"
                               class="w-full border-gray-300 rounded mt-1"
                               placeholder="Contoh: Proyektor, AC, Meja">
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Lokasi</label>
                        <input type="text" name="lokasi"
                               class="w-full border-gray-300 rounded mt-1"
                               placeholder="Contoh: Ruang Kelas 101">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Deskripsi Kerusakan</label>
                        <textarea name="deskripsi" rows="4"
                                  class="w-full border-gray-300 rounded mt-1"></textarea>
                    </div>

                    {{-- Bukti --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Bukti Kerusakan (jpg/jpeg/png/pdf, max 2MB)</label>
                        <input type="file" name="bukti"
                               class="w-full border-gray-300 rounded mt-1">
                    </div>

                    {{-- Button --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Submit
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

        if (!form) {
            console.error("Form dengan id 'pelaporanForm' tidak ditemukan!");
            return;
        }

        form.addEventListener("submit", function (e) {
            let sarana    = document.querySelector("[name='sarana']").value.trim();
            let lokasi    = document.querySelector("[name='lokasi']").value.trim();
            let deskripsi = document.querySelector("[name='deskripsi']").value.trim();
            let bukti     = document.querySelector("[name='bukti']").value.trim();

            if (!sarana) {
                e.preventDefault();
                Swal.fire("Lengkapi Data", "Nama sarana wajib diisi!", "warning");
                return;
            }
            if (!lokasi) {
                e.preventDefault();
                Swal.fire("Lengkapi Data", "Lokasi wajib diisi!", "warning");
                return;
            }
            if (!deskripsi) {
                e.preventDefault();
                Swal.fire("Lengkapi Data", "Deskripsi wajib diisi!", "warning");
                return;
            }
            if (!bukti) {
                e.preventDefault();
                Swal.fire("Lengkapi Data", "Bukti wajib diupload!", "warning");
                return;
            }

            // Kalau lolos validasi -> biarkan form submit
            Swal.fire({
                title: "Mengirim data...",
                text: "Harap tunggu sebentar",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    });
</script>

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