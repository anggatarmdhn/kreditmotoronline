@extends('layouts.admin')

@section('title', 'Pengaturan Perusahaan')
@section('page-title', 'Pengaturan Perusahaan')
@section('page-subtitle', 'Kelola nama, logo, dan informasi kontak perusahaan')

@section('content')
<div class="max-w-2xl">
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;">

        <div style="padding:20px 24px;border-bottom:1px solid #f1f5f9;">
            <p style="font-size:13px;color:#64748b;margin:0;">Perubahan akan langsung tampil di Landing Page dan seluruh halaman sistem.</p>
        </div>

        <form action="{{ route('company.update') }}" method="POST" enctype="multipart/form-data" style="padding:24px;display:flex;flex-direction:column;gap:20px;">
            @csrf
            @method('PUT')

            {{-- Logo Preview --}}
            <div style="display:flex;align-items:center;gap:18px;padding:16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;">
                <div id="logo-preview-wrap" style="width:60px;height:60px;border-radius:12px;background:linear-gradient(135deg,#ef4444,#b91c1c);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:18px;color:#fff;flex-shrink:0;overflow:hidden;">
                    @if($settings['company_logo_path'])
                        <img id="logo-img" src="{{ asset('storage/'.$settings['company_logo_path']) }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span id="logo-text-preview">{{ $settings['company_logo_text'] }}</span>
                    @endif
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:#0f172a;margin:0 0 3px;">{{ $settings['company_name'] }}</p>
                    <p style="font-size:11px;color:#64748b;margin:0;">{{ $settings['company_tagline'] }}</p>
                </div>
            </div>

            {{-- Nama Perusahaan --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">Nama Lengkap Perusahaan</label>
                <input type="text" name="company_name" value="{{ old('company_name', $settings['company_name']) }}"
                    style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 14px;font-size:13px;box-sizing:border-box;"
                    placeholder="Angga Credit Motors">
            </div>

            {{-- Nama Pendek (Baris kecil logo) --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">Nama Singkat <span style="color:#94a3b8;font-weight:400;">(baris kecil di logo landing page)</span></label>
                <input type="text" name="company_name_short" value="{{ old('company_name_short', $settings['company_name_short']) }}"
                    style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 14px;font-size:13px;box-sizing:border-box;"
                    placeholder="Angga Motors">
            </div>

            {{-- Nama Suffix (Baris besar logo) --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">Kata Tebal Logo <span style="color:#94a3b8;font-weight:400;">(baris besar di logo landing page, contoh: Credit / Motors)</span></label>
                <input type="text" name="company_name_suffix" value="{{ old('company_name_suffix', $settings['company_name_suffix']) }}"
                    style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 14px;font-size:13px;box-sizing:border-box;"
                    placeholder="Credit">
            </div>

            {{-- Tagline --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">Tagline / Slogan</label>
                <input type="text" name="company_tagline" value="{{ old('company_tagline', $settings['company_tagline']) }}"
                    style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 14px;font-size:13px;box-sizing:border-box;"
                    placeholder="Sistem Informasi Kredit Motor">
            </div>

            {{-- Dua kolom: Cabang & Telepon --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">Cabang</label>
                    <input type="text" name="company_branch" value="{{ old('company_branch', $settings['company_branch']) }}"
                        style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 14px;font-size:13px;box-sizing:border-box;"
                        placeholder="Rajeg">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">Nomor Telepon</label>
                    <input type="text" name="company_phone" value="{{ old('company_phone', $settings['company_phone']) }}"
                        style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 14px;font-size:13px;box-sizing:border-box;"
                        placeholder="0813-8704-7805">
                </div>
            </div>

            {{-- Logo: Teks & File --}}
            <div style="padding:16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;display:flex;flex-direction:column;gap:14px;">
                <p style="font-size:12px;font-weight:700;color:#374151;margin:0;">Logo Perusahaan</p>

                <div>
                    <label style="display:block;font-size:11px;font-weight:600;color:#64748b;margin-bottom:6px;">Teks Logo (maks. 4 karakter, jika tidak pakai gambar)</label>
                    <input type="text" name="company_logo_text" id="logo-text-input"
                        value="{{ old('company_logo_text', $settings['company_logo_text']) }}"
                        maxlength="4"
                        style="width:100%;border:1px solid #d1d5db;border-radius:10px;padding:10px 14px;font-size:13px;box-sizing:border-box;"
                        placeholder="KM">
                </div>

                <div>
                    <label style="display:block;font-size:11px;font-weight:600;color:#64748b;margin-bottom:6px;">Upload Gambar Logo (PNG/JPG/SVG, maks 1MB) — <em>opsional, menggantikan teks logo</em></label>
                    <input type="file" name="logo_file" accept="image/*" id="logo-file-input"
                        style="font-size:12px;">
                </div>
            </div>

            @if($errors->any())
            <div style="background:#fff1f2;border:1px solid #fecaca;color:#991b1b;border-radius:10px;padding:10px 16px;font-size:13px;">
                <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div style="display:flex;justify-content:flex-end;gap:10px;padding-top:8px;border-top:1px solid #f1f5f9;">
                <a href="{{ route('dashboard') }}" style="padding:10px 20px;border:1px solid #d1d5db;border-radius:10px;font-size:13px;font-weight:700;color:#374151;text-decoration:none;">Batal</a>
                <button type="submit" style="padding:10px 24px;background:#ef4444;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Live preview teks logo
    document.getElementById('logo-text-input').addEventListener('input', function() {
        const el = document.getElementById('logo-text-preview');
        if (el) el.textContent = this.value || 'KM';
    });

    // Preview gambar logo sebelum upload
    document.getElementById('logo-file-input').addEventListener('change', function() {
        if (!this.files || !this.files[0]) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrap = document.getElementById('logo-preview-wrap');
            wrap.innerHTML = '<img src="'+e.target.result+'" style="width:100%;height:100%;object-fit:cover;">';
        };
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endpush
@endsection
