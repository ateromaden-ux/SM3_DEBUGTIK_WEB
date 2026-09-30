/**
 * kuis-editor.js — DebugTIK Kelola Soal Kuis
 * ─────────────────────────────────────────────────────────────────────────────
 * Semua logika interaksi halaman editor soal:
 *   - Tipe soal (setTipe, toggleOpsiKunci)
 *   - Form soal (newSoal, resetForm, loadSoalToForm, handleSimpan)
 *   - CRUD soal (deleteSoal, updateSoalData, updateCounter, renumberCards)
 *   - Pengaturan kuis (saveSettings, toggleSettings)
 *   - Publish / Unpublish (publishKuis, unpublishKuis, _updatePublishUI)
 *   - Attachment soal (upload, preview, delete)
 *   - Gambar opsi jawaban (handleOpsiImage, uploadOpsiImages, loadOpsiImages)
 *   - Sidebar dropdown (toggleKuisDropdown)
 *
 * Bergantung pada: public/js/app.js (showToast, debounceCheck, setFieldState)
 * Data dari server: CSRF, MATERI_ID, MATERI_ID_PAGE, soalData
 *   → di-inject via <script> di kuis/index.blade.php sebelum file ini dimuat.
 */

// ─── TIPE SOAL ────────────────────────────────────────────────────────────────
function setTipe(tipe) {
    document.getElementById('f-tipe').value = tipe;

    document.querySelectorAll('.tipe-btn').forEach(btn => {
        const isActive = btn.dataset.tipe === tipe;
        btn.classList.toggle('bg-secondary', isActive);
        btn.classList.toggle('text-on-secondary', isActive);
        btn.classList.toggle('border-secondary', isActive);
        btn.classList.toggle('font-semibold', isActive);
        btn.classList.toggle('text-on-surface-variant', !isActive);
        btn.classList.toggle('border-outline-variant/40', !isActive);
    });

    const opsiSection  = document.getElementById('opsi-section');
    const essaySection = document.getElementById('essay-section');
    const hint         = document.getElementById('opsi-hint');
    const isMulti      = tipe === 'multiple_answer';
    const isEssay      = tipe === 'essay';

    opsiSection.classList.toggle('hidden', isEssay);
    opsiSection.classList.toggle('flex', !isEssay);
    essaySection.classList.toggle('hidden', !isEssay);
    essaySection.classList.toggle('flex', isEssay);

    ['a', 'b', 'c', 'd'].forEach(h => {
        const badge = document.getElementById(`badge-${h}`);
        if (isMulti) { badge.classList.remove('rounded-xl'); badge.classList.add('rounded-md'); }
        else          { badge.classList.add('rounded-xl');    badge.classList.remove('rounded-md'); }
    });

    if (hint) {
        hint.innerText = isMulti
            ? 'Klik tile untuk pilih (boleh lebih dari satu jawaban benar)'
            : 'Klik tile untuk tandai jawaban benar';
    }

    clearKunci();
}

// Alias backward-compat
function onTipeChange() { setTipe(document.getElementById('f-tipe').value); }

function clearKunci() {
    ['a', 'b', 'c', 'd'].forEach(h => _deselect(h));
    document.getElementById('f-kunci').value = '';
}

function _select(hl) {
    const tile   = document.getElementById(`tile-${hl}`);
    const badge  = document.getElementById(`badge-${hl}`);
    const letter = badge.querySelector('.opsi-badge-letter');
    const check  = badge.querySelector('.opsi-badge-check');
    tile.classList.add('border-tertiary', 'bg-tertiary/5', 'shadow-md');
    tile.classList.remove('border-outline-variant/30');
    badge.classList.add('bg-tertiary', 'border-tertiary');
    badge.classList.remove('border-outline-variant/40');
    if (letter) { letter.classList.add('hidden'); }
    if (check)  { check.classList.remove('hidden'); }
}

