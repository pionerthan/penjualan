@extends('layouts.app') {{-- Ganti jika kamu pakai layout lain --}}

@section('content')
<style>
    .container {
        max-width: 900px;
        margin: auto;
        background: #ffffff;
        padding: 20px 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    h2, h3 {
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    thead {
        background-color: #f2f2f2;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    tbody tr:hover {
        background-color: #f9f9f9;
    }

    img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
    }

    a, button {
        text-decoration: none;
        background-color: #3498db;
        color: #fff;
        padding: 8px 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    a:hover, button:hover {
        background-color: #2980b9;
    }

    .danger {
        background-color: #e74c3c;
    }

    .danger:hover {
        background-color: #c0392b;
    }

    form input[type="text"] {
        width: 100%;
        padding: 8px 10px;
        margin-top: 6px;
        margin-bottom: 15px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    label {
        font-weight: bold;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .actions {
        display: flex;
        gap: 10px;
    }

    /* Enhanced Payment Method Styles */
    .payment-method-group {
        margin-bottom: 25px;
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .payment-method-group:hover {
        border-color: rgba(52, 152, 219, 0.2);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .payment-method-group label {
        display: block;
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
        text-align: center;
        background: linear-gradient(45deg, #3498db, #8e44ad);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .payment-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .payment-card {
        position: relative;
        background: white;
        border: 3px solid #e9ecef;
        border-radius: 16px;
        padding: 20px 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .payment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
        transition: left 0.5s;
        z-index: 1;
    }

    .payment-card:hover::before {
        left: 100%;
    }

    .payment-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .payment-card.selected {
        border-color: #3498db;
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 30px rgba(52, 152, 219, 0.3);
    }

    .payment-card.selected .payment-icon {
        animation: bounce 0.6s ease-in-out;
        transform: scale(1.1);
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0) scale(1.1); }
        40% { transform: translateY(-10px) scale(1.1); }
        60% { transform: translateY(-5px) scale(1.1); }
    }

    .payment-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        display: block;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .payment-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 5px;
        position: relative;
        z-index: 2;
    }

    .payment-desc {
        font-size: 0.85rem;
        opacity: 0.8;
        line-height: 1.3;
        position: relative;
        z-index: 2;
    }

    .payment-card.selected .payment-desc {
        opacity: 0.9;
    }

    /* Individual card styling */
    .payment-card[data-value="Transfer Bank"] {
        border-color: #e74c3c;
    }

    .payment-card[data-value="Transfer Bank"]:hover {
        border-color: #c0392b;
    }

    .payment-card[data-value="Transfer Bank"].selected {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        border-color: #e74c3c;
    }

    .payment-card[data-value="COD"] {
        border-color: #f39c12;
    }

    .payment-card[data-value="COD"]:hover {
        border-color: #e67e22;
    }

    .payment-card[data-value="COD"].selected {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        border-color: #f39c12;
    }

    .payment-card[data-value="E-Wallet"] {
        border-color: #27ae60;
    }

    .payment-card[data-value="E-Wallet"]:hover {
        border-color: #229954;
    }

    .payment-card[data-value="E-Wallet"].selected {
        background: linear-gradient(135deg, #27ae60, #229954);
        border-color: #27ae60;
    }

    /* Hidden select for form submission */
    #MetodePembayaran {
        display: none;
    }

    /* Selection indicator */
    .payment-card::after {
        content: '';
        position: absolute;
        top: 10px;
        right: 10px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: transparent;
        border: 2px solid #ddd;
        transition: all 0.3s ease;
        z-index: 3;
    }

    .payment-card.selected::after {
        background: white;
        border-color: white;
        transform: scale(1.2);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23000'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'/%3E%3C/svg%3E");
        background-size: 12px;
        background-repeat: no-repeat;
        background-position: center;
    }

    /* Payment details section */
    .payment-details {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
        display: none;
        animation: slideDown 0.3s ease-out;
        border-left: 4px solid #3498db;
    }

    .payment-details.show {
        display: block;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .payment-details h4 {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .payment-details p {
        color: #5a6c7d;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .payment-details .highlight {
        background: linear-gradient(45deg, #3498db, #8e44ad);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 600;
    }

    /* Error state */
    .payment-options.error .payment-card {
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Validation message */
    .validation-message {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 0.9rem;
        text-align: center;
        margin-top: 15px;
        display: none;
        animation: slideIn 0.3s ease-out;
    }

    .validation-message.show {
        display: block;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Enhanced submit button */
    .checkout-btn {
        background: linear-gradient(45deg, #27ae60, #2ecc71);
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
    }

    .checkout-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .checkout-btn:hover::before {
        left: 100%;
    }

    .checkout-btn:hover {
        background: linear-gradient(45deg, #229954, #27ae60);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(39, 174, 96, 0.3);
    }

    .checkout-btn:disabled {
        background: #bdc3c7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .payment-options {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .payment-card {
            padding: 15px;
        }

        .payment-icon {
            font-size: 2rem;
        }

        .payment-method-group label {
            font-size: 1.1rem;
        }
    }
</style>

<div class="container">
    <h2>🛒 Keranjang Belanja</h2>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if(count($keranjang) === 0)
        <p>Keranjang kamu masih kosong.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($produks as $produk)
                    @php
                        $jumlah = $keranjang[$produk->ProdukID];
                        $subtotal = $produk->Harga * $jumlah;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td><img src="{{ $produk->FotoURL }}" alt="{{ $produk->NamaProduk }}"></td>
                        <td>{{ $produk->NamaProduk }}</td>
                        <td>Rp {{ number_format($produk->Harga, 0, ',', '.') }}</td>
                        <td>{{ $jumlah }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td class="actions">
                            <form action="{{ route('keranjang.hapus', $produk->ProdukID) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?')" style="display:inline;">
                                @csrf
                                <button type="submit" class="danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td colspan="2"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td colspan="2">
                        <input type="text" id="voucherCode" name="voucher" placeholder="Masukan kode voucher">
                        <button type="button" id="applyVoucher">Gunakan</button>
                        <div id="voucherMessage" style="color: red; font-size: 14px; margin-top: 5pc;"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Total Setelah Diskon</strong></td>
                    <td colspan="2"><strong id="totalDiskon">Rp {{ number_format($total, 0, ',', '.') }} </strong> </td>
                </tr>
            </tbody>
        </table>

        <div class="actions" style="margin-bottom: 30px;">
            <a href="{{ route('keranjang.kosongkan') }}" class="danger"
               onclick="return confirm('Yakin ingin mengosongkan keranjang?')">🗑 Kosongkan Keranjang</a>
        </div>

        <hr>
        <h3>🧾 Isi Data Pelanggan untuk Checkout</h3>

        <form action="{{ route('checkout.proses') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="form-group">
                <label for="NamaPelanggan">Nama Pelanggan:</label>
                <input type="text" name="NamaPelanggan" id="NamaPelanggan" required>
            </div>
            <div class="form-group">
                <label for="Alamat">Alamat:</label>
                <input type="text" name="Alamat" id="Alamat" required>
            </div>
            <div class="form-group">
                <label for="NomorTelepon">Nomor Telepon:</label>
                <input type="text" name="NomorTelepon" id="NomorTelepon" required>
            </div>

            <div class="payment-method-group">
                <label for="MetodePembayaran">💳 Pilih Metode Pembayaran</label>
                
                <div class="payment-options" id="paymentOptions">
                    <div class="payment-card" data-value="Transfer Bank" onclick="selectPayment('Transfer Bank')">
                        <span class="payment-icon">🏦</span>
                        <div class="payment-title">Transfer Bank</div>
                        <div class="payment-desc">Transfer melalui rekening bank</div>
                    </div>

                    <div class="payment-card" data-value="COD" onclick="selectPayment('COD')">
                        <span class="payment-icon">💵</span>
                        <div class="payment-title">COD</div>
                        <div class="payment-desc">Bayar saat barang tiba</div>
                    </div>

                    <div class="payment-card" data-value="E-Wallet" onclick="selectPayment('E-Wallet')">
                        <span class="payment-icon">📱</span>
                        <div class="payment-title">E-Wallet</div>
                        <div class="payment-desc">Pembayaran digital</div>
                    </div>
                </div>

                <!-- Hidden select for form submission -->
                <select name="MetodePembayaran" id="MetodePembayaran" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="COD">Cash on Delivery (COD)</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>

                <!-- Payment Details -->
                <div id="paymentDetails" class="payment-details">
                    <h4 id="detailTitle"></h4>
                    <p id="detailContent"></p>
                </div>

                <!-- Validation Message -->
                <div id="validationMessage" class="validation-message">
                    Mohon pilih metode pembayaran terlebih dahulu
                </div>
            </div>

            <button type="submit" class="checkout-btn" id="checkoutBtn">
                ✅ Checkout Sekarang
            </button>
        </form>
    @endif
</div>

<script>
    let selectedPayment = null;

    // Payment details content
    const paymentDetails = {
        'Transfer Bank': {
            title: '🏦 Transfer Bank',
            content: 'Anda akan mendapatkan <span class="highlight">nomor rekening</span> setelah konfirmasi pesanan. Transfer dapat dilakukan melalui ATM, mobile banking, atau internet banking. Pesanan akan diproses setelah pembayaran dikonfirmasi.'
        },
        'COD': {
            title: '💵 Cash on Delivery (COD)',
            content: 'Bayar langsung kepada <span class="highlight">kurir saat barang tiba</span> di lokasi Anda. Pastikan menyiapkan uang pas atau kembalian. Tersedia untuk area tertentu dengan biaya tambahan Rp 5.000.'
        },
        'E-Wallet': {
            title: '📱 E-Wallet Digital',
            content: 'Pembayaran melalui <span class="highlight">GoPay, OVO, DANA, atau LinkAja</span>. Pembayaran instan dan otomatis dikonfirmasi. Dapatkan cashback hingga 2% untuk setiap transaksi.'
        }
    };

    function selectPayment(value) {
        // Remove loading state from all cards
        document.querySelectorAll('.payment-card').forEach(card => {
            card.classList.remove('loading');
        });

        // Add loading state to clicked card
        const clickedCard = document.querySelector(`[data-value="${value}"]`);
        clickedCard.classList.add('loading');

        // Simulate loading delay
        setTimeout(() => {
            // Remove previous selection
            document.querySelectorAll('.payment-card').forEach(card => {
                card.classList.remove('selected', 'loading');
            });

            // Add selection to clicked card
            clickedCard.classList.add('selected');
            
            // Update hidden select
            document.getElementById('MetodePembayaran').value = value;
            selectedPayment = value;

            // Show payment details
            showPaymentDetails(value);

            // Hide validation message
            document.getElementById('validationMessage').classList.remove('show');

            // Enable checkout button
            document.getElementById('checkoutBtn').disabled = false;

            // Add success sound effect (optional)
            playSuccessSound();

        }, 300);
    }

    function showPaymentDetails(method) {
        const detailsContainer = document.getElementById('paymentDetails');
        const titleElement = document.getElementById('detailTitle');
        const contentElement = document.getElementById('detailContent');

        if (paymentDetails[method]) {
            titleElement.textContent = paymentDetails[method].title;
            contentElement.innerHTML = paymentDetails[method].content;
            
            detailsContainer.classList.add('show');
        }
    }

    function playSuccessSound() {
        // Create audio feedback (optional)
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
            oscillator.frequency.setValueAtTime(1000, audioContext.currentTime + 0.1);
            
            gainNode.gain.setValueAtTime(0, audioContext.currentTime);
            gainNode.gain.linearRampToValueAtTime(0.1, audioContext.currentTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.2);
        } catch (e) {
            // Audio context might not be available
        }
    }

    // Form validation
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        if (!selectedPayment) {
            e.preventDefault();
            
            const paymentOptions = document.getElementById('paymentOptions');
            const validationMessage = document.getElementById('validationMessage');
            
            paymentOptions.classList.add('error');
            validationMessage.classList.add('show');
            
            setTimeout(() => {
                paymentOptions.classList.remove('error');
            }, 500);
            
            return false;
        }
        
        // Show loading state on submit button
        const submitBtn = document.getElementById('checkoutBtn');
        submitBtn.innerHTML = '⏳ Memproses Checkout...';
        submitBtn.disabled = true;
    });

    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        const cards = document.querySelectorAll('.payment-card');
        const currentIndex = Array.from(cards).findIndex(card => card.classList.contains('selected'));
        
        if (e.key === 'ArrowLeft' && currentIndex > 0) {
            cards[currentIndex - 1].click();
        } else if (e.key === 'ArrowRight' && currentIndex < cards.length - 1) {
            cards[currentIndex + 1].click();
        } else if (e.key === 'Enter' && document.activeElement.classList.contains('payment-card')) {
            document.activeElement.click();
        }
    });

    // Initialize checkout button state
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('checkoutBtn').disabled = true;
    });
</script>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $("#applyVoucher").click(function(){
        let kode = $("#voucherCode").val();

        if(kode.length === 0) {
            $("#voucherMessage").text("⚠️ Masukkan kode voucher terlebih dahulu!");
            return;
        }

        $.ajax({
            url: "{{ route('voucher.cek') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                kode: kode,
                total: {{ $total }}
            },
            success: function(res){
                if(res.success){
                    $("#voucherMessage").css("color","green").text("✅ Voucher berhasil digunakan!");
                    $("#totalDiskon").text("Rp " + new Intl.NumberFormat('id-ID').format(res.total_setelah_diskon));
                } else {
                    $("#voucherMessage").css("color","red").text("❌ " + res.message);
                    $("#totalDiskon").text("Rp " + new Intl.NumberFormat('id-ID').format({{ $total }}));
                }
            }
        });
    });
});
</script>
@endsection