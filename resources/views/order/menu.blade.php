@extends('layouts.order')
@section('title', 'Seblak Saiton — Pilih Menu')

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
            <div class="logo"><i class="bi bi-fire" style="color:#60A5FA;"></i> Seblak Saiton</div>
            <div class="meja-badge">Meja {{ $nomor_meja }}</div>
        </div>
    </div>

    {{-- TOAST CONTAINER --}}
    <div class="toast-container" id="toastContainer"></div>

    <div class="container-order" style="padding-top:1.5rem;">
        {{-- GREETING --}}
        <div class="animate-slide-up" style="margin-bottom:1.25rem;">
            <h2 class="font-poppins" style="font-size:1.25rem;">Hai, {{ $nama_pemesan }}!</h2>
            <p style="color:var(--text-muted);font-size:0.875rem;">Yuk pilih menu seblak favoritmu</p>
        </div>

        {{-- PROMO BANNER --}}
        <div class="animate-slide-up" style="margin-bottom:1.25rem;overflow-x:auto;display:flex;gap:0.75rem;padding-bottom:0.25rem;scroll-snap-type:x mandatory;">
            <div style="min-width:85%;scroll-snap-align:start;background:linear-gradient(135deg,#2563EB,#3B82F6);border-radius:18px;padding:1.25rem;color:white;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>
                <div style="position:absolute;bottom:-15px;right:20px;width:60px;height:60px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
                <p style="font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;opacity:0.85;margin-bottom:0.25rem;"><i class="bi bi-tag-fill"></i> Promo Mingguan</p>
                <h3 class="font-poppins" style="font-weight:700;font-size:1.1rem;margin-bottom:0.25rem;">Diskon 10% Setiap Hari Jumat!</h3>
                <p style="font-size:0.8rem;opacity:0.85;">Berlaku untuk semua menu tanpa minimum order</p>
            </div>
            <div style="min-width:85%;scroll-snap-align:start;background:linear-gradient(135deg,#0F172A,#1E293B);border-radius:18px;padding:1.25rem;color:white;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(37,99,235,0.15);border-radius:50%;"></div>
                <p style="font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;opacity:0.85;margin-bottom:0.25rem;"><i class="bi bi-fire"></i> Best Seller</p>
                <h3 class="font-poppins" style="font-weight:700;font-size:1.1rem;margin-bottom:0.25rem;">Seblak Komplit Lv.3</h3>
                <p style="font-size:0.8rem;opacity:0.85;">Favorit pelanggan! Wajib coba</p>
            </div>
        </div>

        {{-- QUICK INFO --}}
        <div class="animate-slide-up" style="margin-bottom:1.5rem;">
            <div style="background:white;border-radius:14px;padding:0.75rem;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.04);display:flex;align-items:center;justify-content:center;gap:0.75rem;">
                <i class="bi bi-clock" style="color:var(--primary);font-size:1.5rem;"></i>
                <div style="text-align:left;">
                    <p style="font-size:0.75rem;color:var(--text-muted);margin:0;">Estimasi Pembuatan</p>
                    <p class="font-poppins" style="font-weight:700;font-size:0.95rem;margin:0;">15-20 Menit</p>
                </div>
            </div>
        </div>

        {{-- PORSI TABS --}}
        <div class="animate-slide-up" style="display:flex;gap:0.5rem;overflow-x:auto;padding-bottom:1rem;margin-bottom:0.5rem;">
            <template x-for="(porsi, index) in porsis" :key="porsi.id">
                <div class="category-tab" :class="{'active': activePorsiIdx === index}" @click="activePorsiIdx = index" style="position:relative;padding-right:2rem;">
                    <i class="bi bi-cup-hot" style="margin-right:4px;"></i> <span x-text="porsi.nama_porsi"></span>
                    <button x-show="porsis.length > 1" @click.stop="removePorsi(index)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:inherit;opacity:0.7;font-size:0.9rem;cursor:pointer;"><i class="bi bi-x-lg"></i></button>
                </div>
            </template>
            <div class="category-tab" style="background:#F1F5F9;color:var(--text-dark);border:1px dashed #CBD5E1;" @click="addPorsi()">
                <i class="bi bi-plus-lg"></i> Tambah Mangkuk
            </div>
        </div>

        {{-- PILIH SEBLAK SECTION HEADER --}}
        <div class="animate-slide-up" style="margin-bottom:0.75rem;">
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
                <div style="width:4px;height:20px;background:var(--primary);border-radius:4px;"></div>
                <h3 class="font-poppins" style="font-weight:700;font-size:1rem;" x-text="'Kustomisasi ' + activePorsi.nama_porsi"></h3>
            </div>
            <p style="color:var(--text-muted);font-size:0.8rem;padding-left:1rem;">Pilih level pedas dan rasa sesuai selera</p>
        </div>

        {{-- LEVEL PEDAS --}}
        <div class="card animate-slide-up" style="margin-bottom:1rem;">
            <div class="section-title"><i class="bi bi-fire" style="color:var(--primary);"></i> Level Pedas</div>
            <div class="level-slider">
                <template x-for="level in [0,1,2,3,4,5]" :key="level">
                    <div class="level-option" :class="{'active': activePorsi.level_pedas == level}" @click="activePorsi.level_pedas = level" x-text="level"></div>
                </template>
            </div>
            <p style="margin-top:0.5rem;font-size:0.8rem;color:var(--text-muted);" x-text="levelLabel(activePorsi.level_pedas)"></p>
        </div>

        {{-- JENIS RASA --}}
        <div class="card animate-slide-up" style="margin-bottom:1.5rem;">
            <div class="section-title"><i class="bi bi-cup-hot" style="color:var(--primary);"></i> Jenis Rasa</div>
            <div style="display:flex;gap:0.75rem;">
                <div class="rasa-option" :class="{'active': activePorsi.jenis_rasa === 'gurih'}" @click="activePorsi.jenis_rasa = 'gurih'">Gurih</div>
                <div class="rasa-option" :class="{'active': activePorsi.jenis_rasa === 'gurih_manis'}" @click="activePorsi.jenis_rasa = 'gurih_manis'">Gurih Manis</div>
            </div>
        </div>

        {{-- PILIH MENU SECTION HEADER --}}
        <div class="animate-slide-up" style="margin-bottom:0.75rem;">
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
                <div style="width:4px;height:20px;background:#0891B2;border-radius:4px;"></div>
                <h3 class="font-poppins" style="font-weight:700;font-size:1rem;">Pilih Menu</h3>
            </div>
            <p style="color:var(--text-muted);font-size:0.8rem;padding-left:1rem;">Tambah topping, minuman & cemilan</p>
        </div>

        {{-- CATEGORY TABS --}}
        <div style="display:flex;gap:0.5rem;overflow-x:auto;padding-bottom:0.5rem;margin-bottom:1rem;">
            <div class="category-tab" :class="{'active': activeTab === 'topping'}" @click="switchTab('topping')"><i class="bi bi-egg-fried"></i> Topping</div>
            <div class="category-tab" :class="{'active': activeTab === 'minuman'}" @click="switchTab('minuman')"><i class="bi bi-cup-straw"></i> Minuman</div>
            <div class="category-tab" :class="{'active': activeTab === 'cemilan'}" @click="switchTab('cemilan')"><i class="bi bi-basket"></i> Cemilan</div>
        </div>

        {{-- SEARCH --}}
        <div class="search-input-wrapper">
            <i class="bi bi-search"></i>
            <input type="text" x-model="searchQuery" placeholder="Cari menu..." @input="filterMenu()">
        </div>

        {{-- ICON MAP --}}
        @php
        $iconMap = [
            'Bakso Urat' => 'circle-fill', 'Bakso Halus' => 'circle', 'Ceker Ayam' => 'hand-index-thumb',
            'Sosis' => 'capsule', 'Telur Puyuh' => 'egg', 'Telur Ayam' => 'egg-fried',
            'Kerupuk Seblak' => 'cookie', 'Mie' => 'bezier2', 'Kwetiau' => 'bezier',
            'Makaroni' => 'alexa', 'Sayap Ayam' => 'feather', 'Dumpling' => 'box-seam',
            'Fish Cake' => 'water', 'Tahu' => 'square-fill', 'Cuanki' => 'hexagon',
            'Es Teh Manis' => 'cup-straw', 'Es Jeruk' => 'brightness-high', 'Air Mineral' => 'droplet',
            'Pop Ice' => 'snow2', 'Es Coklat' => 'cup-hot', 'Thai Tea' => 'cup-straw',
            'Teh Hangat' => 'cup-hot-fill', 'Kopi Susu' => 'cup-hot',
            'Cireng Isi' => 'cookie', 'Batagor' => 'box-seam', 'Siomay' => 'box',
            'Kentang Goreng' => 'list-columns', 'Pisang Goreng' => 'moon', 'Dimsum Ayam' => 'box-seam-fill',
        ];
        $popularItems = ['Bakso Urat', 'Ceker Ayam', 'Sosis', 'Mie', 'Telur Ayam', 'Es Teh Manis', 'Es Jeruk'];

        // Hitung harga paket dari harga menu asli di database
        $allMenuItems = $toppings->merge($minuman)->merge($cemilan);
        $getPrice = function($nama) use ($allMenuItems) {
            $item = $allMenuItems->firstWhere('nama_menu', $nama);
            return $item ? $item->harga : 0;
        };

        $paketHemat = $getPrice('Bakso Urat') + $getPrice('Mie') + $getPrice('Telur Puyuh') + $getPrice('Es Teh Manis');
        $paketKomplit = $getPrice('Bakso Urat') + $getPrice('Ceker Ayam') + $getPrice('Sosis') + $getPrice('Mie') + $getPrice('Telur Ayam') + $getPrice('Es Jeruk');
        $paketSultan = $getPrice('Bakso Urat') + $getPrice('Ceker Ayam') + $getPrice('Sosis') + $getPrice('Mie') + $getPrice('Telur Ayam') + $getPrice('Sayap Ayam') + $getPrice('Dumpling') + $getPrice('Thai Tea');
        @endphp

        {{-- MENU ITEMS --}}
        <div class="tab-content-wrapper">
            {{-- TOPPING --}}
            <div x-show="activeTab === 'topping'" x-transition:enter="tab-content-panel" style="display:flex;flex-direction:column;gap:0.75rem;">
                @foreach($toppings as $item)
                <div class="menu-item" style="padding:0.75rem 1rem;border-radius:18px;" x-show="isItemVisible('{{ addslashes($item->nama_menu) }}')">
                    @if(in_array($item->nama_menu, $popularItems))
                        <span class="badge-popular">Popular</span>
                    @endif
                    <div style="display:flex;align-items:center;gap:0.875rem;flex:1;min-width:0;">
                        @if($item->gambar_path)
                            <img src="{{ asset('storage/' . $item->gambar_path) }}" alt="{{ $item->nama_menu }}" style="width:48px;height:48px;border-radius:12px;object-fit:cover;flex-shrink:0;">
                        @else
                            <div class="icon-box topping">
                                <i class="bi bi-{{ $iconMap[$item->nama_menu] ?? 'egg-fried' }}"></i>
                            </div>
                        @endif
                        <div style="min-width:0;">
                            <h4 style="margin:0 0 2px;font-size:0.95rem;">{{ $item->nama_menu }}</h4>
                            <span class="item-price">{{ $item->harga_format }}</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:0.4rem;flex-shrink:0;">
                        <button class="counter-btn" @click="kurangItem({{ $item->id }})">−</button>
                        <span class="qty-display" x-text="getQty({{ $item->id }})">0</span>
                        <button class="counter-btn" @click="tambahItem({ id: {{ $item->id }}, nama: '{{ $item->nama_menu }}', harga: {{ $item->harga }} })">+</button>
                    </div>
                </div>
                @endforeach
                <div class="empty-search" x-show="!hasVisibleItems('topping')" style="display:none;" :style="!hasVisibleItems('topping') ? 'display:block' : 'display:none'">
                    <i class="bi bi-search"></i>
                    <p>Menu tidak ditemukan</p>
                </div>
            </div>

            {{-- MINUMAN --}}
            <div x-show="activeTab === 'minuman'" x-transition:enter="tab-content-panel" style="display:flex;flex-direction:column;gap:0.75rem;">
                @foreach($minuman as $item)
                <div class="menu-item" style="padding:0.75rem 1rem;border-radius:18px;" x-show="isItemVisible('{{ addslashes($item->nama_menu) }}')">
                    @if(in_array($item->nama_menu, $popularItems))
                        <span class="badge-popular">Popular</span>
                    @endif
                    <div style="display:flex;align-items:center;gap:0.875rem;flex:1;min-width:0;">
                        @if($item->gambar_path)
                            <img src="{{ asset('storage/' . $item->gambar_path) }}" alt="{{ $item->nama_menu }}" style="width:48px;height:48px;border-radius:12px;object-fit:cover;flex-shrink:0;">
                        @else
                            <div class="icon-box minuman">
                                <i class="bi bi-{{ $iconMap[$item->nama_menu] ?? 'cup-straw' }}"></i>
                            </div>
                        @endif
                        <div style="min-width:0;">
                            <h4 style="margin:0 0 2px;font-size:0.95rem;">{{ $item->nama_menu }}</h4>
                            <span class="item-price">{{ $item->harga_format }}</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:0.4rem;flex-shrink:0;">
                        <button class="counter-btn" @click="kurangItem({{ $item->id }})">−</button>
                        <span class="qty-display" x-text="getQty({{ $item->id }})">0</span>
                        <button class="counter-btn" @click="tambahItem({ id: {{ $item->id }}, nama: '{{ $item->nama_menu }}', harga: {{ $item->harga }} })">+</button>
                    </div>
                </div>
                @endforeach
                <div class="empty-search" x-show="!hasVisibleItems('minuman')" style="display:none;" :style="!hasVisibleItems('minuman') ? 'display:block' : 'display:none'">
                    <i class="bi bi-search"></i>
                    <p>Menu tidak ditemukan</p>
                </div>
            </div>

            {{-- CEMILAN --}}
            <div x-show="activeTab === 'cemilan'" x-transition:enter="tab-content-panel" style="display:flex;flex-direction:column;gap:0.75rem;">
                @foreach($cemilan as $item)
                <div class="menu-item" style="padding:0.75rem 1rem;border-radius:18px;" x-show="isItemVisible('{{ addslashes($item->nama_menu) }}')">
                    @if(in_array($item->nama_menu, $popularItems))
                        <span class="badge-popular">Popular</span>
                    @endif
                    <div style="display:flex;align-items:center;gap:0.875rem;flex:1;min-width:0;">
                        @if($item->gambar_path)
                            <img src="{{ asset('storage/' . $item->gambar_path) }}" alt="{{ $item->nama_menu }}" style="width:48px;height:48px;border-radius:12px;object-fit:cover;flex-shrink:0;">
                        @else
                            <div class="icon-box cemilan">
                                <i class="bi bi-{{ $iconMap[$item->nama_menu] ?? 'basket' }}"></i>
                            </div>
                        @endif
                        <div style="min-width:0;">
                            <h4 style="margin:0 0 2px;font-size:0.95rem;">{{ $item->nama_menu }}</h4>
                            <span class="item-price">{{ $item->harga_format }}</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:0.4rem;flex-shrink:0;">
                        <button class="counter-btn" @click="kurangItem({{ $item->id }})">−</button>
                        <span class="qty-display" x-text="getQty({{ $item->id }})">0</span>
                        <button class="counter-btn" @click="tambahItem({ id: {{ $item->id }}, nama: '{{ $item->nama_menu }}', harga: {{ $item->harga }} })">+</button>
                    </div>
                </div>
                @endforeach
                <div class="empty-search" x-show="!hasVisibleItems('cemilan')" style="display:none;" :style="!hasVisibleItems('cemilan') ? 'display:block' : 'display:none'">
                    <i class="bi bi-search"></i>
                    <p>Menu tidak ditemukan</p>
                </div>
            </div>
        </div>

        {{-- CATATAN --}}
        <div class="card" style="margin-top:1.5rem;">
            <div class="section-title"><i class="bi bi-pencil-square" style="color:var(--primary);"></i> Catatan <span x-text="activePorsi.nama_porsi"></span> (Opsional)</div>
            <textarea class="form-input" x-model="activePorsi.catatan" placeholder="Contoh: Jangan pake daun bawang..." rows="2"></textarea>
        </div>

        {{-- PAKET REKOMENDASI --}}
        <div style="margin-top:2rem;">
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.75rem;">
                <div style="width:4px;height:20px;background:#8B5CF6;border-radius:4px;"></div>
                <h3 class="font-poppins" style="font-weight:700;font-size:1rem;">Paket Rekomendasi</h3>
            </div>
            <p style="color:var(--text-muted);font-size:0.8rem;padding-left:1rem;margin-bottom:0.75rem;">Tinggal klik, langsung masuk keranjang!</p>

            <div style="display:flex;gap:0.75rem;overflow-x:auto;padding-bottom:0.5rem;scroll-snap-type:x mandatory;">
                {{-- Paket 1 --}}
                <div @click="addPaket('hemat')" style="min-width:200px;scroll-snap-align:start;background:linear-gradient(135deg,#6366F1,#818CF8);border-radius:16px;padding:1rem;color:white;cursor:pointer;transition:transform 0.2s;position:relative;overflow:hidden;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <div style="position:absolute;top:-15px;right:-15px;width:60px;height:60px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>
                    <div style="font-size:0.65rem;text-transform:uppercase;letter-spacing:1px;opacity:0.8;margin-bottom:0.5rem;"><i class="bi bi-lightning-fill"></i> Paket Hemat</div>
                    <div class="font-poppins" style="font-weight:700;font-size:0.95rem;margin-bottom:0.5rem;">Seblak Simple</div>
                    <div style="font-size:0.75rem;opacity:0.85;line-height:1.5;">Bakso Urat + Mie + Telur Puyuh + Es Teh Manis</div>
                    <div class="font-poppins" style="font-weight:800;font-size:1rem;margin-top:0.75rem;">Rp {{ number_format($paketHemat, 0, ',', '.') }}</div>
                </div>

                {{-- Paket 2 --}}
                <div @click="addPaket('komplit')" style="min-width:200px;scroll-snap-align:start;background:linear-gradient(135deg,#2563EB,#3B82F6);border-radius:16px;padding:1rem;color:white;cursor:pointer;transition:transform 0.2s;position:relative;overflow:hidden;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <div style="position:absolute;top:-15px;right:-15px;width:60px;height:60px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>
                    <div style="font-size:0.65rem;text-transform:uppercase;letter-spacing:1px;opacity:0.8;margin-bottom:0.5rem;"><i class="bi bi-star-fill"></i> Best Seller</div>
                    <div class="font-poppins" style="font-weight:700;font-size:0.95rem;margin-bottom:0.5rem;">Seblak Komplit</div>
                    <div style="font-size:0.75rem;opacity:0.85;line-height:1.5;">Bakso + Ceker + Sosis + Mie + Telur + Es Jeruk</div>
                    <div class="font-poppins" style="font-weight:800;font-size:1rem;margin-top:0.75rem;">Rp {{ number_format($paketKomplit, 0, ',', '.') }}</div>
                </div>

                {{-- Paket 3 --}}
                <div @click="addPaket('sultan')" style="min-width:200px;scroll-snap-align:start;background:linear-gradient(135deg,#0F172A,#1E293B);border-radius:16px;padding:1rem;color:white;cursor:pointer;transition:transform 0.2s;position:relative;overflow:hidden;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <div style="position:absolute;top:-15px;right:-15px;width:60px;height:60px;background:rgba(37,99,235,0.2);border-radius:50%;"></div>
                    <div style="font-size:0.65rem;text-transform:uppercase;letter-spacing:1px;opacity:0.8;margin-bottom:0.5rem;"><i class="bi bi-gem"></i> Premium</div>
                    <div class="font-poppins" style="font-weight:700;font-size:0.95rem;margin-bottom:0.5rem;">Seblak Sultan</div>
                    <div style="font-size:0.75rem;opacity:0.85;line-height:1.5;">All Topping + Sayap Ayam + Dumpling + Thai Tea</div>
                    <div class="font-poppins" style="font-weight:800;font-size:1rem;margin-top:0.75rem;">Rp {{ number_format($paketSultan, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- INFO WARUNG --}}
        <div style="margin-top:2rem;background:white;border-radius:18px;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem;">
                <div style="width:4px;height:20px;background:#22C55E;border-radius:4px;"></div>
                <h3 class="font-poppins" style="font-weight:700;font-size:1rem;">Info Warung</h3>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                <div style="display:flex;align-items:flex-start;gap:0.5rem;">
                    <i class="bi bi-clock" style="color:var(--primary);margin-top:2px;"></i>
                    <div>
                        <p style="font-size:0.75rem;color:var(--text-muted);">Jam Buka</p>
                        <p style="font-size:0.85rem;font-weight:600;">10:00 - 21:00</p>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:0.5rem;">
                    <i class="bi bi-geo-alt" style="color:var(--primary);margin-top:2px;"></i>
                    <div>
                        <p style="font-size:0.75rem;color:var(--text-muted);">Lokasi</p>
                        <p style="font-size:0.85rem;font-weight:600;">Sukarapih, Sukarame</p>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:0.5rem;">
                    <i class="bi bi-telephone" style="color:var(--primary);margin-top:2px;"></i>
                    <div>
                        <p style="font-size:0.75rem;color:var(--text-muted);">WhatsApp</p>
                        <p style="font-size:0.85rem;font-weight:600;">0812-xxxx-xxxx</p>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:0.5rem;">
                    <i class="bi bi-instagram" style="color:var(--primary);margin-top:2px;"></i>
                    <div>
                        <p style="font-size:0.75rem;color:var(--text-muted);">Instagram</p>
                        <p style="font-size:0.85rem;font-weight:600;">@seblaksaiton</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div style="text-align:center;padding:1.5rem 0 0.5rem;font-size:0.75rem;color:var(--text-muted);">
            <p>Powered by Seblak Saiton © {{ date('Y') }} <i class="bi bi-fire" style="color:#EF4444;"></i></p>
        </div>
    </div>

    {{-- CART MODAL --}}
    <div x-show="showCart" x-transition class="modal-overlay" @click.self="showCart = false">
        <div class="modal-content animate-slide-up">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
                <h3 class="font-poppins" style="font-weight:700;"><i class="bi bi-cart3" style="color:var(--primary);"></i> Keranjang</h3>
                <button @click="showCart = false" style="background:none;border:none;font-size:1.5rem;cursor:pointer;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            {{-- ITEMS PER PORSI --}}
            <template x-if="totalItem > 0">
                <div>
                    <template x-for="porsi in porsis" :key="porsi.id">
                        <div x-show="Object.keys(porsi.cart).length > 0 || porsi.catatan" style="margin-bottom:1rem;background:#F8FAFF;padding:0.75rem;border-radius:12px;border:1px solid #E2E8F0;">
                            <h4 style="margin:0 0 0.5rem;color:var(--primary);font-family:'Poppins',sans-serif;font-size:0.95rem;display:flex;justify-content:space-between;">
                                <span x-text="porsi.nama_porsi"></span>
                                <span style="font-size:0.75rem;font-weight:400;color:var(--text-muted);" x-text="levelLabel(porsi.level_pedas) + ' • ' + (porsi.jenis_rasa === 'gurih' ? 'Gurih' : 'Gurih Manis')"></span>
                            </h4>
                            <template x-if="porsi.catatan">
                                <p style="font-size:0.75rem;color:var(--text-muted);font-style:italic;margin-bottom:0.5rem;">Catatan: <span x-text="porsi.catatan"></span></p>
                            </template>
                            <template x-for="(item, id) in porsi.cart" :key="id">
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.5rem 0;border-bottom:1px solid rgba(226,232,240,0.5);">
                                    <div>
                                        <p style="font-weight:600;font-size:0.85rem;" x-text="item.nama"></p>
                                        <p style="color:var(--text-muted);font-size:0.75rem;" x-text="formatRupiah(item.harga) + ' x ' + item.jumlah"></p>
                                    </div>
                                    <p style="font-weight:700;color:var(--text-dark);font-size:0.85rem;" x-text="formatRupiah(item.harga * item.jumlah)"></p>
                                </div>
                            </template>
                            <div style="display:flex;justify-content:space-between;align-items:center;padding-top:0.75rem;margin-top:0.25rem;border-top:1px dashed #CBD5E1;">
                                <span style="font-size:0.8rem;color:var(--text-muted);">Subtotal Mangkuk</span>
                                <span style="font-weight:700;font-size:0.9rem;color:var(--primary);" x-text="formatRupiah(Object.values(porsi.cart).reduce((sum, item) => sum + (item.harga * item.jumlah), 0))"></span>
                            </div>
                        </div>
                    </template>

                    <div style="display:flex;justify-content:space-between;padding:1rem 0;font-family:'Poppins',sans-serif;">
                        <span style="font-weight:700;font-size:1.1rem;">Total</span>
                        <span style="font-weight:800;font-size:1.25rem;color:var(--primary);" x-text="formatRupiah(totalHarga)"></span>
                    </div>

                    <button class="btn-primary" style="width:100%;" @click="lanjutCheckout()">
                        Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </template>
            <template x-if="totalItem === 0">
                <div style="text-align:center;padding:2rem 0;">
                    <i class="bi bi-cart3" style="font-size:2.5rem;color:#CBD5E1;"></i>
                    <p style="color:var(--text-muted);margin-top:0.5rem;">Keranjang masih kosong</p>
                </div>
            </template>
        </div>
    </div>

    {{-- CHECKOUT MODAL --}}
    <div x-show="showCheckout" x-transition class="modal-overlay" @click.self="showCheckout = false">
        <div class="modal-content animate-slide-up">
            {{-- PROGRESS in modal --}}
            <div class="progress-steps" style="background:transparent;border:none;padding:0 0 1rem;margin-bottom:1rem;border-bottom:1px solid #E2E8F0;">
                <div class="progress-step done">
                    <span class="step-num"><i class="bi bi-check" style="font-size:0.7rem;"></i></span> Identifikasi
                </div>
                <div class="progress-connector done"></div>
                <div class="progress-step done">
                    <span class="step-num"><i class="bi bi-check" style="font-size:0.7rem;"></i></span> Pilih Menu
                </div>
                <div class="progress-connector done"></div>
                <div class="progress-step active">
                    <span class="step-num">3</span> Checkout
                </div>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
                <h3 class="font-poppins" style="font-weight:700;"><i class="bi bi-credit-card" style="color:var(--primary);"></i> Pembayaran</h3>
                <button @click="showCheckout = false" style="background:none;border:none;font-size:1.5rem;cursor:pointer;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <p style="font-family:'Poppins',sans-serif;font-weight:700;font-size:1.25rem;text-align:center;margin-bottom:1rem;color:var(--primary);" x-text="'Total: ' + formatRupiah(totalHarga)"></p>

            {{-- PERINGATAN PEMBAYARAN --}}
            <div style="background:#FEF3C7;border:1px solid #FDE68A;border-radius:14px;padding:1rem;margin-bottom:1.5rem;text-align:center;">
                <i class="bi bi-exclamation-triangle-fill" style="color:#F59E0B;font-size:1.5rem;"></i>
                <p style="font-weight:700;font-size:0.9rem;color:#92400E;margin-top:0.5rem;">Harap Bayar Terlebih Dahulu!</p>
                <p style="font-size:0.8rem;color:#92400E;opacity:0.85;margin-top:0.25rem;">Pesanan baru akan diproses oleh dapur <strong>setelah pembayaran dikonfirmasi</strong> oleh kasir.</p>
            </div>

            {{-- PILIH METODE --}}
            <div class="section-title">Pilih Metode Pembayaran</div>
            <div style="display:flex;gap:0.75rem;margin-bottom:1.5rem;">
                <div class="rasa-option" :class="{'active': metodeBayar === 'cash'}" @click="metodeBayar = 'cash'" style="flex:1;"><i class="bi bi-cash-stack"></i> Cash</div>
                <div class="rasa-option" :class="{'active': metodeBayar === 'qris'}" @click="metodeBayar = 'qris'" style="flex:1;"><i class="bi bi-qr-code"></i> QRIS</div>
            </div>

            {{-- QRIS --}}
            <div x-show="metodeBayar === 'qris'" x-transition style="margin-bottom:1.5rem;">
                <div style="background:#F8FAFF;padding:1rem;border-radius:16px;text-align:center;margin-bottom:1rem;">
                    <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:0.75rem;">Scan QRIS atau transfer ke rekening berikut:</p>
                    <div style="background:white;padding:1.5rem;border-radius:12px;border:2px dashed #E2E8F0;">
                        <i class="bi bi-qr-code" style="font-size:3rem;color:var(--primary);"></i>
                        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:0.5rem;">QRIS Seblak Saiton</p>
                        <p style="font-size:0.75rem;color:var(--text-muted);">(Gambar QRIS akan ditampilkan di sini)</p>
                    </div>
                </div>
                <label class="form-label"><i class="bi bi-upload"></i> Upload Bukti Transfer *</label>
                <input type="file" id="bukti_bayar_input" accept="image/*" @change="handleBuktiBayar($event)" class="form-input" style="padding:0.5rem;">
                <p x-show="buktiBayarName" style="font-size:0.8rem;color:#22C55E;margin-top:0.5rem;"><i class="bi bi-check-circle-fill"></i> <span x-text="buktiBayarName"></span></p>
            </div>

            {{-- CASH --}}
            <div x-show="metodeBayar === 'cash'" x-transition style="margin-bottom:1.5rem;">
                <div style="background:#D1FAE5;padding:1rem;border-radius:16px;text-align:center;">
                    <i class="bi bi-cash-stack" style="font-size:2rem;color:#22C55E;"></i>
                    <p style="font-weight:600;margin-top:0.5rem;color:#166534;">Pembayaran Tunai</p>
                    <p style="font-size:0.85rem;color:var(--text-muted);margin-top:0.25rem;">Klik <strong>Checkout</strong>, kemudian tunjukkan halaman checkout saat melakukan pembayaran ke kasir.</p>
                </div>
            </div>

            <form id="checkoutForm" method="POST" action="{{ route('order.checkout') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="nama_pemesan" value="{{ $nama_pemesan }}">
                <input type="hidden" name="nomor_meja" value="{{ $nomor_meja }}">
                <input type="hidden" name="metode_bayar" :value="metodeBayar">

                <template x-for="(porsi, pIdx) in porsis" :key="'pform-'+porsi.id">
                    <div>
                        <!-- Only send porsi if it has items -->
                        <template x-if="Object.keys(porsi.cart).length > 0">
                            <div>
                                <input type="hidden" :name="'porsis['+pIdx+'][nama_porsi]'" :value="porsi.nama_porsi">
                                <input type="hidden" :name="'porsis['+pIdx+'][level_pedas]'" :value="porsi.level_pedas">
                                <input type="hidden" :name="'porsis['+pIdx+'][jenis_rasa]'" :value="porsi.jenis_rasa">
                                <input type="hidden" :name="'porsis['+pIdx+'][catatan]'" :value="porsi.catatan">
                                
                                <template x-for="(item, mId) in porsi.cart" :key="'pitem-'+porsi.id+'-'+mId">
                                    <div>
                                        <input type="hidden" :name="'porsis['+pIdx+'][items]['+mId+'][menu_id]'" :value="mId">
                                        <input type="hidden" :name="'porsis['+pIdx+'][items]['+mId+'][jumlah]'" :value="item.jumlah">
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>

                <button type="submit" class="btn-primary" style="width:100%;" :disabled="submitting || (metodeBayar === 'qris' && !buktiBayarFile)" @click.prevent="submitOrder()">
                    <span x-show="!submitting">Checkout Sekarang <i class="bi bi-rocket-takeoff"></i></span>
                    <span x-show="submitting"><i class="bi bi-arrow-repeat" style="animation:spin 1s linear infinite;display:inline-block;"></i> Memproses...</span>
                </button>
            </form>
        </div>
    </div>

    {{-- FLOATING CART BUTTON --}}
    <div class="floating-cart" :class="cartAnimation" x-show="totalItem > 0" x-transition @click="showCart = true">
        <span class="cart-count" x-text="totalItem"></span>
        <span style="font-weight:600;"><i class="bi bi-cart3"></i> Lihat Keranjang</span>
        <span style="margin-left:auto;font-weight:700;" x-text="formatRupiah(totalHarga)"></span>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function orderMenu() {
    return {
        porsis: [
            { id: Date.now(), nama_porsi: 'Mangkuk 1', level_pedas: 0, jenis_rasa: 'gurih', catatan: '', cart: {} }
        ],
        activePorsiIdx: 0,
        activeTab: 'topping',
        showCart: false,
        showCheckout: false,
        metodeBayar: 'cash',
        buktiBayarFile: null,
        buktiBayarName: '',
        submitting: false,
        searchQuery: '',
        cartAnimation: '',
        prevTotalItem: 0,
        allMenus: @json($toppings->merge($minuman)->merge($cemilan)),
        menuNames: {
            topping: @json($toppings->pluck('nama_menu')->toArray()),
            minuman: @json($minuman->pluck('nama_menu')->toArray()),
            cemilan: @json($cemilan->pluck('nama_menu')->toArray()),
        },
        cartStorageKey: 'seblak_cart_meja_{{ $nomor_meja }}_{{ Str::slug($nama_pemesan) }}',

        init() {
            const savedData = localStorage.getItem(this.cartStorageKey);
            if (savedData) {
                try {
                    const parsed = JSON.parse(savedData);
                    if (parsed && Array.isArray(parsed)) {
                        this.porsis = parsed;
                    }
                } catch(e) {
                    console.error('Error parsing cart from localStorage', e);
                }
            }

            this.$watch('porsis', value => {
                localStorage.setItem(this.cartStorageKey, JSON.stringify(value));
            });
        },

        get activePorsi() {
            return this.porsis[this.activePorsiIdx];
        },

        addPorsi() {
            const num = this.porsis.length + 1;
            this.porsis.push({
                id: Date.now(),
                nama_porsi: 'Mangkuk ' + num,
                level_pedas: 0,
                jenis_rasa: 'gurih',
                catatan: '',
                cart: {}
            });
            this.activePorsiIdx = this.porsis.length - 1;
            this.showToast('Mangkuk ' + num + ' ditambahkan');
        },

        removePorsi(index) {
            if (this.porsis.length === 1) {
                alert('Minimal harus ada 1 mangkuk!');
                return;
            }
            if (confirm('Yakin ingin menghapus ' + this.porsis[index].nama_porsi + '?')) {
                this.porsis.splice(index, 1);
                if (this.activePorsiIdx >= this.porsis.length) {
                    this.activePorsiIdx = this.porsis.length - 1;
                }
            }
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

        addPaket(tipe) {
            let itemsToAdd = [];
            if (tipe === 'hemat') {
                itemsToAdd = ['Bakso Urat', 'Mie', 'Telur Puyuh', 'Es Teh Manis'];
            } else if (tipe === 'komplit') {
                itemsToAdd = ['Bakso Urat', 'Ceker Ayam', 'Sosis', 'Mie', 'Telur Ayam', 'Es Jeruk'];
            } else if (tipe === 'sultan') {
                itemsToAdd = ['Bakso Urat', 'Ceker Ayam', 'Sosis', 'Mie', 'Telur Ayam', 'Sayap Ayam', 'Dumpling', 'Thai Tea'];
            }

            let addedCount = 0;
            itemsToAdd.forEach(nama => {
                const menu = this.allMenus.find(m => m.nama_menu === nama);
                if (menu) {
                    this.tambahItem({ id: menu.id, nama: menu.nama_menu, harga: menu.harga }, true);
                    addedCount++;
                }
            });

            if (addedCount > 0) {
                this.showToast('Paket ' + tipe.charAt(0).toUpperCase() + tipe.slice(1) + ' ditambahkan!');
                this.showCart = true;
            } else {
                alert("Maaf, item di dalam paket sedang tidak tersedia.");
            }
        },

        levelLabel(level) {
            const labels = ['Tidak Pedas', 'Sedikit Pedas', 'Pedas', 'Lumayan Pedas', 'Sangat Pedas', 'Extra Pedas'];
            return labels[level] || '';
        },

        get totalHarga() {
            let total = 0;
            for(let porsi of this.porsis) {
                total += Object.values(porsi.cart).reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
            }
            return total;
        },

        get totalItem() {
            let total = 0;
            for(let porsi of this.porsis) {
                total += Object.values(porsi.cart).reduce((sum, item) => sum + item.jumlah, 0);
            }
            return total;
        },

        tambahItem(menu, silent = false) {
            const wasPrevEmpty = this.totalItem === 0;
            if (this.activePorsi.cart[menu.id]) {
                this.activePorsi.cart[menu.id].jumlah++;
            } else {
                this.activePorsi.cart[menu.id] = { nama: menu.nama, harga: menu.harga, jumlah: 1 };
            }

            // Cart bounce animation
            if (wasPrevEmpty) {
                this.cartAnimation = 'cart-enter';
                setTimeout(() => { this.cartAnimation = ''; }, 600);
            } else {
                this.cartAnimation = 'cart-wiggle';
                setTimeout(() => { this.cartAnimation = ''; }, 500);
            }

            // Toast notification
            if (!silent) {
                this.showToast(menu.nama + ' ditambahkan');
            }
        },

        kurangItem(menuId) {
            if (this.activePorsi.cart[menuId]) {
                this.activePorsi.cart[menuId].jumlah--;
                if (this.activePorsi.cart[menuId].jumlah <= 0) {
                    delete this.activePorsi.cart[menuId];
                }
            }
        },

        getQty(menuId) {
            return this.activePorsi.cart[menuId] ? this.activePorsi.cart[menuId].jumlah : 0;
        },

        formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        },

        lanjutCheckout() {
            // Konfirmasi sebelum checkout
            let htmlList = '';
            for(let porsi of this.porsis) {
                if(Object.keys(porsi.cart).length > 0) {
                    let rasaLabel = porsi.jenis_rasa === 'gurih' ? 'Gurih' : 'Gurih Manis';
                    let porsiSubtotal = Object.values(porsi.cart).reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
                    htmlList += `<div style="background:#EFF6FF;padding:0.5rem;border-radius:8px;margin-bottom:0.5rem;text-align:left;">
                        <strong>${porsi.nama_porsi}</strong> (${this.levelLabel(porsi.level_pedas)}, ${rasaLabel})
                        <div style="font-size:0.8rem;margin-top:0.25rem;">`;
                    Object.values(porsi.cart).forEach(i => {
                        htmlList += `<div>- ${i.nama} x${i.jumlah}</div>`;
                    });
                    htmlList += `<div style="border-top:1px dashed #93C5FD;margin-top:4px;padding-top:4px;font-weight:600;display:flex;justify-content:space-between;"><span>Subtotal</span><span>${this.formatRupiah(porsiSubtotal)}</span></div></div></div>`;
                }
            }
            
            Swal.fire({
                title: '<span style="font-family:Poppins,sans-serif;font-size:1.1rem;">Konfirmasi Pesanan</span>',
                html: `
                    <div style="text-align:left;font-size:0.85rem;margin-top:0.5rem;max-height:300px;overflow-y:auto;">
                        ${htmlList}
                        <div style="border-top:1px solid #E2E8F0;padding-top:0.75rem;margin-top:0.75rem;font-family:Poppins,sans-serif;font-weight:700;font-size:1.1rem;color:#2563EB;">
                            Total: ${this.formatRupiah(this.totalHarga)}
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Yakin, Lanjut Bayar!',
                cancelButtonText: 'Cek Lagi',
                confirmButtonColor: '#2563EB',
                cancelButtonColor: '#64748B',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.showCart = false;
                    this.showCheckout = true;
                }
            });
        },

        handleBuktiBayar(event) {
            const file = event.target.files[0];
            if (file) {
                this.buktiBayarFile = file;
                this.buktiBayarName = file.name;
            }
        },

        submitOrder() {
            if (this.totalItem === 0) { alert('Keranjang masih kosong!'); return; }
            if (this.metodeBayar === 'qris' && !this.buktiBayarFile) { alert('Upload bukti pembayaran dulu ya!'); return; }

            this.submitting = true;
            const form = document.getElementById('checkoutForm');
            const formData = new FormData(form);

            if (this.buktiBayarFile) {
                formData.append('bukti_bayar', this.buktiBayarFile);
            }

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).then(async response => {
                if (!response.ok) {
                    if (response.status === 422) {
                        const data = await response.json();
                        let errorMsg = 'Data tidak valid:\n';
                        for (let field in data.errors) {
                            errorMsg += `- ${data.errors[field][0]}\n`;
                        }
                        alert(errorMsg);
                    } else {
                        alert('Terjadi kesalahan server (Error ' + response.status + '). Coba lagi.');
                    }
                    this.submitting = false;
                    return;
                }
                
                // If success, it should return a redirect URL in JSON or redirect itself.
                // Wait, if it succeeds, OrderController returns redirect()->route(...)
                // But with Accept: application/json, Laravel might still return 302 if it's a redirect, or Fetch follows it.
                // Let's just let fetch follow it, or we can check response.redirected
                if (response.redirected) {
                    localStorage.removeItem(this.cartStorageKey);
                    window.location.href = response.url;
                } else {
                    const html = await response.text();
                    document.documentElement.innerHTML = html;
                }
            }).catch(err => {
                this.submitting = false;
                alert('Terjadi kesalahan jaringan. Coba lagi ya!');
            });
        }
    }
}
</script>
<style>@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }</style>
@endpush
@endsection