function _deselect(hl) {
    const tile   = document.getElementById(`tile-${hl}`);
    const badge  = document.getElementById(`badge-${hl}`);
    const letter = badge?.querySelector('.opsi-badge-letter');
    const check  = badge?.querySelector('.opsi-badge-check');
    tile?.classList.remove('border-tertiary', 'bg-tertiary/5', 'shadow-md');
    tile?.classList.add('border-outline-variant/30');
    badge?.classList.remove('bg-tertiary', 'border-tertiary');
    badge?.classList.add('border-outline-variant/40');
    if (letter) { letter.classList.remove('hidden'); }
    if (check)  { check.classList.add('hidden'); }
}

function toggleOpsiKunci(huruf) {
    const tipe = document.getElementById('f-tipe').value;
    const hl   = huruf.toLowerCase();
    const tile = document.getElementById(`tile-${hl}`);
    const isOn = tile.classList.contains('border-tertiary');

    if (tipe !== 'multiple_answer') {
        clearKunci();
        _select(hl);
        document.getElementById('f-kunci').value = JSON.stringify([huruf]);
    } else {
        if (isOn) { _deselect(hl); } else { _select(hl); }
        const selected = ['A', 'B', 'C', 'D'].filter(h => {
            const t = document.getElementById(`tile-${h.toLowerCase()}`);
            return t && t.classList.contains('border-tertiary');
        });
        document.getElementById('f-kunci').value = JSON.stringify(selected);
    }
}

// ─── PANEL KIRI: highlight soal aktif ─────────────────────────────────────────
function setActiveCard(id) {
    document.querySelectorAll('.soal-item').forEach(el => {
        el.classList.remove('border-secondary', 'bg-secondary/5');
        el.classList.add('border-transparent');
    });
    if (id) {
        const el = document.querySelector(`.soal-item[data-id="${id}"]`);
        if (el) {
            el.classList.remove('border-transparent');
            el.classList.add('border-secondary', 'bg-secondary/5');
        }
    }
}

// ─── LOAD SOAL KE FORM ────────────────────────────────────────────────────────
function loadSoalToForm(id) {
    const soal = soalData[id];
    if (!soal) { return; }

    showFormWrapper();
    setActiveCard(id);

    document.getElementById('f-db-id').value      = soal.id;
    document.getElementById('f-id-soal').value     = soal.id_soal;
    const disp = document.getElementById('f-id-soal-display');
    if (disp) { disp.textContent = soal.id_soal; }
    document.getElementById('f-pertanyaan').value  = soal.pertanyaan;
    document.getElementById('f-poin').value        = soal.poin;
    document.getElementById('btn-hapus').classList.remove('hidden');
    document.getElementById('btn-hapus').classList.add('flex');

    setTipe(soal.tipe);
    loadSoalAttachments(soal.id);
    loadOpsiImages(soal.id);

    if (soal.tipe !== 'essay') {
        const opsi = Array.isArray(soal.opsi_jawaban)
            ? soal.opsi_jawaban
            : (soal.opsi_jawaban ? JSON.parse(soal.opsi_jawaban) : []);
        const penj = Array.isArray(soal.penjelasan_opsi)
            ? soal.penjelasan_opsi
            : (soal.penjelasan_opsi ? JSON.parse(soal.penjelasan_opsi) : []);
        ['a', 'b', 'c', 'd'].forEach((h, i) => {
            document.getElementById(`opsi-${h}`).value = opsi[i] || '';
            document.getElementById(`penj-${h}`).value = penj[i] || '';
        });

        const kunci = Array.isArray(soal.kunci_jawaban)
            ? soal.kunci_jawaban
            : (soal.kunci_jawaban ? JSON.parse(soal.kunci_jawaban) : []);
        const hurufIdx = { A: 0, B: 1, C: 2, D: 3 };
        kunci.forEach(k => {
            const huruf = ['A', 'B', 'C', 'D'].find(h => h === k || opsi[hurufIdx[h]] === k);
            if (huruf) { _select(huruf.toLowerCase()); }
        });
        document.getElementById('f-kunci').value = JSON.stringify(kunci);
    } else {
        document.getElementById('f-essay-panduan').value = soal.kunci_jawaban?.[0] || '';
    }
}

