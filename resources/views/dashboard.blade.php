@extends('layouts.dashboard-layout')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(Auth::user()->role === 'admin')
                        <h1 class="text-3xl font-bold">Selamat datang di dashboard, Admin</h1>
                        @include('admin.index')
                    @elseif(Auth::user()->role === 'laboran')
                        <h1 class="text-3xl font-bold">Selamat datang di dashboard, Laboran</h1>
                        @include('laboran.index')
                    @elseif(Auth::user()->role === 'teknisi')
                        <h1 class="text-3xl font-bold">Selamat datang di dashboard, Teknisi</h1>
                        @include('teknisi.index')
                    @elseif(Auth::user()->role === 'pengguna')
                        <h1 class="text-3xl font-bold">Selamat datang di dashboard, Pengguna</h1>
                        @include('pengguna.index')
                    @endif
                        
                </div>
                <div> </div>
            </div>
        </div>
    </div>

@endsection
