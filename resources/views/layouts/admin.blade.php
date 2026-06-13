<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — Resto Cafe')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-layout">
        {{-- SIDEBAR --}}
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-logo"><i class="bi bi-flower2" style="color:#4ADE80;"></i> Resto Cafe</div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="icon"><i class="bi bi-grid-1x2-fill"></i></span> Dashboard
                </a>
                <a href="{{ route('admin.pesanan.index') }}" class="sidebar-link {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                    <span class="icon"><i class="bi bi-receipt"></i></span> Pesanan
                    @if(isset($unread_orders_count) && $unread_orders_count > 0)
                        <span class="sidebar-badge" id="sidebarBadge">{{ $unread_orders_count }}</span>
                    @else
                        <span class="sidebar-badge" id="sidebarBadge" style="display: none;">0</span>
                    @endif
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="sidebar-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <span class="icon"><i class="bi bi-graph-up"></i></span> Laporan Bulanan
                </a>
                <a href="{{ route('admin.menu.index') }}" class="sidebar-link {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                    <span class="icon"><i class="bi bi-journal-text"></i></span> Kelola Menu
                </a>
                <a href="{{ route('admin.qr.meja') }}" class="sidebar-link {{ request()->routeIs('admin.qr.meja') ? 'active' : '' }}">
                    <span class="icon"><i class="bi bi-qr-code"></i></span> QR Code Meja
                </a>
                <a href="{{ route('admin.pos.index') }}" class="sidebar-link {{ request()->routeIs('admin.pos.*') ? 'active' : '' }}" style="background: var(--admin-primary); color: white; border-radius: 8px; margin-top: 0.5rem; font-weight: bold; border-left: none; justify-content: center;">
                    <span class="icon"><i class="bi bi-display"></i></span> Kasir (POS)
                </a>
            </nav>
            <div class="sidebar-footer">
                <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="sidebar-link" style="width:100%;border:none;background:none;cursor:pointer;padding:0.75rem 0;">
                        <span class="icon"><i class="bi bi-box-arrow-left"></i></span> Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="admin-main">
            {{-- Header Actions (Global) --}}
            @php
                $mejaTerisi = \App\Models\Pesanan::whereNotIn('status', ['selesai', 'dibatalkan'])
                    ->pluck('nomor_meja')
                    ->toArray();
            @endphp
            <div class="admin-header-actions" style="display:flex;gap:1rem;align-items:center;">
                <div class="notification-wrapper" id="tableStatusWrapper">
                    <button class="notif-btn" id="tableStatusBtn" title="Status Meja">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </button>
                    <div class="notif-dropdown" id="tableStatusDropdown" style="width:280px;right:0;">
                        <div class="notif-header">
                            <span>Status Meja (Real-time)</span>
                        </div>
                        <div style="padding:1rem; display:grid; grid-template-columns:repeat(3, 1fr); gap:0.5rem; max-height:300px; overflow-y:auto;">
                            @for($i = 1; $i <= 9; $i++)
                                @if(in_array($i, $mejaTerisi))
                                    <div style="background:#EF4444;color:white;border-radius:8px;text-align:center;padding:0.75rem 0;font-weight:bold;font-family:'Poppins',sans-serif;box-shadow:0 2px 4px rgba(239,68,68,0.2);" title="Terisi">
                                        {{ $i }}
                                    </div>
                                @else
                                    <div style="background:#10B981;color:white;border-radius:8px;text-align:center;padding:0.75rem 0;font-weight:bold;font-family:'Poppins',sans-serif;box-shadow:0 2px 4px rgba(16,185,129,0.2);" title="Kosong">
                                        {{ $i }}
                                    </div>
                                @endif
                            @endfor
                        </div>
                        <div style="padding:0.5rem 1rem; border-top:1px solid #E2E8F0; font-size:0.75rem; color:var(--admin-text-muted); display:flex; justify-content:space-between;">
                            <span><span style="color:#10B981;">●</span> Kosong</span>
                            <span><span style="color:#EF4444;">●</span> Terisi</span>
                        </div>
                    </div>
                </div>
                <div class="notification-wrapper" id="notifWrapper">
                    <button class="notif-btn" id="notifBtn">
                        <i class="bi bi-envelope"></i>
                        <span class="notif-badge" id="notifBadge" style="display:none;">0</span>
                    </button>
                    <div class="notif-dropdown" id="notifDropdown">
                        <div class="notif-header">
                            <span>Riwayat Pesanan Baru</span>
                            <button onclick="clearNotif()">Hapus Semua</button>
                        </div>
                        <div class="notif-list" id="notifList">
                            <div class="notif-empty">Belum ada pesanan baru</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile menu toggle --}}
            <button onclick="document.getElementById('sidebar').classList.toggle('open')" style="display:none;background:var(--admin-primary);color:white;border:none;padding:0.5rem 1rem;border-radius:8px;cursor:pointer;margin-bottom:1rem;font-weight:600;" class="mobile-toggle" id="menuToggle"><i class="bi bi-list"></i> Menu</button>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <style>
        @media (max-width: 768px) {
            .mobile-toggle { display: block !important; }
        }
    </style>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: "Sesi admin Anda akan diakhiri.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#94A3B8',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'modern-modal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            })
        }
    </script>
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableStatusBtn = document.getElementById('tableStatusBtn');
            const tableStatusDropdown = document.getElementById('tableStatusDropdown');

            if (tableStatusBtn && tableStatusDropdown) {
                tableStatusBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    tableStatusDropdown.classList.toggle('show');
                });

                document.addEventListener('click', () => tableStatusDropdown.classList.remove('show'));
                tableStatusDropdown.addEventListener('click', (e) => e.stopPropagation());
            }
        });
    </script>

    @unless(request()->routeIs('admin.pos.*'))
    {{-- Script Notifikasi Pesanan Baru --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let lastOrderId = parseInt(localStorage.getItem('last_order_id')) || 0;
            const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/1110/1110-preview.mp3'); // Suara Catchy & Lebih Panjang
            audio.volume = 1.0;

            // --- FITUR RIWAYAT NOTIFIKASI ---
            const notifBtn = document.getElementById('notifBtn');
            const notifDropdown = document.getElementById('notifDropdown');
            const notifBadge = document.getElementById('notifBadge');
            const notifList = document.getElementById('notifList');

            let unreadCount = parseInt(localStorage.getItem('unread_count') || '0');
            let notifHistory = JSON.parse(localStorage.getItem('notif_history') || '[]');

            function updateNotifUI() {
                // Update Badge
                if (unreadCount > 0) {
                    notifBadge.innerText = unreadCount;
                    notifBadge.style.display = 'flex';
                } else {
                    notifBadge.style.display = 'none';
                }

                // Update List
                if (notifHistory.length > 0) {
                    notifList.innerHTML = notifHistory.map((n, i) => `
                        <div class="notif-item animate__animated animate__fadeIn" onclick="window.location.href='{{ url('admin/pesanan') }}/${n.id}'">
                            <div class="notif-item-icon"><i class="bi bi-receipt"></i></div>
                            <div class="notif-item-content">
                                <div class="notif-item-title">Pesanan dari ${n.nama}</div>
                                <div class="notif-item-meta">${n.kode} • Meja ${n.meja} • ${n.porsi_count} Porsi</div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    notifList.innerHTML = '<div class="notif-empty">Belum ada pesanan baru</div>';
                }
            }

            // Toggle Dropdown
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notifDropdown.classList.toggle('show');
                unreadCount = 0;
                localStorage.setItem('unread_count', '0');
                updateNotifUI();
            });

            document.addEventListener('click', () => notifDropdown.classList.remove('show'));
            notifDropdown.addEventListener('click', (e) => e.stopPropagation());

            window.clearNotif = function() {
                notifHistory = [];
                unreadCount = 0;
                localStorage.setItem('notif_history', '[]');
                localStorage.setItem('unread_count', '0');
                updateNotifUI();
            };

            updateNotifUI(); // Init UI

            function checkOrders() {
                fetch('{{ route('admin.notifications.check') }}')
                    .then(response => response.json())
                    .then(data => {
                        // Update Sidebar Badge
                        const sidebarBadge = document.getElementById('sidebarBadge');
                        if (sidebarBadge) {
                            if (data.new_orders_count > 0) {
                                sidebarBadge.innerText = data.new_orders_count;
                                sidebarBadge.style.display = 'flex';
                            } else {
                                sidebarBadge.style.display = 'none';
                            }
                        }

                        // Jika ini pertama kali atau data kosong, simpan ID-nya saja tanpa notif
                        if (lastOrderId === 0 && data.latest_id > 0) {
                            lastOrderId = data.latest_id;
                            localStorage.setItem('last_order_id', lastOrderId);
                            return;
                        }

                        // Jika database kerest (ID mengecil), reset ID-nya
                        if (data.latest_id > 0 && data.latest_id < lastOrderId) {
                            lastOrderId = data.latest_id;
                            localStorage.setItem('last_order_id', lastOrderId);
                            return;
                        }

                        // Jika ada ID baru yang lebih besar dari yang kita simpan
                        if (data.latest_id > lastOrderId) {
                            lastOrderId = data.latest_id;
                            localStorage.setItem('last_order_id', lastOrderId);

                            // Tambah ke History
                            notifHistory.unshift({ id: data.latest_id, kode: data.kode, nama: data.nama, meja: data.meja, porsi_count: data.porsi_count });
                            if (notifHistory.length > 10) notifHistory.pop(); // Simpan 10 terakhir saja
                            unreadCount++;
                            
                            localStorage.setItem('notif_history', JSON.stringify(notifHistory));
                            localStorage.setItem('unread_count', unreadCount.toString());
                            updateNotifUI();

                            // Play sound
                            audio.play().catch(e => console.log("Audio play blocked by browser. User interaction needed."));

                            // Tampilkan SweetAlert Modal (Centered & Success Green)
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                iconColor: '#2563EB',
                                width: 400,
                                padding: '1.5em',
                                background: 'rgba(255, 255, 255, 0.95)',
                                showConfirmButton: true,
                                confirmButtonText: 'LIHAT PESANAN',
                                confirmButtonColor: '#2563EB',
                                backdrop: `rgba(0,0,0,0.7)`,
                                timer: 10000,
                                timerProgressBar: true,
                                showClass: {
                                    popup: 'animate__animated animate__zoomIn'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__zoomOut'
                                },
                                customClass: {
                                    popup: 'modern-modal',
                                },
                                title: `<div style="font-family: 'Poppins', sans-serif;">
                                            <span style="font-weight:800; color:#2563EB; font-size:0.85rem; letter-spacing:2px; display:block; margin-bottom:8px;">PESANAN BARU MASUK!</span>
                                            <div style="font-size: 1.2rem; color:#0F172A; margin-bottom:10px;"><strong>${data.nama}</strong></div>
                                            <div style="font-size: 0.85rem; color:#64748B;">Meja ${data.meja} • ${data.item_count} Item • ${data.kode}</div>
                                        </div>`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('admin.pesanan.index') }}";
                                }
                            });
                        }
                    })
                    .catch(error => console.error('Error checking orders:', error));
            }

            // Jalankan setiap 5 detik
            setInterval(checkOrders, 5000);
            
            // Jalankan sekali pas load
            checkOrders();
        });
    </script>
    @endunless

    <style>
        .admin-header-actions {
            position: absolute;
            top: 2rem;
            right: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 100;
        }
        .admin-topbar {
            padding-right: 8rem !important; /* Beri ruang ekstra untuk 2 ikon (notif & meja) */
        }
        .notification-wrapper { position: relative; }
        .notif-btn {
            background: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--admin-text);
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            transition: all 0.2s;
            position: relative;
        }
        .notif-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(0,0,0,0.12); }
        .notif-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #2563EB;
            color: white;
            font-size: 0.7rem;
            font-weight: 800;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }
        .notif-dropdown {
            position: absolute;
            top: 45px;
            right: 0;
            width: 300px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: none;
            overflow: hidden;
            border: 1px solid #EEE;
        }
        .notif-dropdown.show { display: block; animation: animate__animated animate__fadeInUp animate__faster; }
        .notif-header {
            padding: 1rem;
            background: #F8F9FA;
            border-bottom: 1px solid #EEE;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 700;
        }
        .notif-header button {
            background: none; border: none; color: var(--admin-primary);
            font-size: 0.75rem; cursor: pointer; font-weight: 600;
        }
        .notif-list { max-height: 400px; overflow-y: auto; }
        .notif-empty { padding: 2rem; text-align: center; color: #BBB; font-size: 0.9rem; }
        .notif-item {
            padding: 1rem;
            display: flex;
            gap: 1rem;
            border-bottom: 1px solid #F5F5F5;
            cursor: pointer;
            transition: background 0.2s;
        }
        .notif-item:hover { background: #F0F4FF; }
        .notif-item-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: #DBEAFE; color: #2563EB;
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
        }
        .notif-item-content { flex: 1; }
        .notif-item-title { font-weight: 700; font-size: 0.85rem; margin-bottom: 2px; }
        .notif-item-meta { font-size: 0.75rem; color: #888; }
        
        /* SIDEBAR BADGE */
        .sidebar-badge {
            background: #2563EB;
            color: white;
            font-size: 0.7rem;
            font-weight: 800;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 10px; /* Slightly rounded instead of circle for variable width */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            border: 2px solid rgba(255,255,255,0.1);
            box-shadow: 0 2px 5px rgba(37, 99, 235, 0.3);
        }

        .modern-modal {
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border: 2px solid rgba(37, 99, 235, 0.3) !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2) !important;
            border-radius: 24px !important;
            padding: 2rem !important;
        }
        .swal2-timer-progress-bar {
            background: linear-gradient(to right, #2563EB, #60A5FA) !important;
        }
    </style>
</body>
</html>