function newSoal() {
    resetForm();
    showFormWrapper();
    setActiveCard(null);
    document.getElementById('f-pertanyaan').focus();
}

function resetForm() {
    document.getElementById('soal-form').reset();
    document.getElementById('f-db-id').value   = '';
    document.getElementById('f-id-soal').value  = '';
    const disp = document.getElementById('f-id-soal-display');
    if (disp) { disp.textContent = 'auto'; }
    document.getElementById('f-kunci').value   = '';
    document.getElementById('f-poin').value    = '25';
    document.getElementById('btn-hapus').classList.add('hidden');
    document.getElementById('btn-hapus').classList.remove('flex');
    document.querySelectorAll('.dup-hint').forEach(el => { el.textContent = ''; });
    clearSoalAttachments();
    clearOpsiImages();
    setTipe('pilihan_ganda');
}

function showFormWrapper() {
    document.getElementById('form-empty-state').classList.add('hidden');
    document.getElementById('type-toolbar').classList.remove('hidden');
    document.getElementById('type-toolbar').classList.add('flex');
    const w = document.getElementById('soal-form-wrapper');
    w.classList.remove('hidden');
    w.classList.add('flex');
}

// ─── SIMPAN SOAL ──────────────────────────────────────────────────────────────
function handleSimpan(e) {
    e.preventDefault();
    const dbId   = document.getElementById('f-db-id').value;
    const isEdit = dbId !== '';
    const tipe   = document.getElementById('f-tipe').value;

    let opsi = null, penj = null, kunci = [''];

    if (tipe !== 'essay') {
        opsi = ['a', 'b', 'c', 'd'].map(h => document.getElementById(`opsi-${h}`).value.trim()).filter(v => v);
        penj = ['a', 'b', 'c', 'd'].map(h => document.getElementById(`penj-${h}`).value.trim());

        const kunciRaw = document.getElementById('f-kunci').value;
        try { kunci = JSON.parse(kunciRaw); } catch (_) { kunci = kunciRaw ? [kunciRaw] : []; }

        if (!kunci.length)  { showToast('Pilih minimal satu jawaban benar', 'error'); return; }
        if (opsi.length < 2) { showToast('Isi minimal 2 opsi jawaban', 'error'); return; }

        const hurufIdx = { A: 0, B: 1, C: 2, D: 3 };
        kunci = kunci.map(k => opsi[hurufIdx[k]] ?? k);
    } else {
        const panduan = document.getElementById('f-essay-panduan').value.trim();
        kunci = panduan ? [panduan] : [''];
    }

    const body = {
        materi_id:       MATERI_ID,
        tipe,
        pertanyaan:      document.getElementById('f-pertanyaan').value,
        opsi_jawaban:    opsi,
        kunci_jawaban:   kunci,
        penjelasan_opsi: penj,
        poin:            document.getElementById('f-poin').value,
    };

    const url    = isEdit ? `/api/kuis/${dbId}` : '/api/kuis';
    const method = isEdit ? 'PUT' : 'POST';
    const btn    = document.getElementById('btn-simpan');
    btn.disabled = true;

    fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify(body),
    })
        .then(r => r.json())
        .then(async data => {
            if (data.success) {
                showToast(isEdit ? 'Soal diperbarui' : 'Soal disimpan: ' + data.data.id_soal);
                if (_soalPendingFiles.length)                                { await uploadSoalAttachments(data.data.id); }
                if (['a', 'b', 'c', 'd'].some(h => _opsiPendingImages[h])) { await uploadOpsiImages(data.data.id); }
                updateSoalData(data.data, isEdit);
                if (!isEdit) {
                    const disp = document.getElementById('f-id-soal-display');
                    if (disp) { disp.textContent = data.data.id_soal; }
                    newSoal();
                }
            } else {
                const err = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Gagal');
                showToast(err, 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'))
        .finally(() => { btn.disabled = false; });
}

// ─── UPDATE PANEL KIRI ────────────────────────────────────────────────────────
function updateSoalData(soal, isEdit) {
    soalData[soal.id] = soal;

    const tipeBadge = {
        pilihan_ganda:  ['bg-primary/10 text-primary', 'PG'],
        multiple_answer:['bg-secondary/10 text-secondary', 'Multi'],
        essay:          ['bg-tertiary/10 text-tertiary', 'Essay'],
    };
    const [badgeClass, badgeLabel] = tipeBadge[soal.tipe] ?? tipeBadge['pilihan_ganda'];

    if (isEdit) {
        const card = document.querySelector(`.soal-item[data-id="${soal.id}"]`);
        if (card) {
            card.querySelector('p').innerText = soal.pertanyaan;
            card.querySelector('.font-code-inline').innerText = soal.id_soal;
            card.querySelectorAll('.font-label-badge')[0].innerText = soal.poin + ' poin';
        }
    } else {
        document.getElementById('empty-state')?.remove();
        const list  = document.getElementById('soal-list');
        const count = list.querySelectorAll('.soal-item').length + 1;
        const div   = document.createElement('div');
        div.className = 'soal-item rounded-xl p-space-sm bg-surface-container-low hover:bg-surface-container cursor-pointer transition-colors border-2 border-transparent';
        div.setAttribute('data-id', soal.id);
        div.setAttribute('onclick', `loadSoalToForm(${soal.id})`);
        div.innerHTML = `
            <div class="flex items-start justify-between gap-2">
                <div class="flex items-center gap-space-xs flex-shrink-0">
                    <span class="w-6 h-6 rounded-md bg-surface-container-high flex items-center justify-center font-code-inline text-code-inline font-bold text-on-surface-variant">${count}</span>
                    <span class="px-1.5 py-0.5 rounded-md ${badgeClass} font-label-badge text-label-badge font-bold">${badgeLabel}</span>
                </div>
                <button onclick="event.stopPropagation(); deleteSoal(${soal.id}, this)"
                    class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors flex-shrink-0">
                    <span class="material-symbols-outlined text-[14px]">delete</span>
                </button>
            </div>
            <p class="font-body-sm text-body-sm text-on-surface mt-space-xs line-clamp-2">${soal.pertanyaan}</p>
            <div class="flex items-center justify-between mt-space-xs">
                <span class="font-code-inline text-code-inline text-outline">${soal.id_soal}</span>
                <span class="font-label-badge text-label-badge text-on-surface-variant">${soal.poin} poin</span>
            </div>`;
        list.appendChild(div);
    }

    updateCounter();
}

function updateCounter() {
    const count     = document.querySelectorAll('.soal-item').length;
    const totalPoin = Object.values(soalData).reduce((s, d) => s + (parseInt(d.poin) || 0), 0);
    document.getElementById('soal-counter').innerText  = count + ' soal';
    document.getElementById('total-poin').innerText    = totalPoin;

    const kkmRow = document.getElementById('kkm-row');
    const poinEl = document.getElementById('poin-kkm');
    const kkmVal = parseInt(document.getElementById('s-kkm')?.value) || 0;
    if (poinEl && kkmRow && !kkmRow.classList.contains('hidden')) {
        poinEl.textContent = '≥ ' + Math.round(totalPoin * kkmVal / 100) + ' poin';
    }
}

// ─── HAPUS SOAL ───────────────────────────────────────────────────────────────
function deleteSoal(id) {
    if (!confirm('Hapus soal ini?')) { return; }
    fetch(`/api/kuis/${id}`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Soal dihapus');
                delete soalData[id];
                document.querySelector(`.soal-item[data-id="${id}"]`)?.remove();
                updateCounter();
                renumberCards();
                if (document.getElementById('f-db-id').value == id) { resetForm(); }
            } else {
                showToast(data.message || 'Gagal menghapus', 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'));
}

function deleteSoalFromForm() {
    const id = document.getElementById('f-db-id').value;
    if (!id) { return; }
    deleteSoal(id);
}

function renumberCards() {
    document.querySelectorAll('.soal-item').forEach((el, i) => {
        const numEl = el.querySelector('.w-6.h-6');
        if (numEl) { numEl.innerText = i + 1; }
    });
}

// ─── SETTINGS PANEL ───────────────────────────────────────────────────────────
function toggleSettings() {
    const panel   = document.getElementById('settings-panel');
    const summary = document.getElementById('settings-summary');
    const chevron = document.getElementById('settings-chevron');
    const isOpen  = panel.classList.contains('flex');

    if (isOpen) {
        panel.classList.replace('flex', 'hidden');
        summary?.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
    } else {
        panel.classList.replace('hidden', 'flex');
        summary?.classList.add('hidden');
        chevron.style.transform = '';
    }
}

function saveSettings(e) {
    e.preventDefault();
    const btn = document.getElementById('btn-save-settings');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">sync</span> Menyimpan...';

    const body = {
        materi_id:      document.getElementById('s-materi-id').value,
        id_kuis:        document.getElementById('s-id-kuis').value.trim(),
        waktu_per_soal: document.getElementById('s-waktu').value,
        satuan_waktu:   document.getElementById('s-satuan').value,
        kkm:            document.getElementById('s-kkm').value,
    };

    fetch('/api/kuis/settings', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify(body),
    })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Pengaturan kuis disimpan');
                const s = data.data;

                document.getElementById('settings-summary').innerHTML = `
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-outline text-[14px]">badge</span>
                        <span class="font-code-inline text-code-inline text-on-surface font-semibold">${s.id_kuis}</span>
                    </div>
                    <div class="flex items-center gap-space-2xs text-on-surface-variant">
                        <span class="material-symbols-outlined text-[14px]">timer</span>
                        <span class="font-body-sm text-body-sm">${s.waktu_per_soal} ${s.satuan_waktu}</span>
                    </div>
                    <div class="flex items-center gap-space-2xs text-on-surface-variant">
                        <span class="material-symbols-outlined text-[14px]">school</span>
                        <span class="font-body-sm text-body-sm">KKM ${s.kkm}%</span>
                    </div>`;
                document.getElementById('settings-summary').className =
                    'flex items-center gap-space-md px-space-md pb-space-sm';

                const statusBadge = document.querySelector('#btn-settings-toggle .rounded-full');
                if (statusBadge) {
                    statusBadge.textContent = 'Tersimpan';
                    statusBadge.className   = 'px-2 py-0.5 rounded-full bg-tertiary/10 text-tertiary font-label-badge text-label-badge font-semibold';
                }

                const poinEl   = document.getElementById('poin-kkm');
                const kkmRow   = document.getElementById('kkm-row');
                const kkmLabel = document.getElementById('kkm-label');
                if (poinEl) {
                    const totalPoin = parseInt(document.getElementById('total-poin').textContent) || 0;
                    poinEl.textContent = '≥ ' + Math.round(totalPoin * s.kkm / 100) + ' poin';
                }
                if (kkmLabel) { kkmLabel.textContent = 'Lulus jika ≥ KKM ' + s.kkm + '%'; }
                if (kkmRow)   { kkmRow.classList.remove('hidden'); }

                const btnSoal = document.getElementById('btn-soal-baru');
                if (btnSoal) {
                    btnSoal.disabled = false;
                    btnSoal.classList.remove('opacity-50', 'cursor-not-allowed');
                    btnSoal.title = '';
                }

                toggleSettings();
            } else {
                const err = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Gagal');
                showToast(err, 'error');
            }
        })
        .catch(err => showToast('Error: ' + err.message, 'error'))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">save</span> Simpan Pengaturan';
        });
}

