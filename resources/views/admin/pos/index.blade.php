@extends('layouts.admin')
@section('title', 'Kasir POS — Seblak Saiton')

@push('styles')
<style>
    /* Global Layout Override */
    .admin-main { padding: 1.5rem; background: #F4F7F9; }

    .pos-layout {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        height: 100%;
    }

    /* Top Bar */
    .pos-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }
    .pos-search-wrapper {
        flex: 1;
        position: relative;
    }
    .pos-search-wrapper i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #A0AEC0;
    }
    .pos-search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        background: white;
        font-size: 0.9rem;
        outline: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .pos-top-actions {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }
    .top-action-btn {
        background: none;
        border: none;
        color: #4A5568;
        font-size: 1.25rem;
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
    }
    .top-action-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #E53E3E;
        color: white;
        font-size: 0.6rem;
        padding: 2px 5px;
        border-radius: 50%;
        border: 2px solid white;
    }
    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.4rem 0.75rem;
        background: white;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
    }
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #FED7D7;
        color: #E53E3E;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    /* Main Container */
    .pos-main-container {
        display: flex;
        gap: 1.5rem;
        flex: 1;
        min-height: 0; /* Important for flex child with overflow */
    }

    /* Left Side: Categories & Menu */
    .pos-left {
        flex: 3;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        min-width: 0;
    }
    
    /* Tabs */
    .pos-tabs {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding-bottom: 0.25rem;
    }
    .pos-tab {
        padding: 0.75rem 1.25rem;
        background: white;
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        font-weight: 600;
        font-size: 0.9rem;
        color: #718096;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .pos-tab.active {
        border-color: #E53E3E;
        color: #E53E3E;
        background: #FFF5F5;
    }
    .pos-tab i { font-size: 1rem; }

    /* Menu Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 1rem;
        overflow-y: auto;
        padding-right: 0.5rem;
    }
    .pos-item {
        background: white;
        border-radius: 16px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid #E2E8F0;
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .pos-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: #FED7D7;
    }
    .pos-item-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 12px;
        margin: 0 auto 0.75rem;
        background: #F7FAFC;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pos-item-title {
        font-weight: 700;
        font-size: 0.85rem;
        color: #2D3748;
        margin-bottom: 0.25rem;
        height: 2.4rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .pos-item-price {
        font-size: 0.8rem;
        color: #E53E3E;
        font-weight: 600;
    }
    .pos-item-id {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #F7FAFC;
        color: #718096;
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 700;
    }

    /* Right Side: Cart */
    .pos-right {
        flex: 1.2;
        min-width: 360px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }
    
    /* Takeaway Section */
    .takeaway-section {
        padding: 0.75rem 1rem;
        background: #EBF8FF;
        border-bottom: 1px solid #BEE3F8;
    }
    .takeaway-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: #2B6CB0;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .takeaway-input-wrapper {
        position: relative;
    }
    .takeaway-input-wrapper i {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #63B3ED;
    }
    .takeaway-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        border: 1px solid #BEE3F8;
        background: white;
        font-size: 0.9rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s;
    }
    .takeaway-input:focus {
        border-color: #4299E1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    .cart-title-section {
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #EDF2F7;
    }
    .cart-title {
        font-size: 1rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #2D3748;
    }
    .cart-badge {
        background: #E53E3E;
        color: white;
        font-size: 0.7rem;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-clear {
        background: none;
        border: none;
        color: #A0AEC0;
        cursor: pointer;
        font-size: 1.1rem;
    }

    /* Cart Items */
    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }
    .cart-item {
        display: grid;
        grid-template-columns: 1fr auto auto;
        align-items: center;
        gap: 1rem;
        padding-bottom: 0.75rem;
        margin-bottom: 0.75rem;
        border-bottom: 1px solid #F7FAFC;
    }
    .cart-item-info { min-width: 0; }
    .cart-item-name { font-weight: 700; font-size: 0.85rem; color: #2D3748; margin-bottom: 2px; }
    .cart-item-meta { font-size: 0.75rem; color: #718096; }
    .cart-item-price { font-weight: 700; font-size: 0.85rem; color: #2D3748; }
    .btn-remove {
        color: #FC8181;
        background: #FFF5F5;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-remove:hover { background: #E53E3E; color: white; }

    /* Cart Footer */
    .cart-footer {
        padding: 1.25rem;
        background: white;
        border-top: 1px solid #EDF2F7;
    }
    .order-option { margin-bottom: 0.75rem; }
    .option-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #4A5568;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.4rem;
    }
    .option-select, .option-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        background: #F7FAFC;
        font-size: 0.85rem;
        color: #2D3748;
        outline: none;
    }
    .payment-methods {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }
    .payment-btn {
        flex: 1;
        padding: 0.75rem;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        background: white;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: #718096;
        transition: all 0.2s;
    }
    .payment-btn i { font-size: 1.2rem; }
    .payment-btn.active {
        border-color: #E53E3E;
        background: #FFF5F5;
        color: #E53E3E;
    }

    .total-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 1.25rem;
    }
    .total-label { font-size: 0.85rem; font-weight: 600; color: #718096; }
    .total-amount { font-size: 1.75rem; font-weight: 900; color: #E53E3E; }

    .btn-pay {
        width: 100%;
        padding: 1rem;
        background: #E53E3E;
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        box-shadow: 0 4px 12px rgba(229, 62, 62, 0.2);
        transition: all 0.2s;
    }
    .btn-pay:hover { background: #C53030; transform: translateY(-2px); }
    .btn-pay:disabled { background: #FED7D7; cursor: not-allowed; box-shadow: none; }

    /* Bottom Stats - Professional Compact */
    .pos-bottom-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 10px;
    }
    .stat-card {
        background: white;
        padding: 10px 14px !important;
        border-radius: 12px !important;
        display: flex;
        align-items: center;
        gap: 12px !important;
        border: 1px solid #E2E8F0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .stat-icon {
        width: 32px !important;
        height: 32px !important;
        border-radius: 8px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px !important;
    }
    .stat-info { display: flex; flex-direction: column; min-width: 0; line-height: 1.2 !important; }
    .stat-label { font-size: 11px !important; color: #718096; font-weight: 600 !important; margin-bottom: 2px !important; }
    .stat-value { font-size: 15px !important; font-weight: 700 !important; color: #2D3748; }
    .stat-meta { font-size: 10px !important; color: #A0AEC0; display: block !important; }
    [x-cloak] { display: none !important; }
</style>
@endpush
@section('content')
<div class="pos-layout" x-data="posKasir()" @keydown.window="handleKeydown($event)">
    {{-- TOAST NOTIFIKASI --}}
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-[-20px]"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         style="display:none; position:fixed; top:20px; right:50%; transform:translateX(50%); background:#22C55E; color:white; padding:12px 24px; border-radius:30px; font-weight:600; z-index:9999; box-shadow:0 4px 12px rgba(0,0,0,0.15); font-size: 0.9rem;">
        <i class="bi bi-check-circle-fill" style="margin-right:8px;"></i> <span x-text="toastMessage"></span>
    </div>

    {{-- TOP BAR --}}
    <header class="pos-top-bar">
        <div class="pos-search-wrapper">
            <i class="bi bi-search"></i>
            <input type="text" x-model="searchQuery" class="pos-search-input" placeholder="Cari menu... (F3)" x-ref="searchInput">
        </div>
    </header>

    <div class="pos-main-container">
        {{-- BAGIAN KIRI: DAFTAR MENU --}}
        <div class="pos-left">
            <nav class="pos-tabs">
                <button class="pos-tab" :class="{'active': activeTab === 'topping'}" @click="activeTab = 'topping'"><i class="bi bi-egg-fried"></i> Topping</button>
                <button class="pos-tab" :class="{'active': activeTab === 'minuman'}" @click="activeTab = 'minuman'"><i class="bi bi-cup-straw"></i> Minuman</button>
                <button class="pos-tab" :class="{'active': activeTab === 'cemilan'}" @click="activeTab = 'cemilan'"><i class="bi bi-basket"></i> Cemilan</button>
                <button class="pos-tab" :class="{'active': activeTab === 'lainnya'}" @click="activeTab = 'lainnya'"><i class="bi bi-grid"></i> Lainnya</button>
            </nav>

            <div class="menu-grid">
                <template x-for="item in filteredMenu" :key="item.id">
                    <div class="pos-item" @click="tambahItem(item)">
                        <div class="pos-item-id" x-text="'ID: ' + item.id"></div>
                        <div class="pos-item-img">
                            <template x-if="item.gambar_path">
                                <img :src="`/storage/${item.gambar_path}`" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                            </template>
                            <template x-if="!item.gambar_path">
                                <i class="bi bi-box" style="font-size:1.5rem; color:#CBD5E0;"></i>
                            </template>
                        </div>
                        <div class="pos-item-title" x-text="item.nama_menu"></div>
                        <div class="pos-item-price" x-text="formatRupiah(item.harga)"></div>
                    </div>
                </template>
            </div>
        </div>

        {{-- BAGIAN KANAN: KERANJANG --}}
        <aside class="pos-right">
            <div class="takeaway-section">
                <label class="takeaway-label"><i class="bi bi-bag-plus-fill"></i> INPUT PESANAN TAKE AWAY</label>
                <div class="takeaway-input-wrapper">
                    <input type="number" x-model="barcodeInput" @keydown.enter="scanBarcode()" placeholder="Ketik ID Take Away di sini..." x-ref="scannerInput" class="takeaway-input">
                    <i class="bi bi-keyboard-fill"></i>
                </div>
            </div>

            <div class="cart-title-section">
                <h2 class="cart-title">
                    <i class="bi bi-bag-fill" style="color:#E53E3E;"></i> 
                    Pesanan Saat Ini
                    <span class="cart-badge" x-text="keranjang.length"></span>
                </h2>
                <button class="btn-clear" @click="keranjang = []"><i class="bi bi-trash"></i></button>
            </div>

            <div class="cart-items">
                <template x-if="keranjang.length === 0">
                    <div style="text-align:center;color:#CBD5E0;margin-top:3rem;">
                        <i class="bi bi-cart-x" style="font-size:4rem; display:block; margin-bottom:1rem; opacity:0.3;"></i>
                        <p style="font-size:0.9rem; font-weight:600;">Belum ada item dipilih.</p>
                    </div>
                </template>

                <template x-for="item in keranjang" :key="item.id">
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <div class="cart-item-name" x-text="item.nama"></div>
                            <div class="cart-item-meta" x-text="item.qty + ' x ' + formatRupiah(item.harga)"></div>
                        </div>
                        <div class="cart-item-price" x-text="formatRupiah(item.harga * item.qty)"></div>
                        <button class="btn-remove" @click="hapusItem(item.id)"><i class="bi bi-x"></i></button>
                    </div>
                </template>
            </div>

            <div class="cart-footer">
                <form method="POST" action="{{ route('admin.pos.store') }}" id="formPos">
                    @csrf
                    <div id="hidden-inputs"></div>

                    <div style="display:flex; gap:0.75rem; margin-bottom:0.75rem;">
                        <div class="order-option" style="flex:1;">
                            <label class="option-label"><i class="bi bi-fire" style="color:#E53E3E;"></i> Level Pedas</label>
                            <select name="level_pedas" x-model="levelPedas" class="option-select">
                                <option value="0">Level 0 (Tidak Pedas)</option>
                                <option value="1">Level 1</option>
                                <option value="2">Level 2</option>
                                <option value="3">Level 3</option>
                                <option value="4">Level 4</option>
                                <option value="5">Level 5</option>
                            </select>
                        </div>
                        <div class="order-option" style="flex:1;">
                            <label class="option-label"><i class="bi bi-palette"></i> Jenis Rasa</label>
                            <select name="jenis_rasa" x-model="jenisRasa" class="option-select">
                                <option value="gurih">Asin / Gurih</option>
                                <option value="gurih_manis">Asin Manis</option>
                            </select>
                        </div>
                    </div>

                    <div class="order-option">
                        <label class="option-label">Nama Pemesan (Wajib)</label>
                        <input type="text" name="nama_pemesan" x-model="namaPemesan" x-ref="namaInput" placeholder="Contoh: Budi (Take Away)" class="option-input">
                    </div>

                    <div class="order-option">
                        <label class="option-label">Metode Pembayaran</label>
                        <div class="payment-methods">
                            <button type="button" class="payment-btn" :class="{'active': metodeBayar === 'cash'}" @click="metodeBayar = 'cash'">
                                <i class="bi bi-wallet2"></i>
                                Cash
                            </button>
                            <button type="button" class="payment-btn" :class="{'active': metodeBayar === 'qris'}" @click="metodeBayar = 'qris'">
                                <i class="bi bi-qr-code"></i>
                                QRIS
                            </button>
                            <input type="hidden" name="metode_bayar" x-model="metodeBayar">
                        </div>
                    </div>

                    <div class="total-section">
                        <span class="total-label">Total Bayar</span>
                        <span class="total-amount" x-text="formatRupiah(totalHarga)"></span>
                    </div>

                    <button type="button" @click="bukaModalBayar()" class="btn-pay" :disabled="keranjang.length === 0">
                        <i class="bi bi-lightning-fill"></i>
                        [F2] BAYAR SEKARANG
                    </button>
                </form>
            </div>
        </aside>
    </div>

    {{-- BOTTOM STATS --}}
    <div class="pos-bottom-stats">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FFF5F5; color:#E53E3E;"><i class="bi bi-receipt-cutoff"></i></div>
            <div class="stat-info">
                <span class="stat-label">Pesanan Masuk</span>
                <span class="stat-value">{{ $stats['pesanan_masuk'] }}</span>
                <span class="stat-meta">Baru saja</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#F0FFF4; color:#38A169;"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Hari Ini</span>
                <span class="stat-value">Rp {{ number_format($stats['total_hari_ini'], 0, ',', '.') }}</span>
                <span class="stat-meta">Penjualan</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EBF8FF; color:#3182CE;"><i class="bi bi-clock-fill"></i></div>
            <div class="stat-info">
                <span class="stat-label">Jam Sekarang</span>
                <span class="stat-value" x-text="jamSekarang"></span>
                <span class="stat-meta" x-text="tanggalSekarang"></span>
            </div>
        </div>
    </div>
    <!-- MODAL PEMBAYARAN -->
    <div x-cloak x-show="showModalBayar" style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:99999;backdrop-filter:blur(2px); display: flex; align-items: center; justify-content: center;">
            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white;width:90%;max-width:600px;border-radius:20px;overflow:hidden;box-shadow:0 20px 40px rgba(0,0,0,0.3);" @click.away="tutupModalBayar()">
                <div style="background:var(--primary);color:white;padding:1.5rem;text-align:center;font-weight:bold;font-size:1.5rem;letter-spacing:1px;">PROSES PEMBAYARAN</div>
                <div style="padding:2rem;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:1.5rem;border-bottom:2px dashed #eee;padding-bottom:1.5rem;">
                        <span style="font-weight:bold;color:#666;font-size:1.25rem;">Total Tagihan:</span>
                        <span style="font-size:2.5rem;font-weight:900;" x-text="formatRupiah(totalHarga)"></span>
                    </div>
                    
                    <div style="margin-bottom:2rem;">
                        <label style="display:block;font-weight:bold;margin-bottom:0.75rem;color:#333;font-size:1.1rem;">Uang Diterima (Tunai):</label>
                        <input type="text" 
                               x-model="uangDiterimaDisplay" 
                               x-ref="uangInput" 
                               @input="formatInputUang()"
                               @keydown.enter="submitPesanan()" 
                               @keydown.escape="tutupModalBayar()" 
                               style="width:100%; padding:1.5rem; font-size:3rem; font-weight:900; text-align:right; border:4px solid #ccc; border-radius:16px; outline:none; background:#fff; transition: border-color 0.2s;" 
                               :style="kembalian < 0 && uangDiterima ? 'border-color:#FF6B6B; color:#FF6B6B;' : 'border-color:#22C55E; color:#22C55E;'" 
                               placeholder="0">
                    </div>

                    <div style="background:#F8F9FA;padding:1.5rem;border-radius:12px;display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;border:2px solid #E0E0E0;">
                        <span style="font-weight:bold;color:#666;font-size:1.25rem;">Kembalian:</span>
                        <span style="font-size:2.5rem;font-weight:900;" :style="kembalian < 0 ? 'color:red;' : 'color:#22C55E;'" x-text="kembalian < 0 ? 'Kurang: ' + formatRupiah(Math.abs(kembalian)) : formatRupiah(kembalian)"></span>
                    </div>

                    <div style="display:flex;gap:1rem;">
                        <button type="button" @click="tutupModalBayar()" style="flex:1;padding:1.25rem;background:#E0E0E0;border:none;border-radius:12px;font-weight:bold;font-size:1.25rem;cursor:pointer;transition:background 0.2s;">Batal [ESC]</button>
                        <button type="button" @click="submitPesanan()" style="flex:2;padding:1.25rem;background:#22C55E;color:white;border:none;border-radius:12px;font-weight:bold;font-size:1.25rem;cursor:pointer;transition:background 0.2s;" :disabled="(kembalian < 0 && metodeBayar === 'cash') || isSubmitting" x-text="isSubmitting ? 'Memproses...' : 'Selesai [Enter]'"></button>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('posKasir', () => ({
            activeTab: 'topping',
            toppings: @json($toppings),
            minuman: @json($minuman),
            cemilan: @json($cemilan),
            keranjang: [],
            namaPemesan: '',
            levelPedas: '0',
            jenisRasa: 'gurih',
            metodeBayar: 'cash',
            showToast: false,
            toastMessage: '',
            toastTimeout: null,
            barcodeInput: '',
            showModalBayar: false,
            uangDiterima: 0,
            uangDiterimaDisplay: '',
            isSubmitting: false,
            searchQuery: '',
            jamSekarang: '',
            tanggalSekarang: '',

            init() {
                this.updateClock();
                setInterval(() => this.updateClock(), 1000);
                setTimeout(() => {
                    if(this.$refs.scannerInput) this.$refs.scannerInput.focus();
                }, 100);
            },

            updateClock() {
                const now = new Date();
                this.jamSekarang = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
                this.tanggalSekarang = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            },

            get totalHarga() {
                return this.keranjang.reduce((total, item) => total + (item.harga * item.qty), 0);
            },

            get kembalian() {
                return (this.uangDiterima || 0) - this.totalHarga;
            },

            get filteredMenu() {
                let currentMenu = [];
                if (this.activeTab === 'topping') currentMenu = this.toppings;
                if (this.activeTab === 'minuman') currentMenu = this.minuman;
                if (this.activeTab === 'cemilan') currentMenu = this.cemilan;
                if (this.activeTab === 'lainnya') currentMenu = []; 
                
                if (!this.searchQuery) return currentMenu;
                
                return currentMenu.filter(m => 
                    m.nama_menu.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                    m.id.toString() === this.searchQuery
                );
            },

            semuaMenu() {
                return [...this.toppings, ...this.minuman, ...this.cemilan];
            },

            playBeep() {
                const context = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = context.createOscillator();
                const gainNode = context.createGain();
                oscillator.type = 'sine';
                oscillator.frequency.value = 900;
                gainNode.gain.setValueAtTime(0.1, context.currentTime);
                oscillator.connect(gainNode);
                gainNode.connect(context.destination);
                oscillator.start();
                setTimeout(() => oscillator.stop(), 100);
            },

            playError() {
                const context = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = context.createOscillator();
                oscillator.type = 'sawtooth';
                oscillator.frequency.value = 200;
                oscillator.connect(context.destination);
                oscillator.start();
                setTimeout(() => oscillator.stop(), 200);
            },

            playSuccess() {
                const context = new (window.AudioContext || window.webkitAudioContext)();
                const playNote = (freq, timeOffset, duration) => {
                    const oscillator = context.createOscillator();
                    const gainNode = context.createGain();
                    oscillator.type = 'sine';
                    oscillator.frequency.value = freq;
                    gainNode.gain.setValueAtTime(0, context.currentTime + timeOffset);
                    gainNode.gain.linearRampToValueAtTime(0.1, context.currentTime + timeOffset + 0.05);
                    gainNode.gain.exponentialRampToValueAtTime(0.001, context.currentTime + timeOffset + duration);
                    oscillator.connect(gainNode);
                    gainNode.connect(context.destination);
                    oscillator.start(context.currentTime + timeOffset);
                    oscillator.stop(context.currentTime + timeOffset + duration);
                };
                playNote(523.25, 0.0, 0.2); 
                playNote(659.25, 0.1, 0.2);
                playNote(783.99, 0.2, 0.2);
                playNote(1046.50, 0.3, 0.5);
            },

            scanBarcode() {
                if(!this.barcodeInput) return;
                const menuId = parseInt(this.barcodeInput);
                const menu = this.semuaMenu().find(m => m.id === menuId);
                if(menu) {
                    this.tambahItem(menu);
                } else {
                    this.playError();
                    alert("Barang dengan ID " + menuId + " tidak ditemukan!");
                }
                this.barcodeInput = '';
                this.$refs.scannerInput.focus();
            },

            handleKeydown(e) {
                if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'SELECT' && !this.showModalBayar) {
                    if (e.key >= '0' && e.key <= '9') {
                        this.$refs.scannerInput.focus();
                    }
                }
                if (e.key === 'F2') {
                    e.preventDefault();
                    this.bukaModalBayar();
                }
                if (e.key === 'F3') {
                    e.preventDefault();
                    this.$refs.searchInput.focus();
                }
                if (e.key === 'Delete' && !this.showModalBayar) {
                    this.keranjang = [];
                }
            },

            bukaModalBayar() {
                if (this.keranjang.length === 0) {
                    alert('Keranjang masih kosong!');
                    return;
                }
                if (!this.namaPemesan || !this.namaPemesan.trim()) {
                    alert('Mohon isi NAMA PEMESAN terlebih dahulu!');
                    if(this.$refs.namaInput) this.$refs.namaInput.focus();
                    return;
                }
                this.showModalBayar = true;
                this.uangDiterima = 0;
                this.uangDiterimaDisplay = '';
                this.isSubmitting = false; 
                setTimeout(() => {
                    if(this.$refs.uangInput) this.$refs.uangInput.focus();
                }, 200);
            },

            formatInputUang() {
                let val = this.uangDiterimaDisplay.replace(/[^0-9]/g, '');
                this.uangDiterima = val ? parseInt(val) : 0;
                if (val) {
                    this.uangDiterimaDisplay = new Intl.NumberFormat('id-ID').format(val);
                } else {
                    this.uangDiterimaDisplay = '';
                }
            },

            tutupModalBayar() {
                this.showModalBayar = false;
                setTimeout(() => this.$refs.scannerInput.focus(), 100);
            },

            tambahItem(menu) {
                this.playBeep();
                let existing = this.keranjang.find(i => i.id === menu.id);
                if (existing) {
                    existing.qty++;
                } else {
                    this.keranjang.push({
                        id: menu.id,
                        nama: menu.nama_menu,
                        harga: menu.harga,
                        qty: 1
                    });
                }
                this.toastMessage = menu.nama_menu + ' +1';
                this.showToast = true;
                clearTimeout(this.toastTimeout);
                this.toastTimeout = setTimeout(() => { this.showToast = false; }, 1500);
            },

            tambahQty(id) {
                let item = this.keranjang.find(i => i.id === id);
                if (item) item.qty++;
            },

            kurangQty(id) {
                let item = this.keranjang.find(i => i.id === id);
                if (item) {
                    item.qty--;
                    if (item.qty <= 0) {
                        this.keranjang = this.keranjang.filter(i => i.id !== id);
                    }
                }
            },

            hapusItem(id) {
                this.keranjang = this.keranjang.filter(i => i.id !== id);
            },

            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            },

            submitPesanan() {
                if (this.isSubmitting) return;
                if (this.kembalian < 0 && this.metodeBayar === 'cash') {
                    alert('Uang pembayaran kurang!');
                    return;
                }

                this.isSubmitting = true;
                this.playSuccess();
                const container = document.getElementById('hidden-inputs');
                container.innerHTML = '';
                this.keranjang.forEach((item, index) => {
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = `items[${index}][menu_id]`;
                    inputId.value = item.id;
                    const inputQty = document.createElement('input');
                    inputQty.type = 'hidden';
                    inputQty.name = `items[${index}][jumlah]`;
                    inputQty.value = item.qty;
                    container.appendChild(inputId);
                    container.appendChild(inputQty);
                });
                this.showModalBayar = false;
                this.keranjang = [];
                this.uangDiterima = 0;
                this.uangDiterimaDisplay = '';
                this.namaPemesan = '';
                document.getElementById('formPos').submit();
            }
        }));
    });
</script>
@endpush
