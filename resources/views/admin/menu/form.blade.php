@extends('layouts.admin')
@section('title', $title . ' — Resto Cafe')
@section('content')
<div class="admin-topbar">
    <h1>{!! $menu ? '<i class="bi bi-pencil"></i>' : '<i class="bi bi-plus-circle"></i>' !!} {{ $title }}</h1>
    <a href="{{ route('admin.menu.index') }}" class="btn-secondary btn-sm">← Kembali</a>
</div>

<div class="admin-card" style="max-width:600px;">
    <form method="POST" action="{{ $menu ? route('admin.menu.update', $menu->id) : route('admin.menu.store') }}" enctype="multipart/form-data">
        @csrf
        @if($menu) @method('PUT') @endif

        <div style="margin-bottom:1.25rem;">
            <label class="form-label">Nama Menu *</label>
            <input type="text" name="nama_menu" class="form-input" value="{{ old('nama_menu', $menu?->nama_menu) }}" placeholder="Contoh: Bakso Urat" required>
            @error('nama_menu') <p style="color:#E53E3E;font-size:0.8rem;margin-top:0.25rem;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:1.25rem;">
            <label class="form-label">Kategori *</label>
            <select name="kategori" class="form-select" required>
                <option value="">Pilih Kategori</option>
                <option value="makanan" {{ old('kategori', $menu?->kategori) === 'makanan' ? 'selected' : '' }}>🍽️ Makanan</option>
                <option value="minuman" {{ old('kategori', $menu?->kategori) === 'minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                <option value="snack" {{ old('kategori', $menu?->kategori) === 'snack' ? 'selected' : '' }}>🍿 Snack</option>
            </select>
            @error('kategori') <p style="color:#E53E3E;font-size:0.8rem;margin-top:0.25rem;">{{ $message }}</p> @enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem;">
            <div>
                <label class="form-label">Harga (Rp) *</label>
                <input type="number" name="harga" class="form-input" value="{{ old('harga', $menu?->harga) }}" min="0" placeholder="5000" required>
                @error('harga') <p style="color:#E53E3E;font-size:0.8rem;margin-top:0.25rem;">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Stok *</label>
                <input type="number" name="stok" class="form-input" value="{{ old('stok', $menu?->stok ?? 100) }}" min="0" placeholder="100" required>
                @error('stok') <p style="color:#E53E3E;font-size:0.8rem;margin-top:0.25rem;">{{ $message }}</p> @enderror
            </div>
        </div>

        <div style="margin-bottom:1.25rem;">
            <label class="form-label">Gambar Menu (opsional)</label>
            <input type="file" name="gambar" class="form-input" accept="image/*" style="padding:0.5rem;">
            @if($menu?->gambar_path)
                <p style="font-size:0.8rem;color:var(--admin-text-muted);margin-top:0.5rem;">Gambar saat ini: {{ basename($menu->gambar_path) }}</p>
            @endif
            @error('gambar') <p style="color:#E53E3E;font-size:0.8rem;margin-top:0.25rem;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:1.5rem;">
            <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                <input type="checkbox" name="tersedia" value="1" {{ old('tersedia', $menu?->tersedia ?? true) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:var(--admin-primary);">
                <span class="form-label" style="margin:0;">Menu Tersedia</span>
            </label>
        </div>

        <button type="submit" class="btn-primary" style="width:100%;">
            {{ $menu ? '💾 Simpan Perubahan' : '➕ Tambah Menu' }}
        </button>
    </form>
</div>
@endsection
