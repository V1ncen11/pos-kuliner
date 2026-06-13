<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Resto Cafe — Cafe & Resto self-order terbaik! Pesan langsung dari meja kamu.">
    <title>Resto Cafe — Pesan & Santai</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
    <style>
        :root {
            --primary: #16A34A;
            --primary-hover: #15803D;
            --bg-color: #F0FDF4;
            --text-dark: #1A2E22;
            --text-muted: #4B6455;
        }
        body {
            margin: 0;
            background: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }
        h1, h2, h3, h4, h5, h6, .font-outfit {
            font-family: 'Outfit', sans-serif;
        }
        
        /* HERO SECTION */
        .hero-section {
            background: radial-gradient(circle at top right, #DCF0E3 0%, #F0FDF4 60%);
            padding: 4rem 2rem;
            position: relative;
            overflow: hidden;
        }
        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4rem;
            position: relative;
            z-index: 1;
        }
        .hero-text {
            flex: 1;
            max-width: 600px;
        }
        .hero-badges {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .badge-khas {
            background: #DCF0E3;
            color: #16A34A;
            padding: 0.75rem 1.75rem;
            border-radius: 99px;
            font-size: 1.75rem;
            font-weight: 900;
            letter-spacing: 0px;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 8px 15px rgba(22, 163, 74, 0.15);
        }
        .badge-status {
            background: #ECFCCB;
            color: #4D7C0F;
            padding: 0.4rem 1rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .badge-status i {
            font-size: 0.6rem;
        }
        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.25rem;
            color: var(--text-dark);
            letter-spacing: -1px;
        }
        .hero-title span {
            color: var(--primary);
        }
        .hero-subtitle {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 2rem;
            max-width: 90%;
        }
        .hero-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }
        .btn-primary-hero {
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 99px;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(22, 163, 74, 0.2);
            font-size: 1rem;
        }
        .btn-primary-hero:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(22, 163, 74, 0.3);
            color: white;
        }
        .btn-secondary-hero {
            background: white;
            color: var(--text-dark);
            padding: 1rem 2rem;
            border-radius: 99px;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 2px solid #E5E7EB;
            transition: all 0.3s;
            font-size: 1rem;
        }
        .btn-secondary-hero:hover {
            border-color: var(--text-dark);
            background: #F9FAFB;
        }
        
        .hero-stats {
            display: flex;
            gap: 2.5rem;
        }
        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .stat-item h3 {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
            color: var(--primary);
        }
        .stat-item p {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            position: relative;
        }
        .circle-wrapper {
            position: relative;
            width: 500px;
            height: 500px;
        }
        .circle-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 15px solid white;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }
        .floating-badge {
            position: absolute;
            background: white;
            border-radius: 20px;
            padding: 1rem;
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: float 4s ease-in-out infinite;
        }
        .badge-price {
            top: 10%;
            right: 0;
            background: #FACC15;
            color: #854D0E;
            border-radius: 50%;
            width: 90px;
            height: 90px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-family: 'Outfit', sans-serif;
            line-height: 1.1;
            padding: 0;
            animation-delay: 1s;
        }
        .badge-price strong {
            font-size: 1.5rem;
            font-weight: 900;
        }
        .badge-info {
            bottom: 15%;
            left: -10%;
        }
        .badge-info i {
            font-size: 1.5rem;
            color: var(--primary);
            background: #DCF0E3;
            padding: 0.75rem;
            border-radius: 12px;
        }
        .badge-info-text {
            display: flex;
            flex-direction: column;
        }
        .badge-info-text strong {
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
        }
        .badge-info-text span {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* MENU SECTION */
        .menu-section {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3.5rem;
        }
        .menu-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
            border: 1px solid rgba(0,0,0,0.02);
        }
        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        .menu-img-wrapper {
            position: relative;
            padding-top: 100%;
            background: #f8f9fa;
        }
        .menu-img-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .menu-content {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .menu-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }
        .menu-price {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.25rem;
        }
        .btn-pesan {
            margin-top: auto;
            background: #F3F4F6;
            color: var(--text-dark);
            border: none;
            padding: 0.75rem;
            border-radius: 12px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
        }
        .btn-pesan:hover {
            background: var(--primary);
            color: white;
        }
        .category-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .category-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
        }
        .category-line {
            flex: 1;
            height: 2px;
            background: #F3F4F6;
        }

        /* TABS */
        .category-tabs {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }
        .btn-tab {
            background: white;
            border: 2px solid #F3F4F6;
            padding: 0.6rem 1.5rem;
            border-radius: 99px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }
        .btn-tab:hover {
            border-color: #E5E7EB;
            color: var(--text-dark);
        }
        .btn-tab.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 15px rgba(22, 163, 74, 0.25);
        }

        .btn-floating {
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 99px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(22, 163, 74, 0.4);
            transition: all 0.3s;
            width: 100%;
            justify-content: center;
        }
        .btn-floating:hover {
            background: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(22, 163, 74, 0.5);
            color: white;
        }
        .floating-cta {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            width: 90%;
            max-width: 400px;
            display: flex;
            justify-content: center;
            animation: slideUpFloat 0.5s ease-out forwards;
        }
        @keyframes slideUpFloat {
            from { bottom: -5rem; opacity: 0; }
            to { bottom: 2rem; opacity: 1; }
        }

        /* RESPONSIVE */
        @media (max-width: 991px) {
            .hero-container {
                flex-direction: column;
                text-align: center;
                gap: 2rem;
            }
            .hero-text {
                max-width: 100%;
            }
            .hero-badges, .hero-actions, .hero-stats {
                justify-content: center;
            }
            .hero-subtitle {
                margin: 0 auto 2rem auto;
                font-size: 0.9rem;
            }
            .hero-title {
                font-size: 2.5rem;
            }
            .circle-wrapper {
                width: 350px;
                height: 350px;
            }
            .badge-price {
                width: 75px;
                height: 75px;
            }
            .badge-price strong {
                font-size: 1.25rem;
            }
            .badge-info {
                left: 0;
                bottom: 5%;
            }
        }
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .circle-wrapper {
                width: 280px;
                height: 280px;
            }
            .hero-stats {
                gap: 1.5rem;
            }
            .stat-item h3 {
                font-size: 1.25rem;
            }
        }
        /* KEUNGGULAN SECTION */
        .features-section {
            padding: 4rem 2rem;
            background: white;
        }
        .features-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .feature-card {
            background: var(--bg-color);
            padding: 2rem;
            border-radius: 24px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid #DCF0E3;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(22, 163, 74, 0.1);
        }
        .feature-icon {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.15);
        }
        .feature-card h3 {
            font-size: 1.25rem;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }
        .feature-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
            margin: 0;
        }

        /* GALLERY SECTION */
        .gallery-section {
            padding: 5rem 2rem;
            background: white;
        }
        .gallery-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .gallery-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            grid-auto-rows: 250px;
        }
        .gallery-item {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        .gallery-item-large {
            grid-column: span 2;
            grid-row: span 2;
        }
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
            .gallery-item-large {
                grid-column: span 1;
                grid-row: span 1;
            }
        }
    </style>
