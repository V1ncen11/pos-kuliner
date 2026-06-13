@extends('layouts.admin')
@section('title', 'Kelola Menu — Resto Cafe')
@section('content')
<div class="admin-topbar">
    <h1><i class="bi bi-journal-text"></i> Kelola Menu</h1>
    <a href="{{ route('admin.menu.create') }}" class="btn-primary btn-sm">+ Tambah Menu</a>
</div>

@foreach(['makanan' => 'Makanan', 'minuman' => 'Minuman', 'snack' => 'Snack'] as $kategori => $label)
<div class="admin-card">
    <div class="admin-card-header">
        <h2>{{ $label }}</h2>
        <span class="badge badge-blue">{{ isset($menus[$kategori]) ? $menus[$kategori]->count() : 0 }} item</span>
    </div>

    @if(isset($menus[$kategori]) && $menus[$kategori]->count())
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tersedia</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus[$kategori] as $menu)
                    <tr>
                        <td><strong>{{ $menu->nama_menu }}</strong></td>
                        <td>{{ $menu->harga_format }}</td>
                        <td>{{ $menu->stok }}</td>
                        <td>
                            <span class="badge {{ $menu->tersedia ? 'badge-green' : 'badge-red' }}">
                                {{ $menu->tersedia ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td style="display:flex;gap:0.5rem;">
                            <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn-warning btn-sm" style="text-decoration:none;"><i class="bi bi-pencil"></i> Edit</a>
                            <form method="POST" action="{{ route('admin.menu.destroy', $menu->id) }}" onsubmit="return confirm('Yakin hapus menu {{ $menu->nama_menu }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p style="color:var(--admin-text-muted);text-align:center;padding:1rem;">Belum ada menu di kategori ini.</p>
    @endif
</div>
@endforeach
@endsection
