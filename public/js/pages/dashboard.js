/**
 * dashboard.js — DebugTIK Portal Guru
 * ─────────────────────────────────────────────────────────────────────────────
 * Semua logika interaksi halaman dashboard:
 *   - Tab navigation (switchTab)
 *   - Dropdown sidebar kuis (toggleKuisDropdown)
 *   - Modal materi CRUD (toggleModal, openEditorModal, handleMateriSubmit)
 *   - Attachment materi (upload, preview, delete)
 *   - Modal lab CRUD (toggleLabModal, openEditLabModal, handleLabSubmit)
 *   - Pengaturan profil (simpanProfil, gantiPassword)
 *   - Real-time duplicate check (checkMateriDuplicate)
 *
 * Bergantung pada: public/js/app.js (showToast, debounceCheck, setFieldState, togglePw)
 */

const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

/** Helper header JSON untuk fetch. */
function apiHeaders() {
    return { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF };
}

// ─── DROPDOWN KELOLA KUIS (sidebar) ──────────────────────────────────────────
function toggleKuisDropdown() {
    const dropdown = document.getElementById('kuis-nav-dropdown');
    const chevron  = document.getElementById('kuis-nav-chevron');
    const btn      = document.getElementById('btn-kuis-dropdown');
    const isOpen   = dropdown.classList.contains('flex');

    if (isOpen) {
        dropdown.classList.replace('flex', 'hidden');
        chevron.style.transform = '';
        btn.classList.remove('bg-surface-container-high', 'text-on-surface');
    } else {
        dropdown.classList.replace('hidden', 'flex');
        chevron.style.transform = 'rotate(180deg)';
        btn.classList.add('bg-surface-container-high', 'text-on-surface');
    }
}

// Stub backward-compat
function toggleMateriDropdown() {}
function toggleMateriSub() {}

// ─── TAB NAVIGATION ───────────────────────────────────────────────────────────
function switchTab(tabName) {
    document.querySelectorAll('[data-tab]').forEach(t => {
        t.classList.remove('bg-primary-container', 'text-on-primary-container', 'font-semibold');
        t.classList.add('text-on-surface-variant', 'hover:bg-surface-container-high', 'hover:text-on-surface');
    });

    const activeTab = document.querySelector(`[data-tab="${tabName}"]`);
    if (activeTab) {
        activeTab.classList.remove('text-on-surface-variant', 'hover:bg-surface-container-high', 'hover:text-on-surface');
        activeTab.classList.add('bg-primary-container', 'text-on-primary-container', 'font-semibold');
    }

    document.querySelectorAll('.view-section').forEach(v => v.classList.add('hidden'));

    const viewId = tabName === 'kelola-materi' ? 'view-kelola-materi' : `view-${tabName}`;
    document.getElementById(viewId)?.classList.remove('hidden');

    const url = new URL(window.location);
    url.searchParams.set('tab', tabName);
    window.history.pushState({}, '', url);
}

// Inisialisasi tab saat load
document.querySelectorAll('[data-tab]').forEach(tab => {
    tab.addEventListener('click', function (e) {
        e.preventDefault();
        switchTab(this.getAttribute('data-tab'));
    });
});

const tabParam = new URLSearchParams(window.location.search).get('tab');
switchTab(tabParam || 'dashboard');

// ─── ESTIMASI WAKTU — TAK TERBATAS ──────────────────────────────────────────
function toggleEstimasiTakTerbatas(value) {
    const input = document.getElementById('input-estimasi-waktu');
    if (!input) { return; }
    if (value === 'tak-terbatas') {
        input.disabled = true;
        input.value    = 0;
        input.removeAttribute('required');
    } else {
        input.disabled = false;
        input.value    = input.value === '0' ? 45 : input.value;
        input.setAttribute('required', '');
    }
}

// ─── MODAL MATERI ─────────────────────────────────────────────────────────────
function toggleModal(open) {
    const modal = document.getElementById('materi-modal');
    if (!modal) { return; }
    if (open) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    } else {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('modal-title').innerText = '+ Tambah Materi Belajar Baru';
        document.getElementById('input-materi-db-id').value = '';
        document.getElementById('materi-form').reset();
        // Reset estimasi waktu
        const selectTak = document.getElementById('input-estimasi-tak-terbatas');
        if (selectTak) { selectTak.value = 'menit'; toggleEstimasiTakTerbatas('menit'); }
        _materiPendingFiles = [];
        renderMateriFilePreview();
        const saved = document.getElementById('materi-saved-attachments');
        if (saved) { saved.innerHTML = ''; saved.classList.add('hidden'); }
    }
}

