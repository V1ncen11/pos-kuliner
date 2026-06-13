@extends('layouts.order')
@section('title', 'Resto Cafe — Pilih Menu')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div x-data="orderMenu()" x-cloak style="padding-bottom:6rem;">
    {{-- PROGRESS STEPS --}}
    <div class="progress-steps">
        <div class="progress-step done">
            <span class="step-num"><i class="bi bi-check" style="font-size:0.7rem;"></i></span> Identifikasi
        </div>
        <div class="progress-connector done"></div>
        <div class="progress-step active">
            <span class="step-num">2</span> Pilih Menu
        </div>
        <div class="progress-connector"></div>
        <div class="progress-step">
            <span class="step-num">3</span> Checkout
        </div>
    </div>

    {{-- HEADER --}}
    <div class="header-order">
        <div style="display:flex;justify-content:space-between;align-items:center;max-width:480px;margin:0 auto;">
            <div class="logo"><i class="bi bi-flower2"></i> Resto Cafe</div>
            <div class="meja-badge">Meja {{ $nomor_meja }}</div>
        </div>
    </div>

    {{-- TOAST CONTAINER --}}
    <div class="toast-container" id="toastContainer"></div>

    <div class="container-order" style="padding-top:1.5rem;">
        {{-- GREETING --}}
        <div class="animate-slide-up" style="margin-bottom:1.25rem;">
            <h2 class="font-poppins" style="font-size:1.2rem;font-weight:700;">Halo, {{ $nama_pemesan }}! 👋</h2>
            <p style="color:var(--text-secondary);font-size:0.85rem;margin-top:0.25rem;">Mau makan apa hari ini?</p>
        </div>

        {{-- PROMO BANNER --}}
        <div class="animate-slide-up promo-scroll" style="margin-bottom:1.25rem;">
            <div class="promo-card" style="background:linear-gradient(135deg,#22C55E,#16A34A); color:white;">
                <p style="font-size:0.65rem;text-transform:uppercase;letter-spacing:1.5px;opacity:0.85;margin-bottom:0.25rem;font-weight:600;"><i class="bi bi-tag-fill"></i> Promo Spesial</p>
                <h3 class="font-poppins" style="font-weight:700;font-size:1.05rem;margin-bottom:0.25rem;">Diskon 10% Tiap Jumat!</h3>
                <p style="font-size:0.78rem;opacity:0.8;">Berlaku untuk semua menu</p>
            </div>
            <div class="promo-card" style="background:linear-gradient(135deg,#DCF0E3,#FFFFFF); color:var(--text-primary);">
                <p style="font-size:0.65rem;text-transform:uppercase;letter-spacing:1.5px;opacity:0.85;margin-bottom:0.25rem;font-weight:600;"><i class="bi bi-star-fill" style="color:#FBBF24;"></i> Favorit Pilihan</p>
                <h3 class="font-poppins" style="font-weight:700;font-size:1.05rem;margin-bottom:0.25rem;">Kopi Susu Aren</h3>
                <p style="font-size:0.78rem;opacity:0.8;">Paling banyak dipesan minggu ini</p>
            </div>
        </div>



        {{-- QUICK INFO --}}
        <div class="animate-slide-up" style="margin-bottom:1.25rem;">
            <div class="quick-info-box">
                <i class="bi bi-clock" style="color:var(--primary);font-size:1.35rem;"></i>
                <div style="text-align:left;">
                    <p style="font-size:0.7rem;color:var(--text-muted);margin:0;">Estimasi Penyajian</p>
                    <p class="font-poppins" style="font-weight:700;font-size:0.9rem;margin:0;color:var(--text-primary);">10-20 Menit</p>
                </div>
            </div>
        </div>

        {{-- CATEGORY TABS --}}
        <div style="display:flex;gap:0.5rem;overflow-x:auto;padding-bottom:0.5rem;margin-bottom:1rem;-ms-overflow-style:none;scrollbar-width:none;">
            <div class="category-tab" :class="{'active': activeTab === 'makanan'}" @click="switchTab('makanan')"><i class="bi bi-egg-fried"></i> Makanan</div>
            <div class="category-tab" :class="{'active': activeTab === 'minuman'}" @click="switchTab('minuman')"><i class="bi bi-cup-straw"></i> Minuman</div>
            <div class="category-tab" :class="{'active': activeTab === 'snack'}" @click="switchTab('snack')"><i class="bi bi-cookie"></i> Snack</div>
        </div>

        {{-- SEARCH --}}
        <div class="search-input-wrapper">
            <i class="bi bi-search"></i>
            <input type="text" x-model="searchQuery" placeholder="Cari menu..." @input="filterMenu()">
        </div>

        {{-- ICON MAP --}}
        @php
        $iconMap = [
            'Nasi Goreng Spesial' => 'egg-fried', 'Ayam Bakar Madu' => 'fire', 'Mie Gacoan Level 1-5' => 'bezier2',
            'Nasi Gila' => 'bucket', 'Spaghetti Bolognese' => 'bezier', 'Kwetiau Goreng' => 'bezier',
            'Es Kopi Susu Aren' => 'cup-hot', 'Matcha Latte' => 'cup-hot-fill', 'Lychee Tea' => 'cup-straw',
            'Lemon Tea' => 'cup-straw', 'Air Mineral' => 'droplet', 'Es Coklat' => 'cup-hot',
            'Kentang Goreng' => 'list-columns', 'Dimsum Ayam' => 'box-seam-fill', 'Cireng Bumbu Rujak' => 'cookie',
            'Pisang Bakar Coklat' => 'moon', 'Roti Bakar Keju' => 'square-half', 'Platter Mix' => 'boxes'
        ];
        $popularItems = ['Nasi Goreng Spesial', 'Mie Gacoan Level 1-5', 'Es Kopi Susu Aren', 'Dimsum Ayam'];
        @endphp

        {{-- MENU ITEMS --}}
        <div class="tab-content-wrapper">
            
            @foreach(['makanan', 'minuman', 'snack'] as $kat)
            <div x-show="activeTab === '{{ $kat }}'" x-transition:enter="tab-content-panel">
            <div style="display:grid;grid-template-columns:repeat(2, 1fr);gap:0.75rem;">
                @foreach($$kat as $item)
                <div class="menu-card" x-show="isItemVisible('{{ addslashes($item->nama_menu) }}')" @click="openModal({{ $item->id }}, '{{ addslashes($item->nama_menu) }}', {{ $item->harga }}, '{{ $item->gambar_path }}', '{{ $iconMap[$item->nama_menu] ?? 'egg-fried' }}')">
                    @if(in_array($item->nama_menu, $popularItems))
                        <span class="badge-popular"><i class="bi bi-star-fill" style="font-size:0.55rem;"></i> POPULER</span>
                    @endif
                    
                    <div class="menu-card-img">
                        @if($item->gambar_path)
                            <img src="{{ Str::startsWith($item->gambar_path, 'http') ? $item->gambar_path : asset('storage/' . $item->gambar_path) }}" alt="{{ $item->nama_menu }}" loading="lazy">
                        @else
                            <div class="img-placeholder" style="color:var(--primary);">
                                <i class="bi bi-{{ $iconMap[$item->nama_menu] ?? 'egg-fried' }}"></i>
                            </div>
                        @endif
                    </div>

                    <div class="menu-card-body">
                        <h4>{{ $item->nama_menu }}</h4>
                        <div class="menu-card-footer">
                            <span class="menu-card-price">{{ $item->harga_format }}</span>
                            <button class="menu-card-add"><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="empty-search" x-show="!hasVisibleItems('{{ $kat }}')" style="display:none;grid-column:1/-1;" :style="!hasVisibleItems('{{ $kat }}') ? 'display:block' : 'display:none'">
                    <i class="bi bi-search"></i>
                    <p>Menu tidak ditemukan</p>
                </div>
            </div>
            </div>
            @endforeach

        </div>

        {{-- INFO WARUNG --}}
        <div class="info-warung" style="margin-top:2rem;">
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem;">
                <div style="width:3px;height:18px;background:var(--primary);border-radius:3px;"></div>
                <h3 class="font-poppins" style="font-weight:700;font-size:0.95rem;">Info Resto Cafe</h3>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                <div style="display:flex;align-items:flex-start;gap:0.5rem;">
                    <i class="bi bi-clock" style="color:var(--primary);margin-top:2px;font-size:0.9rem;"></i>
                    <div>
                        <p style="font-size:0.7rem;color:var(--text-muted);">Jam Buka</p>
                        <p style="font-size:0.82rem;font-weight:600;color:var(--text-primary);">10:00 - 22:00</p>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:0.5rem;">
                    <i class="bi bi-geo-alt" style="color:var(--primary);margin-top:2px;font-size:0.9rem;"></i>
                    <div>
                        <p style="font-size:0.7rem;color:var(--text-muted);">Lokasi</p>
                        <p style="font-size:0.82rem;font-weight:600;color:var(--text-primary);">Pusat Kota</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div style="text-align:center;padding:1.5rem 0 0.5rem;font-size:0.7rem;color:var(--text-muted);">
            <p>Powered by Resto Cafe © {{ date('Y') }}</p>
        </div>
    </div>

    {{-- ADD ITEM MODAL --}}
    <div x-show="showItemModal" x-transition class="modal-overlay" style="z-index: 100;" @click.self="closeModal()">
        <div class="modal-content animate-slide-up" style="bottom: 0; position: absolute; width: 100%; max-height: 85vh; overflow-y: auto;">
            {{-- Drag indicator --}}
            <div style="display:flex;justify-content:center;margin-bottom:1rem;">
                <div style="width:36px;height:4px;background:var(--bg-elevated);border-radius:4px;"></div>
            </div>

            <div style="display:flex;justify-content:flex-end;margin-bottom:0.5rem;">
                <button @click="closeModal()" style="background:var(--bg-elevated);border:none;width:30px;height:30px;border-radius:50%;cursor:pointer;color:var(--text-secondary);display:flex;align-items:center;justify-content:center;transition:var(--transition);" onmouseover="this.style.background='rgba(34,197,94,0.15)';this.style.color='#22C55E'" onmouseout="this.style.background='var(--bg-elevated)';this.style.color='var(--text-secondary)'"><i class="bi bi-x-lg"></i></button>
            </div>
            
            <div style="text-align:center; margin-bottom:1.5rem;">
                <template x-if="selectedItem.img">
                    <img :src="selectedItem.img" style="width:120px;height:120px;border-radius:var(--radius-lg);object-fit:cover;box-shadow:0 10px 30px rgba(0,0,0,0.15);margin-bottom:1rem;display:inline-block;border:2px solid var(--border-color);">
                </template>
                <template x-if="!selectedItem.img">
                    <div style="width:100px;height:100px;border-radius:var(--radius-lg);background:var(--bg-elevated);color:var(--primary);display:inline-flex;align-items:center;justify-content:center;font-size:2.5rem;margin-bottom:1rem;border:1px solid var(--border-color);">
                        <i :class="'bi bi-' + selectedItem.icon"></i>
                    </div>
                </template>
                <h3 class="font-poppins" style="font-weight:700;font-size:1.2rem;color:var(--text-primary);margin-bottom:0.25rem;" x-text="selectedItem.nama"></h3>
                <p style="color:var(--primary);font-weight:700;font-size:1.05rem;margin:0;" x-text="formatRupiah(selectedItem.harga)"></p>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="font-weight:600;font-size:0.85rem;color:var(--text-primary);display:block;margin-bottom:0.5rem;"><i class="bi bi-chat-left-text" style="color:var(--primary);margin-right:4px;"></i> Catatan Khusus</label>
                <textarea class="form-input" x-model="selectedItem.catatan" placeholder="Contoh: Tambahin sambel, nasinya dibanyakin..." rows="2"></textarea>
            </div>

            <div style="display:flex;justify-content:center;align-items:center;gap:1.5rem;margin-bottom:1.5rem;background:var(--bg-elevated);padding:0.75rem;border-radius:var(--radius-md);border:1px solid var(--border-color);">
                <button @click="if(selectedItem.qty > 1) selectedItem.qty--" style="width:40px;height:40px;border-radius:var(--radius-sm);border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);font-size:1.25rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:var(--transition);" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border-color)'"><i class="bi bi-dash"></i></button>
                <span style="font-size:1.25rem;font-weight:700;color:var(--text-primary);min-width:30px;text-align:center;font-family:'Poppins',sans-serif;" x-text="selectedItem.qty"></span>
                <button @click="selectedItem.qty++" style="width:40px;height:40px;border-radius:var(--radius-sm);border:1px solid var(--border-color);background:var(--bg-card);color:var(--primary);font-size:1.25rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:var(--transition);" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border-color)'"><i class="bi bi-plus"></i></button>
            </div>

            <button class="btn-primary" style="width:100%;font-size:0.95rem;padding:0.875rem;display:flex;justify-content:space-between;align-items:center;" @click="addToCart()">
                <span><i class="bi bi-cart-plus" style="margin-right:4px;"></i> Tambah ke Keranjang</span>
                <span style="background:rgba(255,255,255,0.2);padding:0.2rem 0.65rem;border-radius:8px;font-size:0.85rem;" x-text="formatRupiah(selectedItem.harga * selectedItem.qty)"></span>
            </button>
        </div>
    </div>

    {{-- CART MODAL --}}
    <div x-show="showCart" x-transition class="modal-overlay" @click.self="showCart = false" style="z-index: 90;">
        <div class="modal-content animate-slide-up" style="bottom: 0; position: absolute; width: 100%; max-height: 90vh; overflow-y: auto;">
            {{-- Drag indicator --}}
            <div style="display:flex;justify-content:center;margin-bottom:1rem;">
                <div style="width:36px;height:4px;background:var(--bg-elevated);border-radius:4px;"></div>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
                <h3 class="font-poppins" style="font-weight:700;font-size:1.05rem;"><i class="bi bi-cart3" style="color:var(--primary);margin-right:4px;"></i> Keranjang</h3>
                <button @click="showCart = false" style="background:var(--bg-elevated);border:none;width:30px;height:30px;border-radius:50%;cursor:pointer;color:var(--text-secondary);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <template x-if="cart.length > 0">
                <div>
                    <div style="background:var(--bg-elevated);border-radius:var(--radius-md);padding:0.75rem;margin-bottom:1.25rem;border:1px solid var(--border-color);">
                        <template x-for="(item, index) in cart" :key="index">
                            <div style="padding:0.75rem 0;border-bottom:1px solid var(--border-color);" :style="index === cart.length - 1 ? 'border-bottom:none;padding-bottom:0;' : (index === 0 ? 'padding-top:0;' : '')">
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.35rem;">
                                    <div style="flex:1;padding-right:0.75rem;">
                                        <h4 style="font-size:0.9rem;font-weight:600;margin:0 0 0.15rem;color:var(--text-primary);" x-text="item.nama"></h4>
                                        <p style="font-size:0.78rem;color:var(--primary);font-weight:600;margin:0;" x-text="formatRupiah(item.harga)"></p>
                                    </div>
                                    <div style="font-weight:700;color:var(--text-primary);font-size:0.9rem;font-family:'Poppins',sans-serif;" x-text="formatRupiah(item.harga * item.qty)"></div>
                                </div>
                                
                                <template x-if="item.catatan">
                                    <p style="font-size:0.75rem;color:var(--text-muted);background:var(--bg-card);padding:0.4rem 0.6rem;border-radius:8px;margin-bottom:0.5rem;font-style:italic;border:1px solid var(--border-color);">
                                        <i class="bi bi-chat-left-text" style="margin-right:3px;color:var(--primary);"></i> <span x-text="item.catatan"></span>
                                    </p>
                                </template>

                                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:0.5rem;">
                                    <button @click="removeFromCart(index)" style="background:none;border:none;color:#EF4444;font-size:0.75rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:0.2rem;opacity:0.8;transition:var(--transition);" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                    <div style="display:flex;align-items:center;gap:0.75rem;background:var(--bg-card);padding:0.2rem 0.5rem;border-radius:8px;border:1px solid var(--border-color);">
                                        <button @click="if(item.qty > 1) item.qty--" style="background:none;border:none;color:var(--text-muted);font-size:1rem;cursor:pointer;"><i class="bi bi-dash"></i></button>
                                        <span style="font-weight:700;font-size:0.85rem;min-width:18px;text-align:center;color:var(--text-primary);" x-text="item.qty"></span>
                                        <button @click="item.qty++" style="background:none;border:none;color:var(--primary);font-size:1rem;cursor:pointer;"><i class="bi bi-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem;background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.15);border-radius:var(--radius-md);margin-bottom:1.25rem;">
                        <span style="font-weight:600;color:var(--primary-light);font-size:0.9rem;">Total Tagihan</span>
                        <span style="font-weight:800;font-size:1.15rem;color:var(--primary);font-family:'Poppins',sans-serif;" x-text="formatRupiah(totalHarga)"></span>
                    </div>

                    <button class="btn-primary" style="width:100%;font-size:0.95rem;padding:0.875rem;" @click="lanjutCheckout()">
                        Pilih Pembayaran <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </template>
            <template x-if="cart.length === 0">
                <div style="text-align:center;padding:2.5rem 0;">
                    <i class="bi bi-cart-x" style="font-size:3.5rem;color:var(--text-muted);opacity:0.3;margin-bottom:0.75rem;display:block;"></i>
                    <h4 style="font-size:1rem;font-weight:600;color:var(--text-primary);margin-bottom:0.35rem;">Keranjang Masih Kosong</h4>
                    <p style="color:var(--text-muted);font-size:0.85rem;">Yuk, pilih menu favoritmu dulu!</p>
                    <button class="btn-primary" style="margin-top:1rem;padding:0.65rem 1.5rem;border-radius:var(--radius-full);font-size:0.85rem;" @click="showCart = false">Pilih Menu</button>
                </div>
            </template>
        </div>
    </div>

    {{-- CHECKOUT MODAL --}}
    <div x-show="showCheckout" x-transition class="modal-overlay" @click.self="showCheckout = false" style="z-index: 110;">
        <div class="modal-content animate-slide-up" style="bottom: 0; position: absolute; width: 100%; max-height: 90vh; overflow-y: auto;">
            {{-- Drag indicator --}}
            <div style="display:flex;justify-content:center;margin-bottom:1rem;">
                <div style="width:36px;height:4px;background:var(--bg-elevated);border-radius:4px;"></div>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                <h3 class="font-poppins" style="font-weight:700;font-size:1.05rem;"><i class="bi bi-credit-card" style="color:var(--primary);margin-right:4px;"></i> Pembayaran</h3>
                <button @click="showCheckout = false" style="background:var(--bg-elevated);border:none;width:30px;height:30px;border-radius:50%;cursor:pointer;color:var(--text-secondary);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            {{-- VALIDASI ERRORS --}}
            @if($errors->any())
                <div class="alert-error" style="background:#FEE2E2;border:1px solid #FCA5A5;color:#B91C1C;padding:1rem;border-radius:var(--radius-md);margin-bottom:1.25rem;text-align:left;">
                    <p style="font-weight:700;margin-bottom:0.5rem;"><i class="bi bi-exclamation-triangle-fill"></i> Pesanan Gagal Diproses</p>
                    <ul style="margin:0;padding-left:1.25rem;font-size:0.85rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.15);padding:1.25rem;border-radius:var(--radius-md);text-align:center;margin-bottom:1.25rem;">
                <p style="font-size:0.8rem;color:var(--primary-light);margin-bottom:0.2rem;font-weight:600;">Total Pembayaran</p>
                <p style="font-family:'Poppins',sans-serif;font-weight:800;font-size:1.6rem;margin:0;color:var(--primary);" x-text="formatRupiah(totalHarga)"></p>
            </div>

            {{-- PERINGATAN --}}
            <div style="background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.2);border-radius:var(--radius-md);padding:1rem;margin-bottom:1.25rem;text-align:center;">
                <i class="bi bi-info-circle-fill" style="color:#FBBF24;font-size:1.25rem;"></i>
                <p style="font-weight:700;font-size:0.85rem;color:#FBBF24;margin-top:0.35rem;">Harap Bayar Sebelum Pulang</p>
                <p style="font-size:0.75rem;color:var(--text-secondary);margin-top:0.2rem;">Pesanan akan diproses setelah pembayaran. Silakan bayar dulu ya.</p>
            </div>

            {{-- PILIH METODE --}}
            <div class="section-title" style="font-size:0.9rem;">Metode Pembayaran</div>
            <div style="display:flex;gap:0.5rem;margin-bottom:1.25rem;">
                <div class="rasa-option" :class="{'active': metodeBayar === 'cash'}" @click="metodeBayar = 'cash'" style="flex:1;font-size:0.82rem;"><i class="bi bi-cash-stack"></i> Cash</div>
                <div class="rasa-option" :class="{'active': metodeBayar === 'qris'}" @click="metodeBayar = 'qris'" style="flex:1;font-size:0.82rem;"><i class="bi bi-qr-code"></i> QRIS</div>
            </div>

            {{-- QRIS --}}
            <div x-show="metodeBayar === 'qris'" x-transition style="margin-bottom:1.25rem;">
                <div style="background:var(--bg-elevated);padding:1rem;border-radius:var(--radius-md);text-align:center;margin-bottom:0.75rem;border:1px solid var(--border-color);">
                    <p style="font-size:0.8rem;color:var(--text-secondary);margin-bottom:0.5rem;">Scan QRIS atau transfer ke rekening berikut:</p>
                    <div style="background:var(--bg-card);padding:1.25rem;border-radius:var(--radius-sm);border:2px dashed var(--border-color);">
                        <i class="bi bi-qr-code" style="font-size:2.5rem;color:var(--primary);"></i>
                        <p style="font-size:0.75rem;color:var(--text-muted);margin-top:0.35rem;">QRIS Resto Cafe</p>
                    </div>
                </div>
                <label class="form-label" style="font-size:0.82rem;"><i class="bi bi-upload" style="color:var(--primary);"></i> Upload Bukti Transfer *</label>
                <input type="file" name="bukti_bayar" form="checkoutForm" id="bukti_bayar_input" accept="image/*" @change="handleBuktiBayar($event)" class="form-input" style="padding:0.5rem;font-size:0.82rem;">
                <p x-show="buktiBayarName" style="font-size:0.75rem;color:#22C55E;margin-top:0.35rem;"><i class="bi bi-check-circle-fill"></i> <span x-text="buktiBayarName"></span></p>
            </div>

            {{-- CASH --}}
            <div x-show="metodeBayar === 'cash'" x-transition style="margin-bottom:1.25rem;">
                <div style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.15);padding:1rem;border-radius:var(--radius-md);text-align:center;">
                    <i class="bi bi-person-badge" style="font-size:1.75rem;color:#22C55E;"></i>
                    <p style="font-weight:600;margin-top:0.35rem;color:#86EFAC;font-size:0.9rem;">Bayar Cash</p>
                    <p style="font-size:0.78rem;color:var(--text-secondary);margin-top:0.2rem;">Bayar dulu ke kasir, baru pesanan dibuat.</p>
                </div>
            </div>

            <form id="checkoutForm" method="POST" action="{{ route('order.checkout') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="nama_pemesan" value="{{ $nama_pemesan }}">
                <input type="hidden" name="nomor_meja" value="{{ $nomor_meja }}">
                <input type="hidden" name="metode_bayar" :value="metodeBayar">

                <template x-for="(item, index) in cart" :key="index">
                    <div>
                        <input type="hidden" :name="'items['+index+'][menu_id]'" :value="item.id">
                        <input type="hidden" :name="'items['+index+'][jumlah]'" :value="item.qty">
                        <input type="hidden" :name="'items['+index+'][catatan]'" :value="item.catatan">
                    </div>
                </template>

                <button type="submit" class="btn-primary" style="width:100%;font-size:1rem;padding:1rem;" :disabled="submitting || (metodeBayar === 'qris' && !buktiBayarFile)" @click.prevent="submitOrder()">
                    <span x-show="!submitting"><i class="bi bi-check-circle" style="margin-right:4px;"></i> Buat Pesanan</span>
                    <span x-show="submitting"><i class="bi bi-arrow-repeat" style="animation:spin 1s linear infinite;display:inline-block;"></i> Sedang Memproses...</span>
                </button>
            </form>
        </div>
    </div>

    {{-- FLOATING CART BUTTON --}}
    <div class="floating-cart" :class="cartAnimation" x-show="totalItem > 0 && !showCart && !showCheckout" x-transition @click="showCart = true">
        <span class="cart-count" x-text="totalItem"></span>
        <span style="font-weight:600;font-size:0.85rem;"><i class="bi bi-cart3"></i> Keranjang</span>
        <span style="margin-left:auto;font-weight:700;font-size:0.85rem;" x-text="formatRupiah(totalHarga)"></span>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function orderMenu() {
    return {
        cart: [],
        activeTab: 'makanan',
        showItemModal: false,
        showCart: false,
        showCheckout: {{ $errors->any() ? 'true' : 'false' }},
        selectedItem: { id: null, nama: '', harga: 0, img: '', icon: '', qty: 1, catatan: '' },
        metodeBayar: 'cash',
        buktiBayarFile: null,
        buktiBayarName: '',
        submitting: false,
        searchQuery: '',
        cartAnimation: '',
        allMenus: @json($makanan->merge($minuman)->merge($snack)),
        menuNames: {
            makanan: @json($makanan->pluck('nama_menu')->toArray()),
            minuman: @json($minuman->pluck('nama_menu')->toArray()),
            snack: @json($snack->pluck('nama_menu')->toArray()),
        },
        cartStorageKey: 'resto_cart_meja_{{ $nomor_meja }}_{{ Str::slug($nama_pemesan) }}',

        init() {
            const savedData = localStorage.getItem(this.cartStorageKey);
            if (savedData) {
                try {
                    const parsed = JSON.parse(savedData);
                    if (parsed && Array.isArray(parsed)) {
                        this.cart = parsed;
                    }
                } catch(e) {
                    console.error('Error parsing cart from localStorage', e);
                }
            }

            this.$watch('cart', value => {
                localStorage.setItem(this.cartStorageKey, JSON.stringify(value));
            });
        },

        switchTab(tab) {
            this.activeTab = tab;
            this.searchQuery = '';
        },

        isItemVisible(nama) {
            if (!this.searchQuery) return true;
            return nama.toLowerCase().includes(this.searchQuery.toLowerCase());
        },

        hasVisibleItems(category) {
            if (!this.searchQuery) return true;
            return this.menuNames[category].some(name =>
                name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },

        showToast(message) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast-item';
            toast.innerHTML = '<i class="bi bi-check-circle-fill" style="color:#22C55E;"></i> ' + message;
            container.appendChild(toast);
            setTimeout(() => { toast.remove(); }, 2200);
        },

        openModal(id, nama, harga, gambar, icon) {
            let imgUrl = '';
            if (gambar) {
                imgUrl = gambar.startsWith('http') ? gambar : '/storage/' + gambar;
            }
            this.selectedItem = {
                id: id,
                nama: nama,
                harga: parseInt(harga),
                img: imgUrl,
                icon: icon,
                qty: 1,
                catatan: ''
            };
            this.showItemModal = true;
        },

        closeModal() {
            this.showItemModal = false;
        },

        addToCart() {
            // Cek apakah item dengan ID dan Catatan yang SAMA sudah ada
            const existingIdx = this.cart.findIndex(i => i.id === this.selectedItem.id && i.catatan === this.selectedItem.catatan);
            if (existingIdx !== -1) {
                this.cart[existingIdx].qty += this.selectedItem.qty;
            } else {
                this.cart.push({ ...this.selectedItem });
            }
            
            this.closeModal();
            this.showToast(this.selectedItem.qty + ' ' + this.selectedItem.nama + ' ditambahkan');
            
            this.cartAnimation = 'cart-enter';
            setTimeout(() => { this.cartAnimation = ''; }, 600);
        },

        removeFromCart(index) {
            this.cart.splice(index, 1);
        },

        get totalHarga() {
            return this.cart.reduce((sum, item) => sum + (item.harga * item.qty), 0);
        },

        get totalItem() {
            return this.cart.reduce((sum, item) => sum + item.qty, 0);
        },

        formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        },

        lanjutCheckout() {
            this.showCart = false;
            setTimeout(() => {
                this.showCheckout = true;
            }, 300);
        },

        handleBuktiBayar(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire('File Terlalu Besar', 'Maksimal ukuran file adalah 5MB.', 'error');
                    e.target.value = '';
                    this.buktiBayarFile = null;
                    this.buktiBayarName = '';
                    return;
                }
                this.buktiBayarFile = file;
                this.buktiBayarName = file.name;
            }
        },

        submitOrder() {
            if (this.cart.length === 0) {
                Swal.fire('Oops!', 'Keranjang masih kosong.', 'warning');
                return;
            }
            if (this.metodeBayar === 'qris' && !this.buktiBayarFile) {
                Swal.fire('Oops!', 'Silakan upload bukti pembayaran QRIS terlebih dahulu.', 'warning');
                return;
            }

            this.submitting = true;
            document.getElementById('checkoutForm').submit();
        }
    }
}
</script>
@endpush
@endsection