// ─── PUBLISH / UNPUBLISH ──────────────────────────────────────────────────────
function publishKuis() {
    if (!confirm('Publish kuis ini? Siswa akan bisa mengerjakan kuis setelah dipublish.')) { return; }
    const btn = document.getElementById('btn-publish');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">sync</span> Memproses...';

    fetch(`/api/kuis/publish/${MATERI_ID_PAGE}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                _updatePublishUI('published', data.published_at);
            } else {
                showToast(data.message || 'Gagal publish', 'error');
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">publish</span> Publish Kuis';
            }
        })
        .catch(err => {
            showToast('Error: ' + err.message, 'error');
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">publish</span> Publish Kuis';
        });
}

function unpublishKuis() {
    if (!confirm('Tarik kuis ke Draft? Siswa tidak akan bisa mengerjakan kuis selama dalam Draft.')) { return; }
    const btn = document.getElementById('btn-publish');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">sync</span> Memproses...';

    fetch(`/api/kuis/unpublish/${MATERI_ID_PAGE}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                _updatePublishUI('draft', null);
            } else {
                showToast(data.message || 'Gagal', 'error');
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">unpublished</span> Tarik ke Draft';
            }
        })
        .catch(err => {
            showToast('Error: ' + err.message, 'error');
            btn.disabled = false;
        });
}

