@extends('layouts.app')

@section('content')
<div class="container" style="padding:30px; max-width:1100px; margin:40px auto;">

    <!-- Promo header banner -->
    <div style="background:#fff;border-radius:12px;padding:18px;margin-bottom:25px;display:flex;align-items:center;gap:20px;">
        <img src="https://via.placeholder.com/240x140?text=Promo" 
             alt="promo" 
             style="height:140px;object-fit:cover;border-radius:8px;">
        <div>
            <h2 style="margin:0 0 8px;">Promo & Flash Sale</h2>
            <p style="margin:0;color:#666;">Nikmati promo terbatas, diskon real-time, dan voucher spesial.</p>
        </div>
    </div>

    {{-- =====================
         LIST PROMO
    ====================== --}}
    <h3 style="margin-bottom:15px;">Promo Aktif</h3>

    @foreach($promotions as $promo)
    <div style="background:#fff;padding:16px;border-radius:10px;margin-bottom:18px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <h3 style="margin:0;">
                    {{ $promo->name }}
                    @if($promo->type == 'flash')
                        <small style="color:red;">(Flash Sale)</small>
                    @endif
                </h3>

                <p style="margin:4px 0;color:#666;">{!! $promo->description !!}</p>
            </div>

            <div style="text-align:right;">
                <div id="countdown-{{ $promo->id }}" style="font-weight:700;color:#e74c3c;margin-bottom:6px;"></div>

                <a href="{{ route('promo.show', $promo->id) }}" 
                   class="btn" 
                   style="background:#3498db;color:white;padding:8px 12px;border-radius:8px;text-decoration:none;">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>

    <script>
        (function(){
            var end = new Date("{{ \Carbon\Carbon::parse($promo->end_at)->toIso8601String() }}").getTime();
            var el = document.getElementById("countdown-{{ $promo->id }}");
            if (!el) return;

            var timer = setInterval(function(){
                var now = new Date().getTime();
                var distance = end - now;

                if (distance < 0) {
                    el.innerHTML = "Selesai";
                    clearInterval(timer);
                    return;
                }

                var h = Math.floor((distance%(1000*60*60*24))/(1000*60*60));
                var m = Math.floor((distance%(1000*60*60))/(1000*60));
                var s = Math.floor((distance%(1000*60))/1000);
                el.innerHTML = h + "j " + m + "m " + s + "s";
            }, 1000);
        })();
    </script>
    @endforeach


    {{-- ============================
          Rekomendasi Produk
    ============================= --}}
    <h3 style="margin-top:35px;">Rekomendasi Produk</h3>

    <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:25px;">
        @foreach($recommended as $prod)
        <div style="background:#fff;padding:12px;border-radius:10px;width:200px;">
            <img src="{{ $prod->FotoURL ?? 'https://via.placeholder.com/200x140?text=No+Image' }}" 
                 style="width:100%;height:120px;object-fit:cover;border-radius:8px;">

            <h4 style="margin:8px 0 4px;">{{ $prod->NamaProduk }}</h4>

            <div style="font-size:16px;font-weight:600;">Rp{{ number_format($prod->Harga) }}</div>

            <a href="{{ route('produk.detail', $prod->ProdukID) }}" 
               style="display:inline-block;margin-top:8px;padding:6px 8px;background:#2ecc71;color:#fff;border-radius:6px;text-decoration:none;">
                Lihat
            </a>
        </div>
        @endforeach
    </div>


    {{-- ============================
           Voucher Claim
    ============================= --}}
    <h3 style="margin-top:25px;">Voucher Tersedia</h3>

    <div style="display:flex;gap:12px;flex-wrap:wrap;">
        @foreach($vouchers as $v)
        <div style="background:#fff;padding:12px;border-radius:8px;width:260px;">
            <div style="font-weight:700;">Kode: {{ $v->kode_voucher }}</div>
            <div style="color:#777;margin:6px 0;">Status: {{ $v->claimed ? 'Sudah diklaim' : 'Tersedia' }}</div>

            <form method="POST" action="{{ route('promo.claim') }}">
                @csrf
                <input type="hidden" name="voucher_id" value="{{ $v->id }}">
                <button class="btn" 
                        style="background:{{ $v->claimed ? '#aaa' : '#3498db' }}; 
                               color:#fff; 
                               padding:8px 10px; 
                               border-radius:6px;" 
                        {{ $v->claimed ? 'disabled' : '' }}>
                    {{ $v->claimed ? 'Tidak Tersedia' : 'Klaim Voucher' }}
                </button>
            </form>
        </div>
        @endforeach
    </div>

</div>
@endsection
