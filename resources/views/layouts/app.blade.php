<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Pokja')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    /* Menyesuaikan wadah utama Tom Select (untuk kolom select yg pakai TS) */
    .ts-control {
        min-height: 2.5rem !important; /* Tinggi sama persis dengan input DaisyUI */
    }

</style>
</head>

<body class="antialiased font-sans text-base">
    {{-- Sistem Layout Drawer --}}
    <div class="drawer">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" /> 
        <div class="drawer-content flex flex-col min-h-screen bg-base-200">
            <div class="w-full navbar bg-[#102C57] text-white shadow-md sticky top-0 z-50 px-4 gap-4">
                
                <div class="flex-none lg:hidden">
                    <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div> 

                <div class="flex-1 flex items-center gap-6">
                    
                    <a href="{{ url('/') }}" class="flex items-center gap-3 text-white hover:text-gray-200 group">
                        <div class="w-8 h-8 flex items-center justify-center">
                            <x-icons.kemendagri-icon class="w-8 h-8 group-hover:opacity-90 transition-opacity" />
                        </div>
                        <span class="text-xl font-bold normal-case tracking-wide">
                            Pokja1App
                        </span>
                    </a>

                    {{-- Menu Desktop (Hanya Tampil di Layar Besar / lg:flex) --}}
                    <div class="hidden lg:flex">
                        <ul class="menu menu-horizontal px-1 gap-1 text-base">
                            <li><a href="{{ route('dashboard') }}" class="hover:bg-blue-800 hover:text-white rounded-md">Dashboard</a></li>

                            <li>
                                <details class="nav-dropdown">
                                    <summary class="hover:bg-blue-800 hover:text-white rounded-md">Persuratan</summary>
                                    <ul class="p-2 bg-base-100 text-base-content rounded-t-none shadow-lg w-52 text-base z-50">
                                        <li>
                                            <a href="{{ route('surat.index') }}" 
                                                class="{{ request()->routeIs('surat.index') ? 'active' : '' }}">
                                                Daftar Surat
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('surat.create') }}" 
                                                class="{{ request()->routeIs('surat.create') ? 'active' : '' }}">
                                                Upload Surat
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('pks.create') }}" 
                                                class="{{ request()->routeIs('pks.create') ? 'active' : '' }}">
                                                Upload PKS
                                            </a>
                                        </li>
                                    </ul>
                                </details>
                            </li>

                            <li>
                                <details class="nav-dropdown">
                                    <summary class="hover:bg-blue-800 hover:text-white rounded-md">Pengaturan</summary>
                                    <ul class="p-2 bg-base-100 text-base-content rounded-t-none shadow-lg w-52 text-base z-50">
                                        {{-- HANYA ADMIN YANG BISA LIHAT MENU INI --}}
                                        @can('manage-users')
                                            <li><a href="#">Manajemen User</a></li>
                                        @endcan
                                        <li><a href="#">Referensi</a></li>
                                    </ul>
                                </details>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Bagian Kanan: Profil User (Desktop Only) --}}
                <div class="flex-none hidden lg:flex">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center">
                                <x-icons.user-icon class="text-white w-10 h-10" />
                            </div>
                        </div>
                        <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 text-base-content rounded-box w-52 text-base">
                            <li><a>Profil</a></li>
                            <li><a>Ubah Password</a></li>
                            <div class="divider my-0"></div>
                            <li>
                                <a onclick="event.preventDefault(); this.nextElementSibling.submit();"
                                    class="text-red-600 font-bold cursor-pointer">
                                    Logout
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="hidden">
                                    @csrf 
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Container Konten Utama: Tempat @content dari view lain di-inject --}}
            <main class="flex-grow container mx-auto px-4 py-6">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="footer footer-center p-4 bg-base-300 text-base-content mt-auto">
                <aside>
                    <p>Copyright © 2026 - Pokja 1 Developer Team</p>
                </aside>
            </footer>
        </div> 
        
        {{-- Sidebar Navigation --}}
        <div class="drawer-side z-50">
            <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label> 
            <ul class="menu p-4 w-80 min-h-full bg-base-100 text-base-content">
                <div class="mb-6 px-2 flex items-center gap-3">
                    <div class="avatar">
                        <div class="w-10 h-12 flex items-center justify-center">
                            <x-icons.kemendagri-icon class="w-10 h-10" />
                        </div>
                    </div>
                    <div>
                        <p class="font-bold text-lg">Halo, {{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->role?->name }}</p>
                    </div>
                </div>

                <li><a href="#" class="text-base font-medium">Dashboard</a></li>
                
                <li>
                    <details>
                        <summary class="text-base font-medium">Persuratan</summary>
                        <ul class="text-base">
                            <li>
                                <a href="{{ route('surat.index') }}" 
                                    class="{{ request()->routeIs('surat.index') ? 'active' : '' }}">
                                    Daftar Surat
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('surat.create') }}" 
                                    class="{{ request()->routeIs('surat.create') ? 'active' : '' }}">
                                    Upload Surat
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pks.create') }}" 
                                    class="{{ request()->routeIs('pks.create') ? 'active' : '' }}">
                                    Upload PKS
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
                
                <li>
                    <details>
                        <summary class="text-base font-medium">Pengaturan</summary>
                        <ul class="text-base">
                            @can('manage-users')
                                <li><a href="#">Manajemen User</a></li>
                            @endcan
                            <li><a href="#">Referensi</a></li>
                        </ul>
                    </details>
                </li>

                <div class="divider"></div>

                <li>
                    <details>
                        <summary class="text-base font-medium">Akun Saya</summary>
                        <ul class="text-base">
                            <li><a>Profil</a></li>
                            <li><a>Ubah Password</a></li>
                            <li>
                                <a onclick="event.preventDefault(); this.nextElementSibling.submit();"
                                    class="text-red-600 font-bold cursor-pointer">
                                    Logout
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            </li>
                            
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>

    {{-- 
        Interaksi menu
        1. Menutup menu lain saat satu menu dibuka.
        2. Menutup semua menu saat klik di luar area navbar.
    --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navDropdowns = document.querySelectorAll("details.nav-dropdown");

            navDropdowns.forEach((details) => {
                const summary = details.querySelector("summary");
                
                summary.addEventListener("click", (event) => {
                    navDropdowns.forEach((otherDetails) => {
                        if (otherDetails !== details) {
                            otherDetails.removeAttribute("open");
                        }
                    });
                });
            });

            document.addEventListener("click", (event) => {
                if (!event.target.closest("details.nav-dropdown")) {
                    navDropdowns.forEach((details) => {
                        details.removeAttribute("open");
                    });
                }
            });
        });
    </script>

</body>
</html>