function _updatePublishUI(status) {
    const isPublished   = status === 'published';
    const btn           = document.getElementById('btn-publish');
    const badge         = document.getElementById('status-badge');
    const settingsBadge = document.getElementById('settings-status-badge');
    const btnSoal       = document.getElementById('btn-soal-baru');
    const btnSave       = document.getElementById('btn-save-settings');
    const inputs        = document.querySelectorAll('#s-id-kuis, #s-waktu, #s-satuan, #s-kkm');

    if (isPublished) {
        btn.className = 'flex items-center gap-space-xs px-space-md py-space-xs rounded-xl border-2 border-error/40 text-error hover:bg-error-container font-body-sm text-body-sm font-semibold transition-all';
        btn.setAttribute('onclick', 'unpublishKuis()');
        btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">unpublished</span> Tarik ke Draft';
    } else {
        btn.className = 'flex items-center gap-space-xs px-space-md py-space-xs rounded-xl bg-tertiary text-on-tertiary font-body-sm text-body-sm font-semibold hover:opacity-90 transition-opacity shadow-sm';
        btn.setAttribute('onclick', 'publishKuis()');
        btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">publish</span> Publish Kuis';
    }
    btn.disabled = false;

    if (badge) {
        badge.innerHTML = isPublished
            ? '<span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span><span class="font-label-badge text-label-badge text-tertiary font-bold">PUBLISHED</span>'
            : '<span class="w-2 h-2 rounded-full bg-outline"></span><span class="font-label-badge text-label-badge text-outline font-bold">DRAFT</span>';
        badge.className = isPublished
            ? 'flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-tertiary/10 border border-tertiary/30'
            : 'flex items-center gap-space-xs px-space-sm py-space-2xs rounded-full bg-outline/10 border border-outline/20';
    }

    if (settingsBadge) {
        settingsBadge.textContent = isPublished ? 'Published' : 'Draft';
        settingsBadge.className   = isPublished
            ? 'px-2 py-0.5 rounded-full bg-tertiary/10 text-tertiary font-label-badge text-label-badge font-semibold'
            : 'px-2 py-0.5 rounded-full bg-outline/10 text-outline font-label-badge text-label-badge font-semibold';
    }

    inputs.forEach(el => { el.disabled = isPublished; });
    if (btnSave) { btnSave.disabled = isPublished; }

    if (btnSoal) {
        btnSoal.disabled = isPublished;
        btnSoal.classList.toggle('opacity-50', isPublished);
        btnSoal.classList.toggle('cursor-not-allowed', isPublished);
        btnSoal.title = isPublished ? 'Tarik ke Draft untuk menambah soal' : '';
    }

    document.querySelectorAll('.soal-item button').forEach(b => {
        b.disabled = isPublished;
        b.classList.toggle('opacity-30', isPublished);
    });

    const btnHapus  = document.getElementById('btn-hapus');
    const btnSimpan = document.getElementById('btn-simpan');
    if (btnHapus)  { btnHapus.disabled  = isPublished; }
    if (btnSimpan) { btnSimpan.disabled = isPublished; }
}

