@extends('layouts.guest')

@section('title', 'Login Aplikasi')

@section('content')
<div class="hero min-h-screen bg-base-200">
    <div class="hero-content w-full flex justify-center">
        
        <div class="card shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
            <form class="card-body" method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <h2 class="text-3xl font-bold text-center text-primary mb-6">Login</h2>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Username</span>
                    </label>
                    <input type="text" 
                           name="username" 
                           placeholder="Username" 
                           class="input input-bordered w-full focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" 
                           required 
                           autofocus />
                    @error('username')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mt-4">
                    <label class="label">
                        <span class="label-text font-semibold">Password</span>
                    </label>
                    
                    <div class="relative w-full">
                        <input type="password" 
                               id="passwordInput"
                               name="password" 
                               placeholder="******" 
                               class="input input-bordered w-full pr-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" 
                               required />
                        
                        <button type="button" 
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary cursor-pointer focus:outline-none">
                            
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-control mt-8">
                    <button type="submit" class="btn btn-primary w-full text-lg font-bold">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        if (passwordInput.type === 'password') {
            // Ubah jadi text (tampilkan password)
            passwordInput.type = 'text';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        } else {
            // Ubah jadi password (sembunyikan password)
            passwordInput.type = 'password';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        }
    }
</script>
@endsection