function openEditorModal(dbId, idMateri, title, category, level, time, deskripsi) {
    document.getElementById('modal-title').innerText      = 'Edit Materi: ' + idMateri;
    document.getElementById('input-materi-db-id').value   = dbId;
    document.getElementById('input-id-materi').value      = idMateri;
    document.getElementById('input-judul-materi').value   = title;
    document.getElementById('input-kategori').value       = category;
    document.getElementById('input-level-materi').value   = level;
    document.getElementById('input-deskripsi').value      = deskripsi;

    // Set estimasi waktu — 0 berarti tak terbatas
    const selectTak = document.getElementById('input-estimasi-tak-terbatas');
    if (parseInt(time) === 0) {
        selectTak.value = 'tak-terbatas';
        toggleEstimasiTakTerbatas('tak-terbatas');
    } else {
        selectTak.value = 'menit';
        toggleEstimasiTakTerbatas('menit');
        document.getElementById('input-estimasi-waktu').value = time;
    }

    _materiPendingFiles = [];
    renderMateriFilePreview();
    fetch(`/api/attachment/materi/${dbId}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
        .then(r => r.json())
        .then(d => { if (d.success) { renderSavedAttachments(d.data, dbId); } });
    toggleModal(true);
}

// ─── DUPLICATE CHECK ──────────────────────────────────────────────────────────
function checkMateriDuplicate(field, value, excludeId, inputEl) {
    if (!value) { setFieldState(inputEl, '', ''); return; }
    setFieldState(inputEl, 'loading', 'Memeriksa...');
    const params = new URLSearchParams({ field, value });
    if (excludeId) { params.append('exclude_id', excludeId); }
    fetch(`/api/kelola-materi/check?${params}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
        .then(r => r.json())
        .then(d => {
            if (d.duplicate) {
                setFieldState(inputEl, 'error', field === 'id_materi' ? '✕ ID sudah digunakan' : '✕ Judul sudah ada');
            } else {
                setFieldState(inputEl, 'ok', '✓ Tersedia');
            }
        })
        .catch(() => setFieldState(inputEl, '', ''));
}

// ─── SUBMIT MATERI ────────────────────────────────────────────────────────────
function handleMateriSubmit(e) {
    e.preventDefault();
    const dbId   = document.getElementById('input-materi-db-id').value;
    const isEdit = dbId !== '';

    const hasError = ['input-id-materi', 'input-judul-materi'].some(id => {
        const el = document.getElementById(id);
        return el && el.classList.contains('ring-error');
    });
    if (hasError) { showToast('Perbaiki duplikasi terlebih dahulu', 'error'); return; }

    const body = {
        id_materi:      document.getElementById('input-id-materi').value,
        judul:          document.getElementById('input-judul-materi').value,
        kategori:       document.getElementById('input-kategori').value,
        level:          document.getElementById('input-level-materi').value,
        estimasi_waktu: document.getElementById('input-estimasi-waktu').value,
        deskripsi:      document.getElementById('input-deskripsi').value,
    };

    const url    = isEdit ? `/api/kelola-materi/${dbId}` : '/api/kelola-materi';
    const method = isEdit ? 'PUT' : 'POST';

    fetch(url, { method, headers: apiHeaders(), body: JSON.stringify(body) })
        .then(r => r.json())
        .then(async data => {
            if (data.success) {
                const savedId = data.data?.id ?? dbId;
                if (savedId && _materiPendingFiles.length) {
                    await uploadMateriAttachments(savedId);
                }
                showToast(data.message || 'Materi berhasil disimpan');
                toggleModal(false);
                setTimeout(() => location.reload(), 800);
            } else {
                const errors = data.errors
                    ? Object.values(data.errors).flat().join(', ')
                    : (data.message || 'Gagal menyimpan');
                showToast(errors, 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'));
}

function deleteMateri(dbId) {
    if (!confirm('Hapus materi ini? Semua kuis dan lab terkait akan ikut terhapus.')) { return; }
    fetch(`/api/kelola-materi/${dbId}`, { method: 'DELETE', headers: apiHeaders() })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Materi berhasil dihapus');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(data.message || 'Gagal menghapus', 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'));
}

// ─── ATTACHMENT MATERI ────────────────────────────────────────────────────────
let _materiPendingFiles = [];

function handleMateriDrop(e) {
    e.preventDefault();
    document.getElementById('materi-drop-zone').classList.remove('border-primary', 'bg-primary/5');
    handleMateriFileSelect(e.dataTransfer.files);
}

function handleMateriFileSelect(files) {
    Array.from(files).forEach(f => _materiPendingFiles.push(f));
    renderMateriFilePreview();
}

function renderMateriFilePreview() {
    const container = document.getElementById('materi-file-preview');
    if (!container) { return; }
    if (!_materiPendingFiles.length) { container.classList.add('hidden'); return; }
    container.classList.remove('hidden');
    container.classList.add('flex');
    container.innerHTML = _materiPendingFiles.map((f, i) => `
        <div class="flex items-center gap-space-sm px-space-sm py-space-xs rounded-xl bg-surface-container border border-outline-variant/20">
            <span class="material-symbols-outlined text-primary text-[18px]">${f.type.startsWith('image/') ? 'image' : 'picture_as_pdf'}</span>
            <span class="font-body-sm text-body-sm text-on-surface flex-1 truncate">${f.name}</span>
            <span class="font-label-badge text-label-badge text-outline">${(f.size / 1024 / 1024).toFixed(1)} MB</span>
            <button type="button" onclick="removeMateriFile(${i})"
                class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors">
                <span class="material-symbols-outlined text-[14px]">close</span>
            </button>
        </div>`).join('');
}

function removeMateriFile(idx) {
    _materiPendingFiles.splice(idx, 1);
    renderMateriFilePreview();
}

function renderSavedAttachments(attachments) {
    const container = document.getElementById('materi-saved-attachments');
    if (!container) { return; }
    if (!attachments.length) { container.classList.add('hidden'); return; }
    container.classList.remove('hidden');
    container.classList.add('flex');
    container.innerHTML = `
        <span class="font-label-badge text-label-badge uppercase text-outline mb-space-2xs">File tersimpan</span>
        ${attachments.map(a => `
        <div class="flex items-center gap-space-sm px-space-sm py-space-xs rounded-xl bg-surface-container border border-outline-variant/20" id="saved-att-${a.id}">
            <span class="material-symbols-outlined text-[18px] ${a.is_pdf ? 'text-error' : 'text-primary'}">${a.icon}</span>
            <a href="${a.url}" target="_blank" class="font-body-sm text-body-sm text-primary hover:underline flex-1 truncate">${a.nama_file}</a>
            <span class="font-label-badge text-label-badge text-outline">${a.ukuran_readable}</span>
            <button type="button" onclick="deleteAttachment(${a.id}, 'saved-att-${a.id}')"
                class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors">
                <span class="material-symbols-outlined text-[14px]">delete</span>
            </button>
        </div>`).join('')}`;
}

async function uploadMateriAttachments(materiId) {
    if (!_materiPendingFiles.length) { return; }
    const fd = new FormData();
    _materiPendingFiles.forEach(f => fd.append('files[]', f));
    fd.append('_token', CSRF);
    try {
        await fetch(`/api/attachment/materi/${materiId}`, { method: 'POST', body: fd });
    } catch (e) { /* non-critical */ }
    _materiPendingFiles = [];
    renderMateriFilePreview();
}

function deleteAttachment(id, elId) {
    if (!confirm('Hapus file ini?')) { return; }
    fetch(`/api/attachment/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' },
    })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                document.getElementById(elId)?.remove();
                showToast('File dihapus');
            }
        });
}

// ─── MODAL LAB PRAKTIK ────────────────────────────────────────────────────────
function toggleLabModal(open, materiId = null) {
    const modal = document.getElementById('lab-modal');
    if (!modal) { return; }
    if (open) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        if (materiId) { document.getElementById('lab-materi-id').value = materiId; }
    } else {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('lab-db-id').value = '';
        document.getElementById('lab-modal-title').innerText = 'Tambah Lab Praktik';
        document.getElementById('lab-form').reset();
    }
}

function openEditLabModal(lab) {
    document.getElementById('lab-modal-title').innerText  = 'Edit Lab: ' + lab.id_lab;
    document.getElementById('lab-db-id').value            = lab.id;
    document.getElementById('lab-materi-id').value        = lab.materi_id;
    document.getElementById('lab-id-lab').value           = lab.id_lab;
    document.getElementById('lab-kesulitan').value        = lab.tingkat_kesulitan;
    document.getElementById('lab-deskripsi').value        = lab.deskripsi_kasus;
    document.getElementById('lab-kode-awal').value        = lab.kode_soal_awal;
    document.getElementById('lab-bug-target').value       = lab.bug_target;
    document.getElementById('lab-poin-max').value         = lab.poin_max;
    document.getElementById('lab-solusi').value           = lab.solusi_fix;
    toggleLabModal(true);
}

function handleLabSubmit(e) {
    e.preventDefault();
    const dbId   = document.getElementById('lab-db-id').value;
    const isEdit = dbId !== '';

    const body = {
        materi_id:         document.getElementById('lab-materi-id').value,
        id_lab:            document.getElementById('lab-id-lab').value,
        tingkat_kesulitan: document.getElementById('lab-kesulitan').value,
        deskripsi_kasus:   document.getElementById('lab-deskripsi').value,
        kode_soal_awal:    document.getElementById('lab-kode-awal').value,
        bug_target:        document.getElementById('lab-bug-target').value,
        poin_max:          document.getElementById('lab-poin-max').value,
        solusi_fix:        document.getElementById('lab-solusi').value,
    };

    const url    = isEdit ? `/api/lab/${dbId}` : '/api/lab';
    const method = isEdit ? 'PUT' : 'POST';

    fetch(url, { method, headers: apiHeaders(), body: JSON.stringify(body) })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || 'Lab berhasil disimpan');
                toggleLabModal(false);
                setTimeout(() => location.reload(), 800);
            } else {
                const errors = data.errors
                    ? Object.values(data.errors).flat().join(', ')
                    : (data.message || 'Gagal menyimpan');
                showToast(errors, 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'));
}

function deleteLab(dbId) {
    if (!confirm('Hapus lab praktik ini?')) { return; }
    fetch(`/api/lab/${dbId}`, { method: 'DELETE', headers: apiHeaders() })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Lab berhasil dihapus');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(data.message || 'Gagal menghapus', 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'));
}

// ─── PENGATURAN PROFIL ────────────────────────────────────────────────────────
function previewFoto(input) {
    const file = input.files[0];
    if (!file) { return; }
    const reader = new FileReader();
    reader.onload = e => {
        const wrapper = document.getElementById('foto-wrapper');
        const icon    = document.getElementById('foto-icon');
        if (icon) { icon.remove(); }
        let img = document.getElementById('foto-preview');
        if (!img) {
            img = document.createElement('img');
            img.id        = 'foto-preview';
            img.className = 'w-full h-full object-cover';
            wrapper.appendChild(img);
        }
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function simpanProfil(e) {
    e.preventDefault();
    const btn = document.getElementById('btn-simpan-profil');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">sync</span> Menyimpan...';

    const fd = new FormData();
    fd.append('_token',        CSRF);
    fd.append('name',          document.getElementById('pg-name').value);
    fd.append('nip',           document.getElementById('pg-nip').value);
    fd.append('sekolah',       document.getElementById('pg-sekolah').value);
    fd.append('mata_pelajaran',document.getElementById('pg-mapel').value);
    fd.append('no_hp',         document.getElementById('pg-nohp').value);
    fd.append('tahun_ajaran',  document.getElementById('pg-tahun').value);
    fd.append('semester',      document.getElementById('pg-semester').value);
    const fotoInput = document.getElementById('input-foto');
    if (fotoInput.files[0]) { fd.append('foto', fotoInput.files[0]); }

    fetch('/pengaturan/profil', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Profil berhasil disimpan');
                const nameEl = document.getElementById('display-name');
                if (nameEl) { nameEl.textContent = data.name; }
            } else {
                const err = data.errors
                    ? Object.values(data.errors).flat().join(', ')
                    : (data.message || 'Gagal');
                showToast(err, 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">save</span> Simpan Profil';
        });
}

function gantiPassword(e) {
    e.preventDefault();
    const lama   = document.getElementById('pw-lama').value;
    const baru   = document.getElementById('pw-baru').value;
    const konfirm = document.getElementById('pw-konfirm').value;

    if (baru !== konfirm) { showToast('Konfirmasi password tidak cocok', 'error'); return; }
    if (baru.length < 8)  { showToast('Password baru minimal 8 karakter', 'error'); return; }

    const btn = document.getElementById('btn-ganti-pw');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">sync</span> Mengubah...';

    fetch('/pengaturan/password', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ current_password: lama, password: baru, password_confirmation: konfirm }),
    })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Password berhasil diubah');
                document.getElementById('form-password').reset();
            } else {
                showToast(data.message || 'Gagal mengubah password', 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">lock_reset</span> Ubah Password';
        });
}

// Stub — fitur kuis dipindah ke halaman /kuis/{materi}
function toggleOpsiJawaban() {}
toggleOpsiJawaban();

// ─── EVENT LISTENERS: real-time duplicate check ───────────────────────────────
document.getElementById('input-id-materi')?.addEventListener('input', function () {
    const excludeId = document.getElementById('input-materi-db-id').value;
    debounceCheck(() => checkMateriDuplicate('id_materi', this.value.trim(), excludeId, this));
});
document.getElementById('input-judul-materi')?.addEventListener('input', function () {
    const excludeId = document.getElementById('input-materi-db-id').value;
    debounceCheck(() => checkMateriDuplicate('judul', this.value.trim(), excludeId, this));
});