// ─── DROPDOWN SIDEBAR ─────────────────────────────────────────────────────────
function toggleKuisDropdown() {
    const dropdown = document.getElementById('kuis-nav-dropdown');
    const chevron  = document.getElementById('kuis-nav-chevron');
    const isOpen   = dropdown.classList.contains('flex');
    if (isOpen) {
        dropdown.classList.replace('flex', 'hidden');
        chevron.style.transform = '';
    } else {
        dropdown.classList.replace('hidden', 'flex');
        chevron.style.transform = 'rotate(180deg)';
    }
}

function toggleMateriDropdown() {}
function toggleMateriSub() {}

// ─── GAMBAR OPSI JAWABAN ──────────────────────────────────────────────────────
const _opsiPendingImages = { a: null, b: null, c: null, d: null };
const _opsiSavedImages   = { a: null, b: null, c: null, d: null };

function handleOpsiImage(huruf, input) {
    const file = input.files[0];
    if (!file) { return; }
    if (!file.type.startsWith('image/'))  { showToast('Hanya file gambar yang diizinkan', 'error'); return; }
    if (file.size > 5 * 1024 * 1024)     { showToast('Ukuran gambar maksimal 5 MB', 'error'); return; }
    _opsiPendingImages[huruf] = file;
    const reader = new FileReader();
    reader.onload = e => _showOpsiImagePreview(huruf, e.target.result);
    reader.readAsDataURL(file);
}

