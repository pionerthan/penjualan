@extends('layouts.app')

@section('content')
<div class="container" style="padding:30px; max-width:1100px; margin:40px auto;">

    <a href="{{ route('promo.index') }}" style="display:inline-block;margin-bottom:14px;padding:8px 12px;background:#eee;border-radius:8px;text-decoration:none;color:#333;">⟵ Kembali ke Promo</a>

    <div style="display:flex;gap:16px;align-items:center;margin-bottom:18px;background:#fff;padding:16px;border-radius:12px;">
        <img src="{{ asset('/mnt/data/1bc21e03-1f89-4d94-8ca8-a2d3bf8bfc48.png') }}" alt="promo" style="height:120px;object-fit:cover;border-radius:8px;">
        <div>
            <h2 style="margin:0 0 6px;">{{ $promo->name }} @if($promo->type == 'flash') <small style="color:#e74c3c;">(Flash Sale)</small> @endif</h2>
            <p style="margin:0;color:#666;">{!! $promo->description !!}</p>
            <div id="promo-countdown" style="margin-top:6px;font-weight:700;color:#e74c3c;"></div>
        </div>
    </div>

    {{-- Produk Promo --}}
    <h3 style="margin-top:6px;">Produk dalam Promo</h3>
    <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        @forelse($products as $prod)
            @php
                // harga diskon: gunakan discount_price kalau ada, kalau tidak pakai discount_percent
                $original = $prod->Harga;
                $discount_price = null;
                if(!empty($prod->discount_price)) {
                    $discount_price = (float) $prod->discount_price;
                } elseif(!empty($prod->discount_percent)) {
                    $discount_price = round($original * (1 - ((float)$prod->discount_percent / 100)), 2);
                }
            @endphp

            <div style="background:#fff;padding:12px;border-radius:10px;width:220px;box-shadow:0 6px 18px rgba(0,0,0,0.06);">
                <img src="{{ $prod->FotoURL ?? 'https://via.placeholder.com/200x140?text=No+Image' }}" style="width:100%;height:120px;object-fit:cover;border-radius:8px;">
                <h4 style="margin:8px 0 4px;font-size:1rem;color:#333;">{{ $prod->NamaProduk }}</h4>

                @if($discount_price)
                    <div style="font-size:0.9rem;color:#999;text-decoration:line-through;">Rp{{ number_format($original) }}</div>
                    <div style="font-weight:700;color:#e67e22;">Rp{{ number_format($discount_price) }}</div>
                    @if(!empty($prod->discount_percent))
                        <div style="font-size:0.85rem;color:#27ae60;margin-top:6px;">Diskon: {{ $prod->discount_percent }}% </div>
                    @endif
                @else
                    <div style="font-weight:700;color:#333;">Rp{{ number_format($original) }}</div>
                @endif

                <div style="margin-top:8px;display:flex;gap:6px;">
                    <a href="{{ route('produk.detail', $prod->ProdukID) }}" style="flex:1;display:inline-block;padding:8px 6px;background:#2980b9;color:#fff;border-radius:6px;text-align:center;text-decoration:none;">Detail</a>

                    <form method="POST" action="{{ route('keranjang.tambah') }}" style="flex:1;">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $prod->ProdukID }}">
                        <input type="hidden" name="jumlah" value="1">
                        <button type="submit" style="width:100%;padding:8px 6px;background:#2ecc71;color:#fff;border-radius:6px;border:none;cursor:pointer;">Tambah</button>
                    </form>
                </div>
            </div>
        @empty
            <div>Tidak ada produk untuk promo ini.</div>
        @endforelse
    </div>

    {{-- Voucher --}}
    <h3>Klaim Voucher</h3>
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:30px;">
        @forelse($vouchers as $v)
            <div style="background:#fff;padding:12px;border-radius:8px;width:280px;box-shadow:0 6px 14px rgba(0,0,0,0.06);">
                <div style="font-weight:700;">Kode: <span style="letter-spacing:2px;">{{ $v->kode_voucher }}</span></div>
                <div style="color:#777;margin:6px 0;">Status: {{ $v->claimed ? 'Sudah diklaim' : 'Tersedia' }}</div>

                <form method="POST" action="{{ route('promo.claim') }}">
                    @csrf
                    <input type="hidden" name="voucher_id" value="{{ $v->id }}">
                    <button type="submit"
                        class="claim-btn"
                        style="background:{{ $v->claimed ? '#999' : '#3498db' }}; color:#fff; padding:8px 10px; border-radius:6px; border:none; cursor:{{ $v->claimed ? 'not-allowed' : 'pointer' }};"
                        {{ $v->claimed ? 'disabled' : '' }}>
                        {{ $v->claimed ? 'Tidak Tersedia' : 'Klaim Voucher' }}
                    </button>
                </form>
            </div>
        @empty
            <div>Tidak ada voucher tersedia saat ini.</div>
        @endforelse
    </div>

</div>

{{-- Modal untuk menampilkan hasil klaim (muncul jika session success/error ada) --}}
<div id="claim-modal" style="display:none;position:fixed;inset:0;align-items:center;justify-content:center;background:rgba(0,0,0,0.5);z-index:2000;">
    <div style="background:#fff;padding:20px;border-radius:12px;max-width:480px;width:90%;color:#111;">
        <h3 id="claim-modal-title" style="margin-top:0;">Status Klaim</h3>
        <p id="claim-modal-message"></p>
        <div style="text-align:right;margin-top:12px;">
            <button onclick="document.getElementById('claim-modal').style.display='none'" style="padding:8px 12px;border-radius:8px;border:none;background:#ccc;">Tutup</button>
            <a id="claim-modal-action" href="{{ route('promo.index') }}" style="display:inline-block;padding:8px 12px;background:#2ecc71;color:#fff;border-radius:8px;text-decoration:none;margin-left:8px;">Lihat Promo</a>
        </div>
    </div>
</div>

{{-- Countdown script & show modal if session set --}}
<script>
    // countdown
    (function(){
        var end = new Date("{{ \Carbon\Carbon::parse($promo->end_at)->toIso8601String() }}").getTime();
        var el = document.getElementById("promo-countdown");
        if (!el) return;
        var timer = setInterval(function(){
            var now = new Date().getTime();
            var distance = end - now;
            if (distance < 0) {
                el.innerHTML = "Selesai";
                clearInterval(timer);
                return;
            }
            var days = Math.floor(distance / (1000*60*60*24));
            var h = Math.floor((distance%(1000*60*60*24))/(1000*60*60));
            var m = Math.floor((distance%(1000*60*60))/(1000*60));
            var s = Math.floor((distance%(1000*60))/1000);
            var text = (days>0? days + "h ":"") + h + "j " + m + "m " + s + "s";
            el.innerHTML = text;
        }, 1000);
    })();

    // show modal if session messages exist
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function(){
            document.getElementById('claim-modal-title').innerText = "Berhasil";
            document.getElementById('claim-modal-message').innerText = "{{ addslashes(session('success')) }}";
            document.getElementById('claim-modal').style.display = 'flex';
        });
    @elseif(session('error'))
        document.addEventListener('DOMContentLoaded', function(){
            document.getElementById('claim-modal-title').innerText = "Gagal";
            document.getElementById('claim-modal-message').innerText = "{{ addslashes(session('error')) }}";
            document.getElementById('claim-modal').style.display = 'flex';
        });
    @endif
</script>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> 664d613eb671ee952505110855ffdac2a37313e3
