@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Akun')
@section('page-subtitle', 'Kelola informasi dan pengaturan keamanan akun Anda')

@section('content')
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-slate-900 transition">
            <span>←</span> Kembali ke Dashboard
        </a>
    </div>
    <div class="py-2">
        <div class="max-w-4xl space-y-6">
            <div class="p-4 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
