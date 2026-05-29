<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Seblak Saiton — Warung seblak self-order terbaik! Pesan langsung dari meja kamu.">
    <title>Seblak Saiton — Sensasi Pedas Bikin Nagih</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800;900&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
</head>
<body style="margin:0;">
    <div style="min-height:100vh;display:flex;flex-direction:column;">
        {{-- HERO --}}
        <div style="flex:1;background:url('https://images.unsplash.com/photo-1623341214825-9f4f963727da?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat fixed;color:white;display:flex;align-items:center;justify-content:center;text-align:center;padding:2rem;position:relative;overflow:hidden;">
            <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:linear-gradient(135deg,rgba(15,23,42,0.9) 0%,rgba(37,99,235,0.7) 100%);backdrop-filter:blur(4px);z-index:0;"></div>
            <div style="position:absolute;top:-100px;right:-100px;width:400px;height:400px;background:rgba(37,99,235,0.08);border-radius:50%;"></div>
            <div style="position:absolute;bottom:-80px;left:-80px;width:300px;height:300px;background:rgba(37,99,235,0.06);border-radius:50%;"></div>
            <div style="position:absolute;top:50%;left:10%;width:200px;height:200px;background:rgba(96,165,250,0.05);border-radius:50%;"></div>

            <div class="animate-slide-up" style="position:relative;z-index:1;max-width:500px;">
                <div class="animate-bounce-in" style="font-size:5rem;margin-bottom:1rem;color:var(--primary);"><i class="bi bi-shop"></i></div>
                <h1 style="font-family:'Poppins',sans-serif;font-weight:900;font-size:3rem;margin-bottom:0.5rem;letter-spacing:-1px;">Seblak Saiton</h1>
                <p style="font-size:1.1rem;opacity:0.9;margin-bottom:0.5rem;">Self-Order System</p>
                <p style="font-size:0.9rem;opacity:0.7;margin-bottom:2.5rem;">Pesan seblak favorit kamu langsung dari meja.<br>Tinggal scan QR, pilih menu, dan nikmati!</p>

                <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                    <button id="btnCobaPesan" style="background:linear-gradient(135deg,#2563EB,#3B82F6);color:white;padding:1rem 2.5rem;border-radius:999px;font-family:'Poppins',sans-serif;font-weight:700;font-size:1rem;border:none;cursor:pointer;transition:all 0.3s;box-shadow:0 4px 20px rgba(37,99,235,0.4);">
                        Coba Pesan →
                    </button>
                </div>

                {{-- MEJA QUICK LINKS --}}
                <div style="margin-top:3rem;">
                    <p style="font-size:0.8rem;opacity:0.6;margin-bottom:0.75rem;">Atau pilih nomor meja:</p>
                    <div style="display:flex;gap:0.5rem;justify-content:center;flex-wrap:wrap;">
                        @for($i = 1; $i <= 9; $i++)
                            @if(in_array($i, $mejaTerisi ?? []))
                                <div style="width:44px;height:44px;border-radius:12px;border:2px solid rgba(239,68,68,0.4);color:rgba(255,255,255,0.5);display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:700;backdrop-filter:blur(4px);background:rgba(239,68,68,0.2);cursor:not-allowed;" title="Meja Sedang Digunakan">{{ $i }}</div>
                            @else
                                <a href="/order?meja={{ $i }}" style="width:44px;height:44px;border-radius:12px;border:2px solid rgba(96,165,250,0.4);color:white;display:flex;align-items:center;justify-content:center;text-decoration:none;font-family:'Poppins',sans-serif;font-weight:700;transition:all 0.3s;backdrop-filter:blur(4px);background:rgba(255,255,255,0.05);">{{ $i }}</a>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTEN BAWAH (PROMO DLL) --}}
        <div style="background:#F8FAFF;flex:1;padding:2.5rem 1.5rem;border-radius:32px 32px 0 0;margin-top:-30px;position:relative;z-index:2;box-shadow:0 -10px 20px rgba(0,0,0,0.05);">
            <div style="max-width:500px;margin:0 auto;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                    <h2 class="font-poppins" style="font-size:1.2rem;font-weight:700;color:var(--text-dark);">Promo Spesial</h2>
                </div>

                {{-- PROMO BANNER --}}
                <div class="animate-slide-up" style="margin-bottom:1.5rem;overflow-x:auto;display:flex;gap:1rem;padding-bottom:0.5rem;scroll-snap-type:x mandatory;scrollbar-width:none;">
                    <div style="min-width:85%;scroll-snap-align:start;background:linear-gradient(135deg,#2563EB,#3B82F6);border-radius:20px;padding:1.5rem;color:white;position:relative;overflow:hidden;box-shadow:0 4px 15px rgba(37,99,235,0.3);">
                        <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>
                        <div style="position:absolute;bottom:-15px;right:20px;width:60px;height:60px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
                        <p style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px;opacity:0.9;margin-bottom:0.5rem;font-weight:600;"><i class="bi bi-tag-fill"></i> Promo Mingguan</p>
                        <h3 class="font-poppins" style="font-weight:800;font-size:1.25rem;margin-bottom:0.25rem;line-height:1.2;">Diskon 10% Setiap Hari Jumat!</h3>
                        <p style="font-size:0.85rem;opacity:0.9;">Berlaku untuk Dine-in & Take Away</p>
                    </div>
                    <div style="min-width:85%;scroll-snap-align:start;background:linear-gradient(135deg,#0F172A,#1E293B);border-radius:20px;padding:1.5rem;color:white;position:relative;overflow:hidden;box-shadow:0 4px 15px rgba(15,23,42,0.3);">
                        <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(37,99,235,0.15);border-radius:50%;"></div>
                        <p style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px;opacity:0.9;margin-bottom:0.5rem;font-weight:600;"><i class="bi bi-star-fill"></i> Paling Laris</p>
                        <h3 class="font-poppins" style="font-weight:800;font-size:1.25rem;margin-bottom:0.25rem;line-height:1.2;">Seblak Komplit Lv.3</h3>
                        <p style="font-size:0.85rem;opacity:0.9;">Topping melimpah, pedasnya nendang!</p>
                    </div>
                    <div style="min-width:85%;scroll-snap-align:start;background:linear-gradient(135deg,#0891B2,#06B6D4);border-radius:20px;padding:1.5rem;color:white;position:relative;overflow:hidden;box-shadow:0 4px 15px rgba(8,145,178,0.3);">
                        <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>
                        <p style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px;opacity:0.9;margin-bottom:0.5rem;font-weight:600;"><i class="bi bi-cup-straw"></i> Menu Baru</p>
                        <h3 class="font-poppins" style="font-weight:800;font-size:1.25rem;margin-bottom:0.25rem;line-height:1.2;">Es Teh Manis Jumbo</h3>
                        <p style="font-size:0.85rem;opacity:0.9;">Penyelamat tenggorokan habis kepedesan.</p>
                    </div>
                </div>

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                    <h2 class="font-poppins" style="font-size:1.2rem;font-weight:700;color:var(--text-dark);">Kenapa Milih Kita?</h2>
                </div>

                {{-- QUICK INFO --}}
                <div class="animate-slide-up" style="display:flex;gap:0.75rem;margin-bottom:1rem;">
                    <div style="flex:1;background:white;border-radius:16px;padding:1rem;text-align:center;box-shadow:0 4px 12px rgba(0,0,0,0.03);">
                        <div style="width:40px;height:40px;background:#DBEAFE;color:#2563EB;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.5rem;font-size:1.2rem;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <p class="font-poppins" style="font-weight:700;font-size:0.85rem;color:var(--text-dark);">Cepat</p>
                        <p style="font-size:0.7rem;color:var(--text-muted);margin-top:0.25rem;">Gak pake lama</p>
                    </div>
                    <div style="flex:1;background:white;border-radius:16px;padding:1rem;text-align:center;box-shadow:0 4px 12px rgba(0,0,0,0.03);">
                        <div style="width:40px;height:40px;background:#D1FAE5;color:#22C55E;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.5rem;font-size:1.2rem;">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <p class="font-poppins" style="font-weight:700;font-size:0.85rem;color:var(--text-dark);">Murah</p>
                        <p style="font-size:0.7rem;color:var(--text-muted);margin-top:0.25rem;">Mulai Rp1.000</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div style="background:#0F172A;color:rgba(255,255,255,0.5);text-align:center;padding:1rem;font-size:0.8rem;position:relative;">
            © {{ date('Y') }} Seblak Saiton.
            <a href="/login" style="position:absolute;right:10px;bottom:10px;color:rgba(255,255,255,0.1);font-size:0.7rem;text-decoration:none;"><i class="bi bi-lock-fill"></i></a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('btnCobaPesan').addEventListener('click', function() {
            Swal.fire({
                title: 'Pilih Meja Dulu!',
                text: 'Silakan klik nomor meja kamu di bawah ini 👇',
                icon: 'warning',
                confirmButtonText: 'Oke, Paham',
                confirmButtonColor: '#2563EB',
                backdrop: `rgba(0,0,0,0.7)`
            });
        });
    </script>
</body>
</html>