</head>
<body>
    
    {{-- HERO SECTION --}}
    <section class="hero-section">
        <div class="hero-container">
            {{-- Bagian Kiri (Teks) --}}
            <div class="hero-text">
                <div class="hero-badges" data-aos="fade-up">
                    <span class="badge-khas"><i class="bi bi-flower2"></i> Resto Cafe</span>
                </div>
                
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                    Nongkrong santai,<br><span>biar makanan yang nyamperin.</span>
                </h1>
                
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                    Nggak perlu repot antre ke kasir atau manggil pelayan. Tinggal scan QR di meja, pilih menu favorit kamu, dan pesanan bakal langsung diproses di dapur!
                </p>
                
                <div class="hero-actions" data-aos="fade-up" data-aos-delay="300">
                    <a href="#menu-section" class="btn-primary-hero">
                        <i class="bi bi-book"></i> Intip Menu Kita
                    </a>
                </div>
            </div>

            {{-- Bagian Kanan (Gambar) --}}
            <div class="hero-image" data-aos="zoom-in" data-aos-delay="200">
                <div class="circle-wrapper" data-tilt data-tilt-max="10" data-tilt-speed="400" data-tilt-glare="true" data-tilt-max-glare="0.5">
                    <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1000&auto=format&fit=crop" alt="Resto Cafe" class="circle-img">
                    
                    <div class="floating-badge badge-price">
                        <span style="font-size:0.75rem;">Mulai</span>
                        <strong>10K</strong>
                    </div>
                    
                    <div class="floating-badge badge-info">
                        <i class="bi bi-phone"></i>
                        <div class="badge-info-text">
                            <strong>Tinggal Scan</strong>
                            <span>Langsung Pesan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- KEUNGGULAN SECTION --}}
    <section class="features-section">
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100" data-tilt data-tilt-max="15" data-tilt-scale="1.05">
                <div class="feature-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                <h3 class="font-outfit">Nggak Pake Lama</h3>
                <p>Duduk tenang di meja, pesanan kamu langsung masuk ke dapur kita. Gak perlu lagi deh manggil-manggil pelayan buat minta menu.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200" data-tilt data-tilt-max="15" data-tilt-scale="1.05">
                <div class="feature-icon"><i class="bi bi-fire"></i></div>
                <h3 class="font-outfit">Dimasak Dadakan</h3>
                <p>Bukan makanan kemarin sore! Semua menu yang kamu pesan baru kita masak fresh saat itu juga biar rasanya tetap juara.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300" data-tilt data-tilt-max="15" data-tilt-scale="1.05">
                <div class="feature-icon"><i class="bi bi-wallet2"></i></div>
                <h3 class="font-outfit">Bayar Super Praktis</h3>
                <p>Tinggal klik dari HP, kamu bisa langsung bayar pake QRIS atau e-Wallet. Kalau lagi pegang uang pas, bayar tunai ke kasir juga aman.</p>
            </div>
        </div>
    </section>

    {{-- MENU SECTION --}}
    <section id="menu-section" class="menu-section">
        @if(isset($menus) && count($menus) > 0)
            
            {{-- TABS HEADER --}}
            <div style="text-align:center; margin-bottom:1rem;">
                <h2 class="font-outfit" style="font-size:2rem; font-weight:800; color:var(--text-dark); margin-bottom:0.5rem;">Hari ini mau makan apa?</h2>
                <p style="color:var(--text-muted); margin-bottom:2rem;">Ada makanan berat, cemilan, sampai minuman seger buat nemenin kamu</p>
                
                @php
                $iconMap = [
                    'Bakso Urat' => 'circle-fill', 'Bakso Halus' => 'circle', 'Ceker Ayam' => 'hand-index-thumb',
                    'Sosis' => 'capsule', 'Telur Puyuh' => 'egg', 'Telur Ayam' => 'egg-fried',
                    'Kerupuk Seblak' => 'cookie', 'Mie' => 'bezier2', 'Kwetiau' => 'bezier',
                    'Makaroni' => 'alexa', 'Sayap Ayam' => 'feather', 'Dumpling' => 'box-seam',
                    'Fish Cake' => 'water', 'Tahu' => 'square-fill', 'Cuanki' => 'hexagon'
                ];
                @endphp

                <div class="category-tabs">
                    @php $firstCat = true; @endphp
                    @foreach($menus as $kategori => $items)
                        <button class="btn-tab {{ $firstCat ? 'active' : '' }}" onclick="showCategory('{{ $kategori }}', this)">
                            @if($kategori == 'makanan')
                                <i class="bi bi-egg-fried"></i> Makanan
                            @elseif($kategori == 'minuman')
                                <i class="bi bi-cup-straw"></i> Minuman
                            @elseif($kategori == 'snack')
                                <i class="bi bi-cookie"></i> Snack
                            @else
                                {{ ucfirst($kategori) }}
                            @endif
                        </button>
                        @php $firstCat = false; @endphp
                    @endforeach
                </div>
            </div>

            @php $firstGroup = true; @endphp
            @foreach($menus as $kategori => $items)
                <div id="cat-{{ $kategori }}" class="menu-category-group" style="display: {{ $firstGroup ? 'block' : 'none' }};">
                    <div class="menu-grid">
                        @foreach($items as $menu)
                            <div class="menu-card" data-aos="zoom-in" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.2">
                                @if($menu->gambar_path)
                                    <div class="menu-img-wrapper">
                                        <img src="{{ Str::startsWith($menu->gambar_path, 'http') ? $menu->gambar_path : asset('storage/'.$menu->gambar_path) }}" alt="{{ $menu->nama_menu }}">
                                    </div>
                                @else
                                    <div class="menu-img-wrapper" style="background:#F8FAFC; border-bottom:1px solid #E2E8F0;">
                                        <div style="position:absolute; top:0; left:0; width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                                            <i class="bi bi-{{ $iconMap[$menu->nama_menu] ?? 'egg-fried' }}" style="font-size:4rem; color:var(--primary); opacity:0.8;"></i>
                                        </div>
                                    </div>
                                @endif
                                <div class="menu-content">
                                    <div class="menu-title">{{ $menu->nama_menu }}</div>
                                    
                                    @php
                                        $desc = "Pilihan favorit buat pelengkap.";
                                        if($kategori == 'makanan') $desc = "Pilihan makanan utama yang mengenyangkan.";
                                        if($kategori == 'minuman') $desc = "Penyegar tenggorokan setelah makan.";
                                        if($kategori == 'snack') $desc = "Snack ringan untuk teman santai.";
                                    @endphp
                                    <p style="font-size:0.8rem; color:var(--text-muted); margin:0 0 1rem 0; line-height:1.3;">{{ $desc }}</p>
                                    
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:auto;">
                                        <div class="menu-price" style="margin:0;">{{ $menu->harga_format }}</div>
                                        <div style="background:#FFF3ED; color:var(--primary); padding:0.25rem 0.5rem; border-radius:8px; font-size:0.75rem; font-weight:700; display:flex; align-items:center; gap:0.25rem;">
                                            <i class="bi bi-star-fill" style="color:#F59E0B; font-size:0.7rem;"></i> 4.{{ rand(5,9) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @php $firstGroup = false; @endphp
            @endforeach
        @else
            <div style="text-align:center; padding:3rem 1rem; color:#6B7280;">
                <i class="bi bi-journal-x" style="font-size:4rem; opacity:0.3; margin-bottom:1rem; display:block;"></i>
                <h3 class="font-outfit">Menu belum tersedia saat ini.</h3>
            </div>
        @endif
    </section>

    {{-- GALLERY SECTION --}}
    <section class="gallery-section">
        <div class="gallery-container">
            <div class="gallery-header animate-slide-up">
                <h2 class="font-outfit" style="font-size:2rem; font-weight:800; color:var(--text-dark); margin-bottom:0.5rem;">Suasana Nyaman & Asik</h2>
                <p style="color:var(--text-muted);">Spot pewe buat nongkrong, nugas santai, atau quality time bareng teman</p>
            </div>
            
            <div class="gallery-grid">
                <div class="gallery-item gallery-item-large animate-fade-in" style="animation-delay: 0.1s;">
                    <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1000&auto=format&fit=crop" alt="Cafe Interior">
                </div>
                <div class="gallery-item animate-fade-in" style="animation-delay: 0.2s;">
                    <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=800&auto=format&fit=crop" alt="Coffee Aesthetic">
                </div>
                <div class="gallery-item animate-fade-in" style="animation-delay: 0.3s;">
                    <img src="https://images.unsplash.com/photo-1600093463592-8e36ae95ef56?q=80&w=800&auto=format&fit=crop" alt="Cafe Seating">
                </div>
                <div class="gallery-item animate-fade-in" style="animation-delay: 0.4s;">
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800&auto=format&fit=crop" alt="Barista at work">
                </div>
                <div class="gallery-item animate-fade-in" style="animation-delay: 0.5s;">
                    <img src="https://images.unsplash.com/photo-1559925393-8be0ec4767c8?q=80&w=800&auto=format&fit=crop" alt="Food details">
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer style="background:#1F2937;color:#9CA3AF;text-align:center;padding:2rem 1.5rem 6rem 1.5rem;font-size:0.9rem;position:relative;margin-top:auto;">
        <div style="max-width:1200px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
            <div>© {{ date('Y') }} Resto Cafe. Hak Cipta Dilindungi.</div>
            <div style="display:flex;gap:1rem;">
                <a href="/login" style="color:#374151;text-decoration:none;transition:color 0.2s; font-size:1.1rem; opacity:0.5;" title="Restricted Area" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'"><i class="bi bi-lock-fill"></i></a>
            </div>
        </div>
    </footer>

    {{-- FLOATING ORDER CTA --}}
    <div class="floating-cta">
        @if(isset($meja) && $meja)
            <a href="/order?meja={{ $meja }}" class="btn-floating">
                Mulai Pesan Sekarang <i class="bi bi-arrow-right-circle-fill"></i>
            </a>
        @else
            <button type="button" class="btn-floating btn-pilih-meja">
                Mulai Pesan Sekarang <i class="bi bi-arrow-right-circle-fill"></i>
            </button>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showCategory(kategori, btn) {
            // Hide all category groups
            document.querySelectorAll('.menu-category-group').forEach(el => {
                el.style.display = 'none';
            });
            // Show the selected one
            document.getElementById('cat-' + kategori).style.display = 'block';
            
            // Remove active class from all buttons
            document.querySelectorAll('.btn-tab').forEach(el => {
                el.classList.remove('active');
            });
            // Add active class to clicked button
            btn.classList.add('active');
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Handle klik tombol pesan jika belum pilih meja
        document.querySelectorAll('.btn-pilih-meja').forEach(btn => {
            btn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Pilih Meja Dulu!',
                    html: `
                        <p style="font-size:0.9rem;color:#6B7280;margin-bottom:1rem;">Silakan pilih nomor meja kamu:</p>
                        <div style="display:flex;gap:0.5rem;justify-content:center;flex-wrap:wrap;">
                            @for($i = 1; $i <= 9; $i++)
                                @if(in_array($i, $mejaTerisi ?? []))
                                    <div style="width:45px;height:45px;border-radius:12px;border:2px solid #FCA5A5;color:#FCA5A5;display:flex;align-items:center;justify-content:center;font-family:'Outfit',sans-serif;font-weight:700;background:#FEF2F2;cursor:not-allowed;" title="Meja Sedang Digunakan">{{ $i }}</div>
                                @else
                                    <a href="/?meja={{ $i }}" style="width:45px;height:45px;border-radius:12px;border:2px solid #E5E7EB;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;font-family:'Outfit',sans-serif;font-weight:700;transition:all 0.2s;background:white;">{{ $i }}</a>
                                @endif
                            @endfor
                        </div>
                    `,
                    showConfirmButton: false,
                    showCloseButton: true,
                    backdrop: `rgba(0,0,0,0.7)`
                });
            });
        });
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
        });
    </script>
</body>
</html>