function _showOpsiImagePreview(huruf, src) {
    const wrapper = document.getElementById(`opsi-img-preview-${huruf}`);
    const img     = document.getElementById(`opsi-img-${huruf}`);
    const label   = document.getElementById(`opsi-foto-label-${huruf}`);
    img.src       = src;
    wrapper.classList.remove('hidden');
    if (label) { label.textContent = 'Ganti'; }
}

function removeOpsiImage(huruf) {
    _opsiPendingImages[huruf] = null;
    _opsiSavedImages[huruf]   = null;
    const wrapper = document.getElementById(`opsi-img-preview-${huruf}`);
    const img     = document.getElementById(`opsi-img-${huruf}`);
    const label   = document.getElementById(`opsi-foto-label-${huruf}`);
    const input   = document.getElementById(`opsi-file-${huruf}`);
    img.src       = '';
    wrapper.classList.add('hidden');
    if (label) { label.textContent = 'Foto'; }
    if (input) { input.value = ''; }
}

async function uploadOpsiImages(soalId) {
    for (const huruf of ['a', 'b', 'c', 'd']) {
        const file = _opsiPendingImages[huruf];
        if (!file) { continue; }
        const ext     = file.name.split('.').pop();
        const renamed = new File([file], `opsi-${huruf.toUpperCase()}-${Date.now()}.${ext}`, { type: file.type });
        const fd = new FormData();
        fd.append('files[]', renamed);
        fd.append('_token', CSRF);
        try { await fetch(`/api/attachment/soal/${soalId}`, { method: 'POST', body: fd }); } catch (_) {}
        _opsiPendingImages[huruf] = null;
    }
}

