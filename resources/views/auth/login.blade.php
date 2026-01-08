@extends('layouts.guest')

@section('title', 'Login Aplikasi')

@section('content')
<div class="hero min-h-[80vh] bg-base-200">
    <div class="hero-content flex-col lg:flex-row-reverse">
        
        <div class="text-center lg:text-left ml-0 lg:ml-10">
            <h1 class="text-5xl font-bold text-primary">Login Page</h1>
            <p class="py-6">Silakan masuk menggunakan Username yang telah terdaftar untuk mengakses layanan Pokja.</p>
        </div>

        <div class="card shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
            <form class="card-body" method="POST" action="{{ route('login.post') }}">
                @csrf <div class="form-control">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" name="username" placeholder="admin" class="input input-bordered" required autofocus />
                    @error('username')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" name="password" placeholder="******" class="input input-bordered" required />
                </div>

                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary">Masuk Aplikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection