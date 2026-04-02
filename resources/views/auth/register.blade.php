<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - LibSchool</title>
    <link rel="icon" href="{{ asset('images/logo/LOGO.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Sembunyikan ikon visibility bawaan browser (Edge, Chrome, IE) */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear,
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button { display: none !important; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative" style="background: linear-gradient(135deg, #4475F2 0%, #A2BEF8 100%);">

    {{-- Kartu Register --}}
    <div class="w-full max-w-[700px] bg-white rounded-3xl shadow-xl px-10 py-12 relative z-10 my-8">

        {{-- Logo --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo/LogoBlack.png') }}" alt="LibSchool Logo" class="h-14 w-auto object-contain">
        </div>

        {{-- Judul / Subtitle --}}
        <p class="text-[15px] font-medium text-slate-700 text-center mb-8">
            Daftarkan diri Anda untuk merasakan pengalaman di LibSchool.
        </p>

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-6 px-4 py-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-[14px]">
                <ul class="list-none p-0 m-0">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" autocomplete="off">
            @csrf

            {{-- Grid 2 Kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

                <div>
                    <label class="block text-[15px] font-medium text-slate-800 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" autocomplete="off"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                           value="{{ old('name') }}" required>
                </div>



                <div>
                    <label class="block text-[15px] font-medium text-slate-800 mb-2">Nama pengguna</label>
                    <input type="text" name="username" autocomplete="off"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                           value="{{ old('username') }}" required>
                </div>

                <div>
                    <label class="block text-[15px] font-medium text-slate-800 mb-2">Email</label>
                    <input type="email" name="email" id="emailInput" autocomplete="off"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                           value="{{ old('email') }}" required>
                    <p class="mt-1.5 flex items-center gap-1 text-[12.5px] font-semibold text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="flex-shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Tolong masukan email asli!
                    </p>
                </div>

                <div>
                    <label class="block text-[15px] font-medium text-slate-800 mb-2">Telepon</label>
                    <input type="tel" name="telepon" autocomplete="off" maxlength="15"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                           value="{{ old('telepon') }}" required>
                </div>

                <div>
                    <label class="block text-[15px] font-medium text-slate-800 mb-2">Tanggal lahir</label>
                    <input type="date" name="tanggal_lahir"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                           value="{{ old('tanggal_lahir') }}"
                           min="1900-01-01" max="{{ date('Y-m-d') }}"
                           required>
                </div>

                <div>
                    <label class="block text-[15px] font-medium text-slate-800 mb-2">Kata sandi</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" autocomplete="new-password"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                               required>
                        <button type="button"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                                onclick="togglePassword('password', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-[15px] font-medium text-slate-800 mb-2">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                               required>
                        <button type="button"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                                onclick="togglePassword('password_confirmation', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="md:col-span-2 mt-1 border-t border-gray-100 pt-5">
                    <label class="block text-[15px] font-medium text-slate-800 mb-3">Gender</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer text-[15px] text-slate-700">
                            <input type="radio" name="gender" value="Laki-laki"
                                   class="accent-[#4475F2] w-5 h-5 cursor-pointer"
                                   {{ old('gender') == 'Laki-laki' ? 'checked' : '' }} required>
                            Laki-laki
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-[15px] text-slate-700">
                            <input type="radio" name="gender" value="Perempuan"
                                   class="accent-[#4475F2] w-5 h-5 cursor-pointer"
                                   {{ old('gender') == 'Perempuan' ? 'checked' : '' }}>
                            Perempuan
                        </label>
                    </div>
                </div>

            </div>

            {{-- Tombol Submit --}}
            <button type="submit"
                    class="w-full bg-[#4475F2] text-white rounded-xl py-3.5 text-[16px] font-bold tracking-wide transition-all hover:bg-blue-600 shadow-md hover:shadow-lg hover:-translate-y-0.5 active:bg-blue-700 active:shadow-md mt-6">
                Daftar
            </button>
            
        </form>

        {{-- Register Link --}}
        <div class="mt-8 text-center text-[14.5px] text-gray-800">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-bold text-[#4475F2] hover:text-blue-700 hover:underline">
                Klik disini untuk login
            </a>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.innerHTML = isHidden
                ? `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>`;
        }

        // Custom validation message for required HTML5 fields
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = document.querySelectorAll('input[required], select[required], input[type="date"]');
            inputs.forEach(input => {
                input.addEventListener('invalid', function(e) {
                    if (this.validity.valueMissing) {
                        this.setCustomValidity('Kolom ini wajib di isi');
                    } else if (this.type === 'email' && this.validity.typeMismatch) {
                        this.setCustomValidity('Tolong masukan email yang valid! Contoh: nama@gmail.com');
                    } else if (this.validity.rangeOverflow || this.validity.rangeUnderflow || this.validity.badInput || this.validity.typeMismatch) {
                        this.setCustomValidity('Format atau tanggal tidak sesuai (periksa tahun, bulan dan hari)');
                    }
                });
                input.addEventListener('input', function(e) {
                    this.setCustomValidity('');
                });
            });
        });
    </script>

</body>
</html>