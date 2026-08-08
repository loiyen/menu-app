@extends('backsite.layout.main')

@section('container')
    <style>
        .order-live-page {
            background:
                radial-gradient(circle at top left, rgba(105, 108, 255, .10), transparent 32%),
                radial-gradient(circle at top right, rgba(40, 199, 111, .10), transparent 30%),
                #f7f8fc;
            min-height: 100vh;
        }

        .live-hero {
            border-radius: 28px;
            background: linear-gradient(135deg, #111827 0%, #1f2937 48%, #2563eb 100%);
            color: #fff;
            padding: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 22px 50px rgba(15, 23, 42, .18);
        }

        .live-hero::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            right: -90px;
            top: -120px;
        }

        .live-hero::after {
            content: "";
            position: absolute;
            width: 170px;
            height: 170px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .08);
            left: 40%;
            bottom: -100px;
        }

        .live-card {
            border: 0;
            border-radius: 24px;
            background: rgba(255, 255, 255, .96);
            box-shadow: 0 14px 36px rgba(15, 23, 42, .07);
            transition: .22s ease;
        }

        .live-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 42px rgba(15, 23, 42, .11);
        }

        .live-icon {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .soft-primary {
            background: rgba(105, 108, 255, .12);
            color: #696cff;
        }

        .soft-success {
            background: rgba(40, 199, 111, .13);
            color: #28c76f;
        }

        .soft-warning {
            background: rgba(255, 171, 0, .15);
            color: #ffab00;
        }

        .soft-danger {
            background: rgba(234, 84, 85, .12);
            color: #ea5455;
        }

        .soft-dark {
            background: rgba(15, 23, 42, .08);
            color: #0f172a;
        }

        .order-live-item {
            border: 1px solid rgba(148, 163, 184, .18);
            border-radius: 24px;
            padding: 20px;
            background: #fff;
            transition: .2s ease;
        }

        .order-live-item:hover {
            background: #f8fafc;
            border-color: rgba(105, 108, 255, .32);
        }

        .order-code {
            color: #0f172a;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .order-meta {
            color: #64748b;
            font-size: 13px;
        }

        .menu-item-box {
            border: 1px solid rgba(148, 163, 184, .16);
            background: #f8fafc;
            border-radius: 16px;
            padding: 12px 14px;
        }

        .status-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            display: inline-block;
            margin-right: 7px;
        }

        .dot-process {
            background: #ffab00;
        }

        .dot-done {
            background: #28c76f;
        }

        .btn-modern {
            border-radius: 14px;
            padding: 10px 16px;
            font-weight: 700;
        }

        .empty-state {
            border: 1px dashed rgba(148, 163, 184, .45);
            border-radius: 24px;
            padding: 56px 20px;
            background: #f8fafc;
        }

        .live-toast {
            position: fixed;
            right: 24px;
            top: 90px;
            width: 340px;
            max-width: calc(100vw - 32px);
            z-index: 9999;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, .18);
            border-left: 5px solid #696cff;
            border-radius: 20px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, .16);
            padding: 16px;
            display: none;
        }

        .pulse-live {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: #28c76f;
            box-shadow: 0 0 0 rgba(40, 199, 111, .45);
            animation: pulseLive 1.6s infinite;
        }

        @keyframes pulseLive {
            0% {
                box-shadow: 0 0 0 0 rgba(40, 199, 111, .45);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(40, 199, 111, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(40, 199, 111, 0);
            }
        }

        @media (max-width: 767px) {
            .live-hero {
                padding: 22px;
                border-radius: 22px;
            }

            .order-live-item {
                padding: 16px;
            }

            .live-toast {
                right: 16px;
                top: 80px;
            }
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y order-live-page">

        {{-- TOAST NOTIFICATION --}}
        <div id="liveToast" class="live-toast">
            <div class="d-flex align-items-start gap-3">
                <div class="live-icon soft-primary" style="width: 44px; height: 44px; border-radius: 15px;">
                    <i class="bx bx-bell"></i>
                </div>

                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">Pesanan Baru Masuk</h6>
                    <small class="text-muted d-block" id="liveToastMessage">
                        Ada pesanan paid baru yang perlu diproses.
                    </small>
                </div>

                <button type="button" class="btn-close" onclick="hideToast()"></button>
            </div>
        </div>

        {{-- HEADER --}}
        <div class="live-hero mb-4">
            <div class="position-relative" style="z-index: 2;">
                <div class="row align-items-center g-4 mb-4">
                    <div class="position-relative" style="z-index: 2;">
                        <div class="row align-items-center g-4">
                            <div class="col-lg-8">
                                <span class="badge bg-white text-dark rounded-pill px-3 py-2 mb-3">
                                    <i class="bx bx-receipt me-1"></i>
                                    Pesanan Realtime
                                </span>

                                <h3 class="fw-bold text-white mb-2">
                                    Monitor Pesanan Paid
                                </h3>

                                <p class="text-white-50 mb-0">
                                    Pantau pesanan yang sudah dibayar, proses pesanan, dan validasi jika pesanan sudah
                                    diantarkan.
                                </p>
                            </div>

                            <div class="col-lg-4">
                                <div class="live-status-card">
                                    <div class="d-flex align-items-center justify-content-between gap-3">
                                        <div>
                                            <small class="live-status-label d-block mb-1">Status Monitoring</small>

                                            <div class="d-flex align-items-center gap-2">
                                                <span class="pulse-live"></span>
                                                <h5 class="fw-bold text-white mb-0">Live</h5>
                                            </div>

                                            <small class="live-status-label d-block mt-2">
                                                Update otomatis setiap 5 detik
                                            </small>
                                        </div>

                                        <div class="live-status-icon">
                                            <i class="bx bx-refresh"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- STATS --}}
                <div class="row g-4 mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card live-card h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <small class="text-muted fw-semibold">Sedang Diproses</small>
                                    <h3 class="fw-bold mb-0 mt-1" id="statProses">0</h3>
                                </div>

                                <div class="live-icon soft-warning">
                                    <i class="bx bx-loader-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card live-card h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <small class="text-muted fw-semibold">Selesai Diantarkan</small>
                                    <h3 class="fw-bold mb-0 mt-1" id="statSelesai">0</h3>
                                </div>

                                <div class="live-icon soft-success">
                                    <i class="bx bx-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card live-card h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <small class="text-muted fw-semibold">Paid Hari Ini</small>
                                    <h3 class="fw-bold mb-0 mt-1" id="statHariIni">0</h3>
                                </div>

                                <div class="live-icon soft-primary">
                                    <i class="bx bx-calendar-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card live-card h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <small class="text-muted fw-semibold">Omzet Paid Hari Ini</small>
                                    <h5 class="fw-bold mb-0 mt-1" id="statOmzet">Rp0</h5>
                                </div>

                                <div class="live-icon soft-danger">
                                    <i class="bx bx-money"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MAIN ORDER LIST --}}
                <div class="card live-card">
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <h5 class="fw-bold mb-1">Daftar Pesanan Paid</h5>
                                <small class="text-muted">
                                    Hanya menampilkan pesanan yang sudah dibayar dan siap diproses.
                                </small>
                            </div>

                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <button type="button" class="btn btn-outline-primary btn-modern"
                                    onclick="requestNotificationPermission()">
                                    <i class="bx bx-bell me-1"></i>
                                    Aktifkan Notifikasi
                                </button>

                                <button type="button" class="btn btn-primary btn-modern" onclick="fetchOrders(true)">
                                    <i class="bx bx-refresh me-1"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div id="orderList" class="d-flex flex-column gap-3">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status"></div>
                                <div class="text-muted mt-3">Memuat data pesanan...</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <script>
                const DATA_URL = "{{ route('pesanan.realtime.data') }}";
                const DONE_URL_TEMPLATE = "{{ url('/pesanan-realtime') }}/:id/selesai";
                const CSRF_TOKEN = "{{ csrf_token() }}";

                let firstLoad = true;
                let lastOrderId = Number(localStorage.getItem('last_paid_order_id') || 0);
                let toastTimeout = null;

                document.addEventListener('DOMContentLoaded', function() {
                    fetchOrders();
                    setInterval(fetchOrders, 5000);
                });

                async function fetchOrders(manual = false) {
                    try {
                        const response = await fetch(DATA_URL, {
                            headers: {
                                'Accept': 'application/json',
                            }
                        });

                        const data = await response.json();

                        updateStats(data.stats);
                        renderOrders(data.orders);

                        if (!firstLoad && data.latest_id > lastOrderId) {
                            showNewOrderNotification(data.orders[0]);
                        }

                        if (data.latest_id > lastOrderId) {
                            lastOrderId = data.latest_id;
                            localStorage.setItem('last_paid_order_id', lastOrderId);
                        }

                        firstLoad = false;

                        if (manual) {
                            showToast('Data pesanan berhasil diperbarui.');
                        }

                    } catch (error) {
                        console.error(error);
                        showToast('Gagal memuat data pesanan. Periksa koneksi atau route data.');
                    }
                }

                function updateStats(stats) {
                    document.getElementById('statProses').textContent = stats.proses ?? 0;
                    document.getElementById('statSelesai').textContent = stats.selesai ?? 0;
                    document.getElementById('statHariIni').textContent = stats.hari_ini ?? 0;
                    document.getElementById('statOmzet').textContent = stats.total_paid_hari_ini ?? 'Rp0';
                }

                function renderOrders(orders) {
                    const wrapper = document.getElementById('orderList');

                    if (!orders || orders.length === 0) {
                        wrapper.innerHTML = `
                    <div class="empty-state text-center">
                        <div class="live-icon soft-primary mx-auto mb-3">
                            <i class="bx bx-receipt"></i>
                        </div>

                        <h5 class="fw-bold mb-1">Belum ada pesanan paid</h5>
                        <p class="text-muted mb-0">
                            Pesanan yang sudah dibayar akan muncul otomatis di halaman ini.
                        </p>
                    </div>
                `;
                        return;
                    }

                    wrapper.innerHTML = orders.map(order => orderTemplate(order)).join('');
                }

                function orderTemplate(order) {
                    const isDone = order.status_order === 'selesai';

                    const orderNote = order.catatan ?
                        `
            <div class="order-note-box">
                <div class="fw-bold mb-1">
                    <i class="bx bx-note me-1"></i>
                    Catatan Pesanan
                </div>
                <div>${escapeHtml(order.catatan)}</div>
            </div>
        ` :
                        '';

                    const statusBadge = isDone ?
                        `<span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                <span class="status-dot dot-done"></span>
                Selesai Diantarkan
           </span>` :
                        `<span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">
                <span class="status-dot dot-process"></span>
                Sedang Dikerjakan
           </span>`;

                    const actionButton = isDone ?
                        `<button type="button" class="btn btn-outline-success btn-modern" disabled>
                <i class="bx bx-check-circle me-1"></i>
                Sudah Selesai
           </button>` :
                        `<button type="button" class="btn btn-success btn-modern" onclick="markAsDone(${order.id})">
                <i class="bx bx-check-double me-1"></i>
                Tandai Selesai
           </button>`;

                    const items = order.items && order.items.length > 0 ?
                        order.items.map(item => `
            <div class="menu-item-box">
                <div class="d-flex align-items-start justify-content-between gap-3">
                    <div>
                        <div class="fw-bold text-dark">
                            <i class="bx bx-bowl-hot text-primary me-1"></i>
                            ${escapeHtml(item.name)}
                        </div>

                        <div class="menu-price-info">
                            <i class="bx bx-money me-1"></i>
                            Harga: ${escapeHtml(item.price)} 
                            <span class="mx-1">•</span>
                            Subtotal: ${escapeHtml(item.subtotal)}
                        </div>

                        ${item.catatan_menu ? `
                                                                <div class="menu-note-box">
                                                                    <i class="bx bx-message-square-detail me-1"></i>
                                                                    <strong>Catatan menu:</strong> ${escapeHtml(item.catatan_menu)}
                                                                </div>
                                                            ` : ''}
                    </div>

                    <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                        x${item.qty}
                    </span>
                </div>
            </div>
        `).join('') :
                        `
            <div class="menu-item-box">
                <small class="text-muted">Menu pesanan tidak ditemukan.</small>
            </div>
        `;

                    return `
                <div class="order-live-item">
                    <div class="row g-4">

                        <div class="col-lg-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="live-icon soft-primary">
                                    <i class="bx bx-receipt"></i>
                                </div>

                                <div>
                                    <div class="order-code">
                                        #${escapeHtml(order.invoice)}
                                    </div>

                                    <div class="order-meta mt-2">
                                        <i class="bx bx-chair me-1"></i>
                                        Meja:
                                        <strong>${escapeHtml(order.meja)}</strong>
                                    </div>

                                    <div class="order-meta">
                                        <i class="bx bx-user me-1"></i>
                                        ${escapeHtml(order.customer)}
                                    </div>

                                    <div class="order-meta">
                                        <i class="bx bx-time-five me-1"></i>
                                        ${escapeHtml(order.created_at)}
                                    </div>

                                    <div class="mt-3">
    ${statusBadge}
</div>

${orderNote}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fw-bold mb-0">Menu Pesanan</h6>
                                <small class="text-muted">${order.items.length} item</small>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                ${items}
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="bg-light rounded-4 p-3 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <small class="text-muted d-block mb-1">Total Pembayaran</small>
                                    <h5 class="fw-bold text-success mb-0">${escapeHtml(order.total)}</h5>
                                </div>

                                <div class="mt-4">
                                    ${actionButton}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            `;
                }

                async function markAsDone(orderId) {
                    const url = DONE_URL_TEMPLATE.replace(':id', orderId);

                    try {
                        const response = await fetch(url, {
                            method: 'PATCH',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN,
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            showToast(data.message || 'Gagal mengubah status pesanan.');
                            return;
                        }

                        showToast(data.message || 'Pesanan berhasil ditandai selesai.');
                        fetchOrders();

                    } catch (error) {
                        console.error(error);
                        showToast('Terjadi kesalahan saat validasi pesanan.');
                    }
                }

                function requestNotificationPermission() {
                    if (!('Notification' in window)) {
                        showToast('Browser ini belum mendukung notifikasi.');
                        return;
                    }

                    Notification.requestPermission().then(permission => {
                        if (permission === 'granted') {
                            showToast('Notifikasi pesanan baru berhasil diaktifkan.');
                        } else {
                            showToast('Notifikasi belum diizinkan oleh browser.');
                        }
                    });
                }

                function showNewOrderNotification(order) {
                    const message = order ?
                        `Pesanan ${order.invoice} dari meja ${order.meja} sudah paid.` :
                        'Ada pesanan paid baru yang perlu diproses.';

                    showToast(message);
                    playNotificationSound();

                    if ('Notification' in window && Notification.permission === 'granted') {
                        new Notification('Pesanan Baru Masuk', {
                            body: message,
                            icon: "{{ asset('admin/assets/img/avatars/1.png') }}"
                        });
                    }
                }

                function showToast(message) {
                    const toast = document.getElementById('liveToast');
                    const toastMessage = document.getElementById('liveToastMessage');

                    toastMessage.textContent = message;
                    toast.style.display = 'block';

                    if (toastTimeout) {
                        clearTimeout(toastTimeout);
                    }

                    toastTimeout = setTimeout(() => {
                        hideToast();
                    }, 5000);
                }

                function hideToast() {
                    document.getElementById('liveToast').style.display = 'none';
                }

                function playNotificationSound() {
                    try {
                        const audioContext = new(window.AudioContext || window.webkitAudioContext)();
                        const oscillator = audioContext.createOscillator();
                        const gainNode = audioContext.createGain();

                        oscillator.connect(gainNode);
                        gainNode.connect(audioContext.destination);

                        oscillator.type = 'sine';
                        oscillator.frequency.value = 880;

                        gainNode.gain.setValueAtTime(0.08, audioContext.currentTime);
                        oscillator.start();

                        setTimeout(() => {
                            oscillator.stop();
                            audioContext.close();
                        }, 180);
                    } catch (error) {
                        console.log('Audio notification tidak aktif.');
                    }
                }

                function escapeHtml(value) {
                    if (value === null || value === undefined) {
                        return '';
                    }

                    return String(value)
                        .replaceAll('&', '&amp;')
                        .replaceAll('<', '&lt;')
                        .replaceAll('>', '&gt;')
                        .replaceAll('"', '&quot;')
                        .replaceAll("'", '&#039;');
                }
            </script>
        @endsection
