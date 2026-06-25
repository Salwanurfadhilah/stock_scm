<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Adjustment (Scrap) Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-sky-50/50 font-sans text-slate-700 flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-sky-100 flex flex-col justify-between hidden md:flex">
        <div class="p-6">
            <div class="flex items-center gap-3 text-sky-600 font-bold text-xl tracking-wide uppercase mb-8">
                <i class="fa-solid fa-boxes-stacked text-2xl"></i>
                <span>ScrapManager</span>
            </div>
            
            <nav class="space-y-1">
                <button onclick="switchTab('dashboard', this)" class="nav-item w-full flex items-center gap-3 px-4 py-3 bg-sky-100 text-sky-700 rounded-lg font-medium transition text-left">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i> Dashboard
                </button>
                <button onclick="switchTab('input', this)" class="nav-item w-full flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-sky-50 hover:text-sky-600 rounded-lg font-medium transition text-left">
                    <i class="fa-solid fa-file-circle-plus w-5 text-center"></i> Input Adjustment
                </button>
                <button onclick="switchTab('riwayat', this)" class="nav-item w-full flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-sky-50 hover:text-sky-600 rounded-lg font-medium transition text-left">
                    <i class="fa-solid fa-clipboard-list w-5 text-center"></i> Riwayat Scrap
                </button>
                <button onclick="switchTab('stok', this)" class="nav-item w-full flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-sky-50 hover:text-sky-600 rounded-lg font-medium transition text-left">
                    <i class="fa-solid fa-warehouse w-5 text-center"></i> Stok Utama
                </button>
            </nav>
        </div>
        
        <!-- FITUR BARU: ROLE SELECTOR -->
        <div class="p-6 border-t border-sky-100 bg-sky-50/30">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block"><i class="fa-solid fa-id-badge mr-1"></i> Akses Login Saat Ini</label>
            <select id="roleSelector" onchange="changeRole()" class="w-full bg-white border border-sky-200 text-sky-700 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block p-2.5 font-medium shadow-sm transition cursor-pointer">
                <option value="Supervisor Gudang">Supervisor Gudang</option>
                <option value="Project Manager">Project Manager</option>
                <option value="Head of Operations">Head of Operations</option>
                <option value="Business Controller">Business Controller</option>
            </select>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 flex flex-col overflow-y-auto relative">
        
        <header class="bg-white border-b border-sky-100 px-8 py-4 flex justify-between items-center sticky top-0 z-10">
            <div>
                <h1 id="page-title" class="text-xl font-bold text-slate-800">Dashboard Penyesuaian Stok (Scrap)</h1>
                <p id="page-subtitle" class="text-sm text-slate-400">Pantau dan kelola produk yang afkir/rusak secara real-time.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:block text-right mr-4 border-r border-sky-100 pr-4">
                    <p class="text-xs text-slate-400">Selamat datang,</p>
                    <p id="topbar-role" class="text-sm font-bold text-sky-700">Supervisor Gudang</p>
                </div>
                <button onclick="switchTab('input', document.querySelectorAll('.nav-item')[1])" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg font-medium text-sm shadow-sm flex items-center gap-2 transition">
                    <i class="fa-solid fa-plus"></i> Tambah Penyesuaian
                </button>
            </div>
        </header>

        <div class="p-8 space-y-6">
            
            <!-- HALAMAN 1: DASHBOARD -->
            <section id="dashboard" class="page-section block">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-xl border border-sky-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-400 font-medium">Total Item Scrap</p>
                            <h3 id="kpi-total" class="text-2xl font-bold text-slate-800 mt-1">0 <span class="text-sm font-normal text-slate-400">Unit</span></h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-sky-50 flex items-center justify-center text-sky-600 text-xl">
                            <i class="fa-solid fa-dumpster"></i>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-sky-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-400 font-medium">Estimasi Kerugian</p>
                            <h3 id="kpi-loss" class="text-2xl font-bold text-rose-600 mt-1">Rp 0</h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600 text-xl">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-sky-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-400 font-medium">Menunggu Persetujuan</p>
                            <h3 id="kpi-pending" class="text-2xl font-bold text-amber-600 mt-1">0 <span class="text-sm font-normal text-slate-400">Dokumen</span></h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 text-xl">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-sky-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-400 font-medium">Akurasi Stok Gudang</p>
                            <h3 class="text-2xl font-bold text-emerald-600 mt-1">98.4%</h3>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-sky-100 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-sky-50 flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Aktivitas Scrap Terbaru</h2>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-sky-50/70 text-sky-900 font-semibold text-sm border-b border-sky-100">
                                    <th class="p-4 whitespace-nowrap">ID Transaksi</th>
                                    <th class="p-4 whitespace-nowrap">Tanggal & Pelapor</th>
                                    <th class="p-4 whitespace-nowrap">SKU / Nama Produk</th>
                                    <th class="p-4 text-center whitespace-nowrap">Jumlah</th>
                                    <th class="p-4 whitespace-nowrap">Status</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard-tbody" class="divide-y divide-sky-50 text-sm">
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- HALAMAN 2: INPUT ADJUSTMENT -->
            <section id="input" class="page-section hidden">
                <div class="bg-white rounded-xl border border-sky-100 shadow-sm p-6 max-w-3xl">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Form Laporan Barang Rusak (Scrap)</h2>
                    <form onsubmit="createData(event)" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Kode SKU / Produk</label>
                                <input id="form-sku" type="text" required class="w-full border border-sky-200 rounded-lg px-4 py-2 focus:outline-none focus:border-sky-500" placeholder="Contoh: BRG-001">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Jumlah Rusak</label>
                                <input id="form-qty" type="number" required min="1" class="w-full border border-sky-200 rounded-lg px-4 py-2 focus:outline-none focus:border-sky-500" placeholder="0">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Alasan / Penyebab</label>
                            <select id="form-reason" required class="w-full border border-sky-200 rounded-lg px-4 py-2 focus:outline-none focus:border-sky-500 bg-white">
                                <option value="">Pilih Alasan...</option>
                                <option value="Cacat Produksi">Cacat Produksi</option>
                                <option value="Rusak saat pengiriman">Rusak saat pengiriman (Mishandling)</option>
                                <option value="Kedaluwarsa">Kedaluwarsa (Expired)</option>
                                <option value="Faktor Bencana">Faktor Cuaca/Bencana</option>
                            </select>
                        </div>
                        <div class="pt-4 flex justify-end gap-3">
                            <button type="button" onclick="switchTab('dashboard', document.querySelectorAll('.nav-item')[0])" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition"><i class="fa-solid fa-save mr-2"></i>Simpan Laporan</button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- HALAMAN 3: RIWAYAT SCRAP -->
            <section id="riwayat" class="page-section hidden">
                <div class="bg-white rounded-xl border border-sky-100 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-sky-50 flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Semua Riwayat Scrap</h2>
                            <p class="text-sm text-slate-400">Manajemen persetujuan dan penghapusan data.</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-sky-50/70 text-sky-900 font-semibold text-sm border-b border-sky-100">
                                    <th class="p-4 whitespace-nowrap">ID Transaksi</th>
                                    <th class="p-4 whitespace-nowrap">Tanggal & Pelapor</th>
                                    <th class="p-4 whitespace-nowrap">SKU Produk</th>
                                    <th class="p-4 text-center whitespace-nowrap">Jumlah</th>
                                    <th class="p-4 whitespace-nowrap">Alasan</th>
                                    <th class="p-4 whitespace-nowrap">Status</th>
                                    <th class="p-4 text-center whitespace-nowrap">Aksi (CRUD)</th>
                                </tr>
                            </thead>
                            <tbody id="riwayat-tbody" class="divide-y divide-sky-50 text-sm">
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- HALAMAN 4: STOK UTAMA -->
            <section id="stok" class="page-section hidden">
                <div class="bg-white rounded-xl border border-sky-100 shadow-sm p-12 text-center">
                    <div class="w-16 h-16 bg-sky-50 text-sky-400 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-warehouse"></i>
                    </div>
                    <h2 class="text-xl font-bold text-slate-700">Halaman Stok Utama Gudang</h2>
                    <p class="text-slate-500 mt-2 mb-6">Daftar master stok barang yang terhubung langsung dengan sistem inventaris utama.</p>
                </div>
            </section>

        </div>
    </main>

    <!-- SCRIPT LOGIKA CRUD & ROLE MANAGEMENT -->
    <script>
        // 1. MANAJEMEN ROLE & INISIALISASI DATA
        let dbName = 'scrapData_v2';
        let records = JSON.parse(localStorage.getItem(dbName));
        let activeRole = localStorage.getItem('userRole') || 'Supervisor Gudang';

        // Setel dropdown dan topbar sesuai role terakhir yang disimpan
        document.getElementById('roleSelector').value = activeRole;
        document.getElementById('topbar-role').innerText = activeRole;

        if (!records) {
            records = [
                { id: generateID(), date: '25 Juni 2026', createdBy: 'Project Manager', sku: 'BRG-ELC-009', qty: 45, reason: 'Cacat Produksi', status: 'Disetujui' },
                { id: generateID(), date: '24 Juni 2026', createdBy: 'Supervisor Gudang', sku: 'BRG-PAK-021', qty: 120, reason: 'Rusak saat pengiriman', status: 'Pending' }
            ];
            saveData();
        }

        function saveData() {
            localStorage.setItem(dbName, JSON.stringify(records));
        }

        function generateID() {
            return '#ADJ-' + Math.floor(1000 + Math.random() * 9000);
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        // FUNGSI GANTI ROLE
        function changeRole() {
            activeRole = document.getElementById('roleSelector').value;
            localStorage.setItem('userRole', activeRole);
            document.getElementById('topbar-role').innerText = activeRole;
            // Tampilkan notifikasi agar user tahu role-nya berubah
            alert(`Berhasil berganti akses menjadi: ${activeRole}`);
            renderData();
        }

        // 2. READ: RENDER TABEL & KPI
        function renderData() {
            const dashTbody = document.getElementById('dashboard-tbody');
            const riwayatTbody = document.getElementById('riwayat-tbody');
            
            dashTbody.innerHTML = '';
            riwayatTbody.innerHTML = '';
            
            let totalItem = 0;
            let pendingDoc = 0;

            const reversedRecords = [...records].reverse();

            reversedRecords.forEach((item, index) => {
                totalItem += parseInt(item.qty);
                if (item.status === 'Pending') pendingDoc += 1;

                let statusBadge = item.status === 'Disetujui' 
                    ? `<span class="px-2 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-medium">Disetujui</span>`
                    : `<span class="px-2 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-medium">Pending</span>`;

                // Render Dashboard
                if (index < 5) {
                    dashTbody.innerHTML += `
                        <tr class="hover:bg-sky-50/30 transition">
                            <td class="p-4 font-medium text-sky-700">${item.id}</td>
                            <td class="p-4">
                                <span class="text-slate-600">${item.date}</span><br>
                                <span class="text-[11px] font-medium text-sky-600 px-1.5 py-0.5 bg-sky-50 rounded">${item.createdBy || 'Unknown'}</span>
                            </td>
                            <td class="p-4 font-medium text-slate-800">${item.sku}</td>
                            <td class="p-4 text-center font-semibold">${item.qty}</td>
                            <td class="p-4">${statusBadge}</td>
                        </tr>
                    `;
                }

                // Render Riwayat
                riwayatTbody.innerHTML += `
                    <tr class="hover:bg-sky-50/30 transition">
                        <td class="p-4 font-medium text-sky-700">${item.id}</td>
                        <td class="p-4 leading-tight">
                            <span class="text-slate-600">${item.date}</span><br>
                            <span class="text-[11px] font-medium text-sky-600 px-1.5 py-0.5 bg-sky-50 rounded mt-1 inline-block">${item.createdBy || 'Unknown'}</span>
                        </td>
                        <td class="p-4 font-medium">${item.sku}</td>
                        <td class="p-4 text-center font-semibold">${item.qty}</td>
                        <td class="p-4 text-xs text-slate-500">${item.reason}</td>
                        <td class="p-4">${statusBadge}</td>
                        <td class="p-4 text-center">
                            ${item.status === 'Pending' 
                                ? `<button onclick="updateStatus('${item.id}')" class="text-emerald-500 hover:text-emerald-700 mx-1" title="Setujui (Approval)"><i class="fa-solid fa-check-circle"></i></button>`
                                : `<button disabled class="text-slate-300 mx-1"><i class="fa-solid fa-check-circle"></i></button>`
                            }
                            <button onclick="deleteData('${item.id}')" class="text-rose-400 hover:text-rose-600 mx-1" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('kpi-total').innerHTML = `${totalItem} <span class="text-sm font-normal text-slate-400">Unit</span>`;
            document.getElementById('kpi-pending').innerHTML = `${pendingDoc} <span class="text-sm font-normal text-slate-400">Dokumen</span>`;
            document.getElementById('kpi-loss').innerText = formatRupiah(totalItem * 50000);
        }

        // 3. CREATE: FUNGSI SIMPAN DATA DARI FORM
        function createData(event) {
            event.preventDefault(); 
            
            const sku = document.getElementById('form-sku').value;
            const qty = document.getElementById('form-qty').value;
            const reason = document.getElementById('form-reason').value;
            const today = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

            records.push({
                id: generateID(),
                date: today,
                createdBy: activeRole, // Menyimpan role pembuat dokumen
                sku: sku,
                qty: qty,
                reason: reason,
                status: 'Pending' 
            });

            saveData(); 
            renderData(); 

            event.target.reset(); 
            alert('Laporan berhasil disimpan oleh: ' + activeRole);
            
            switchTab('dashboard', document.querySelectorAll('.nav-item')[0]);
        }

        // 4. UPDATE: FUNGSI SETUJUI DENGAN VALIDASI ROLE
        function updateStatus(id) {
            // Validasi Role (Hanya level manajerial ke atas yang boleh approve)
            if (activeRole !== 'Head of Operations' && activeRole !== 'Business Controller') {
                alert('AKSES DITOLAK: Maaf, hanya "Head of Operations" atau "Business Controller" yang memiliki wewenang untuk menyetujui dokumen Scrap.');
                return; // Batalkan proses
            }

            if(confirm('Apakah Anda yakin ingin menyetujui dokumen ' + id + '?')) {
                const index = records.findIndex(item => item.id === id);
                if(index !== -1) {
                    records[index].status = 'Disetujui';
                    saveData();
                    renderData(); 
                }
            }
        }

        // 5. DELETE: FUNGSI HAPUS DATA DENGAN VALIDASI ROLE
        function deleteData(id) {
            // Validasi Role
            if (activeRole !== 'Head of Operations' && activeRole !== 'Business Controller') {
                alert('AKSES DITOLAK: Maaf, hak akses untuk menghapus data hanya dimiliki oleh "Head of Operations" dan "Business Controller".');
                return; // Batalkan proses
            }

            if(confirm('Perhatian: Apakah Anda yakin ingin menghapus permanen data ' + id + '?')) {
                records = records.filter(item => item.id !== id);
                saveData();
                renderData(); 
            }
        }

        // FUNGSI NAVIGASI TAB
        function switchTab(tabId, clickedElement) {
            const pages = document.querySelectorAll('.page-section');
            pages.forEach(page => {
                page.classList.add('hidden');
                page.classList.remove('block');
            });

            document.getElementById(tabId).classList.remove('hidden');
            document.getElementById(tabId).classList.add('block');

            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.classList.remove('bg-sky-100', 'text-sky-700');
                item.classList.add('text-slate-500', 'hover:bg-sky-50', 'hover:text-sky-600');
            });

            clickedElement.classList.remove('text-slate-500', 'hover:bg-sky-50', 'hover:text-sky-600');
            clickedElement.classList.add('bg-sky-100', 'text-sky-700');

            const titleElement = document.getElementById('page-title');
            const subtitleElement = document.getElementById('page-subtitle');

            switch(tabId) {
                case 'dashboard':
                    titleElement.innerText = 'Dashboard Penyesuaian Stok (Scrap)';
                    subtitleElement.innerText = 'Pantau dan kelola produk yang afkir/rusak secara real-time.';
                    break;
                case 'input':
                    titleElement.innerText = 'Input Penyesuaian (Scrap) Baru';
                    subtitleElement.innerText = 'Laporkan barang rusak untuk menyesuaikan jumlah stok utama.';
                    break;
                case 'riwayat':
                    titleElement.innerText = 'Riwayat Dokumen Scrap';
                    subtitleElement.innerText = 'Manajemen persetujuan dan penghapusan data.';
                    break;
                case 'stok':
                    titleElement.innerText = 'Data Stok Utama';
                    subtitleElement.innerText = 'Pantau kuantitas barang riil yang tersedia di gudang saat ini.';
                    break;
            }
        }

        // Panggil render saat pertama kali dimuat
        renderData();
    </script>
</body>
</html>