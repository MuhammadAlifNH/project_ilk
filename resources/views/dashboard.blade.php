@extends('layouts.dashboard-layout')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(Auth::user()->role === 'admin')
                    <div class="p-6 text-gray-900">
                        <h1 class="text-3xl font-bold">Selamat datang di dashboard, Assalamu'alaikum Admin</h1>
                    </div>
                        @include('admin.index')
                    @elseif(Auth::user()->role === 'laboran')
                    <div class="p-6 text-gray-900">
                        <h1 class="text-3xl font-bold">Selamat datang di dashboard, Assalamu'alaikum Laboran</h1>
                    </div>
                        @include('laboran.index')
                    @elseif(Auth::user()->role === 'teknisi')
                    <div class="p-6 text-gray-900">
                        <h1 class="text-3xl font-bold">Selamat datang di dashboard, Assalamu'alaikum Teknisi</h1>
                    </div>
                        @include('teknisi.index')
                    @elseif(Auth::user()->role === 'pengguna')
                    <div class="p-6 text-gray-900">
                        <h1 class="text-3xl font-bold">Selamat datang di dashboard, Assalamu'alaikum Pengguna</h1>
                    </div>
                        @include('pengguna.index')
                    @endif
                        
                </div>
                <div> </div>
            </div>
        </div>
    </div>

@endsection
