// resources/js/user_management.js

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-input-group input');
    const tableRows = document.querySelectorAll('.dir-table tbody tr');
    const tabButtons = document.querySelectorAll('.nav-segment .btn-tab');
    const roleDropdownOpts = document.querySelectorAll('.filter-role-opt');

    // ==========================================
    // 1. FITUR LIVE SEARCH KLIEN
    // ==========================================
    if (searchInput) {
        searchInput.addEventListener('keyup', function (e) {
            const keyword = e.target.value.toLowerCase();
            tableRows.forEach(row => {
                if (row.querySelector('.text-center')) return; // Lewati row data kosong
                
                const nameEl = row.querySelector('.fw-semibold');
                const nikEl = row.querySelector('.font-monospace');
                
                const name = nameEl ? nameEl.textContent.toLowerCase() : '';
                const nik = nikEl ? nikEl.textContent.toLowerCase() : '';
                
                if (name.includes(keyword) || nik.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // ==========================================
    // 2. FILTER DROPDOWN INTERACTION
    // ==========================================
    roleDropdownOpts.forEach(opt => {
        opt.addEventListener('click', function (e) {
            e.preventDefault();
            const targetRole = this.getAttribute('data-role');
            
            tableRows.forEach(row => {
                if (row.querySelector('.text-center')) return; // Lewati row data kosong
                
                if (targetRole === 'all') {
                    row.style.display = '';
                    return;
                }
                
                // Cek kolom ke-4 (Role)
                const roleTd = row.querySelector('td:nth-child(4)');
                const roleText = roleTd ? roleTd.textContent.trim() : '';
                
                if (roleText.includes(targetRole)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // ==========================================
    // 3. INTERAKTIVITAS TAB SWITCHER
    // ==========================================
    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ==========================================
    // 4. AJAX CRUD INTERACTION (UPDATE & DELETE)
    // ==========================================
    
    // Ambil token CSRF Laravel dari meta tag atau elemen input terdekat
    const getCsrfToken = () => {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        return tokenMeta ? tokenMeta.getAttribute('content') : document.querySelector('input[name="_token"]')?.value;
    };

    // --- PROSES DELETE VIA AJAX ---
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Cegah reload halaman bawaan form
            
            if (!confirm('Are you sure you want to delete this user?')) return;

            const row = this.closest('tr');
            const actionUrl = this.getAttribute('action');

            fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (response.ok) {
                    // Beri efek transisi memudar sebelum baris dihapus dari DOM
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        row.remove();
                        // Muat ulang halaman jika diperlukan agar sinkronisasi pagination real dari Laravel tetap tepat
                        window.location.reload();
                    }, 300);
                } else {
                    return response.json().then(err => {
                        alert(err.message || 'Gagal menghapus user. Silakan coba lagi.');
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi sistem.');
            });
        });
    });

    // --- PROSES UPDATE VIA AJAX ---
    const editModals = document.querySelectorAll('.modal[id^="editUserModal"]');
    editModals.forEach(modal => {
        const form = modal.querySelector('form');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Blokir submit reload tradisional

            const actionUrl = this.getAttribute('action');
            const formData = new FormData(this);
            const userId = modal.id.replace('editUserModal', '');
            const targetRow = document.querySelector(`tr:has(#editUserModal${userId})`) || form.closest('tr');

            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                // Sembunyikan modal Bootstrap secara programmatic
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) bsModal.hide();

                // Jika element row ditemukan, perbarui isi data kolomnya secara instan
                if (targetRow) {
                    const nameInput = form.querySelector('input[name="name"]').value;
                    const nikInput = form.querySelector('input[name="nik"]').value;
                    const roleSelect = form.querySelector('select[name="role"]').value;

                    // Update Teks Nama & Avatar Singkatan
                    const nameDisplay = targetRow.querySelector('.fw-semibold');
                    if (nameDisplay) nameDisplay.textContent = nameInput;

                    const avatarDisplay = targetRow.querySelector('.user-avatar');
                    if (avatarDisplay) avatarDisplay.textContent = nameInput.substring(0, 2).toUpperCase();

                    // Update Teks NIK (Kolom ke-3)
                    const nikTd = targetRow.querySelector('td:nth-child(3) span');
                    if (nikTd) nikTd.textContent = nikInput;

                    // Update Badge Role secara dinamis (Kolom ke-4) murni menggunakan struktur Administrator
                    const roleTd = targetRow.querySelector('td:nth-child(4)');
                    if (roleTd) {
                        roleTd.innerHTML = `
                            <span class="badge-role admin" style="white-space: nowrap;">
                                <i class="fa-solid fa-user-gear" style="font-size: 10px; margin-right: 6px;"></i>${roleSelect}
                            </span>
                        `;
                    }
                    
                    // Muat ulang halaman agar komponen visual widget snapshot & role distribution di kanan ikut ter-update datanya secara valid
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memperbarui data user.');
            });
        });
    });
});