function loadOpsiImages(soalId) {
    ['a', 'b', 'c', 'd'].forEach(h => { _opsiSavedImages[h] = null; removeOpsiImage(h); });
    fetch(`/api/attachment/soal/${soalId}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
        .then(r => r.json())
        .then(data => {
            if (!data.success) { return; }
            data.data.forEach(att => {
                const match = att.nama_file.match(/^opsi-([ABCD])-/i);
                if (match) {
                    const huruf = match[1].toLowerCase();
                    _opsiSavedImages[huruf] = att.url;
                    _showOpsiImagePreview(huruf, att.url);
                }
            });
        });
}

function clearOpsiImages() {
    ['a', 'b', 'c', 'd'].forEach(h => removeOpsiImage(h));
}

// ─── ATTACHMENT SOAL ──────────────────────────────────────────────────────────
let _soalPendingFiles = [];

function handleSoalDrop(e) {
    e.preventDefault();
    document.getElementById('soal-drop-zone').classList.remove('border-secondary', 'bg-secondary/5');
    handleSoalFileSelect(e.dataTransfer.files);
}

function handleSoalFileSelect(files) {
    Array.from(files).forEach(f => _soalPendingFiles.push(f));
    renderSoalFilePreview();
}

function renderSoalFilePreview() {
    const container = document.getElementById('soal-file-preview');
    if (!_soalPendingFiles.length) { container.classList.add('hidden'); return; }
    container.classList.remove('hidden');
    container.classList.add('flex');
    container.innerHTML = _soalPendingFiles.map((f, i) => `
        <div class="flex items-center gap-space-xs px-space-sm py-space-xs rounded-xl bg-surface-container border border-outline-variant/20">
            ${f.type.startsWith('image/')
                ? `<img src="${URL.createObjectURL(f)}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0"/>`
                : `<span class="material-symbols-outlined text-error text-[24px] flex-shrink-0">picture_as_pdf</span>`
            }
            <span class="font-body-sm text-body-sm text-on-surface flex-1 truncate">${f.name}</span>
            <span class="font-label-badge text-label-badge text-outline flex-shrink-0">${(f.size / 1024 / 1024).toFixed(1)} MB</span>
            <button type="button" onclick="removeSoalFile(${i})"
                class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors flex-shrink-0">
                <span class="material-symbols-outlined text-[14px]">close</span>
            </button>
        </div>`).join('');
}

function removeSoalFile(idx) {
    _soalPendingFiles.splice(idx, 1);
    renderSoalFilePreview();
}

function renderSoalSavedAttachments(attachments) {
    const container = document.getElementById('soal-saved-attachments');
    if (!attachments?.length) { container.classList.add('hidden'); return; }
    container.classList.remove('hidden');
    container.classList.add('flex');
    container.innerHTML = attachments.map(a => `
        <div class="flex items-center gap-space-xs px-space-sm py-space-xs rounded-xl bg-surface-container border border-outline-variant/20 group" id="soal-att-${a.id}">
            ${a.is_image
                ? `<img src="${a.url}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0 cursor-pointer" onclick="window.open('${a.url}','_blank')"/>`
                : `<span class="material-symbols-outlined text-error text-[24px] flex-shrink-0">picture_as_pdf</span>`
            }
            <a href="${a.url}" target="_blank" class="font-body-sm text-body-sm text-primary hover:underline flex-1 truncate">${a.nama_file}</a>
            <span class="font-label-badge text-label-badge text-outline flex-shrink-0">${a.ukuran_readable}</span>
            <button type="button" onclick="deleteSoalAttachment(${a.id})"
                class="w-6 h-6 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-error-container hover:text-error transition-colors flex-shrink-0 opacity-0 group-hover:opacity-100">
                <span class="material-symbols-outlined text-[14px]">delete</span>
            </button>
        </div>`).join('');
}

async function uploadSoalAttachments(soalId) {
    if (!_soalPendingFiles.length) { return; }
    const fd = new FormData();
    _soalPendingFiles.forEach(f => fd.append('files[]', f));
    fd.append('_token', CSRF);
    const res  = await fetch(`/api/attachment/soal/${soalId}`, { method: 'POST', body: fd });
    const data = await res.json();
    if (data.success) { renderSoalSavedAttachments(data.data); }
    _soalPendingFiles = [];
    renderSoalFilePreview();
}

function deleteSoalAttachment(id) {
    if (!confirm('Hapus file ini?')) { return; }
    fetch(`/api/attachment/${id}`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    })
        .then(r => r.json())
        .then(d => {
            if (d.success) { document.getElementById(`soal-att-${id}`)?.remove(); showToast('File dihapus'); }
        });
}

function loadSoalAttachments(soalId) {
    fetch(`/api/attachment/soal/${soalId}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
        .then(r => r.json())
        .then(d => { if (d.success) { renderSoalSavedAttachments(d.data); } });
}

function clearSoalAttachments() {
    _soalPendingFiles = [];
    renderSoalFilePreview();
    const c = document.getElementById('soal-saved-attachments');
    if (c) { c.innerHTML = ''; c.classList.add('hidden'); }
}

// ─── INIT ─────────────────────────────────────────────────────────────────────
onTipeChange();
