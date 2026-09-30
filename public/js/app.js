/**
 * app.js — DebugTIK shared utilities
 * ─────────────────────────────────────────────────────────────────────────────
 * Fungsi-fungsi yang dipakai di lebih dari satu halaman:
 *   - showToast        : notifikasi sukses/error
 *   - debounceCheck    : delay input validation
 *   - setFieldState    : styling input valid/invalid/loading
 *   - togglePw         : toggle visibility password
 *
 * Dimuat sebelum script halaman spesifik.
 */

// ─── TOAST NOTIFICATION ──────────────────────────────────────────────────────
/**
 * Tampilkan toast notifikasi sementara.
 * @param {string} message
 * @param {'success'|'error'} type
 */
function showToast(message, type = 'success') {
    const existing = document.getElementById('toast');
    if (existing) existing.remove();

    const colors = type === 'success'
        ? 'bg-tertiary-container text-on-tertiary-container'
        : 'bg-error-container text-on-error-container';
    const icon = type === 'success' ? 'check_circle' : 'error';

    const toast = document.createElement('div');
    toast.id = 'toast';
    toast.className = `fixed bottom-6 right-6 z-[200] flex items-center gap-2 px-4 py-3 rounded-xl shadow-lg font-body-sm text-body-sm font-medium ${colors} transition-all`;
    toast.innerHTML = `<span class="material-symbols-outlined text-[18px]">${icon}</span>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// ─── DEBOUNCE ─────────────────────────────────────────────────────────────────
let _globalDebounceTimer = null;

/**
 * Jalankan fungsi setelah delay (untuk real-time duplicate check).
 * @param {Function} fn
 * @param {number} ms
 */
function debounceCheck(fn, ms = 500) {
    clearTimeout(_globalDebounceTimer);
    _globalDebounceTimer = setTimeout(fn, ms);
}

// ─── FIELD STATE ─────────────────────────────────────────────────────────────
/**
 * Set state visual sebuah input field.
 * @param {HTMLElement} inputEl
 * @param {'ok'|'error'|'loading'|''} state
 * @param {string} msg
 */
function setFieldState(inputEl, state, msg = '') {
    let hint = inputEl.parentElement.querySelector('.dup-hint');
    if (!hint) {
        hint = document.createElement('span');
        hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs';
        inputEl.parentElement.appendChild(hint);
    }
    inputEl.classList.remove('ring-2', 'ring-error', 'ring-tertiary');
    hint.textContent = msg;
    if (state === 'error') {
        inputEl.classList.add('ring-2', 'ring-error');
        hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs text-error';
    } else if (state === 'ok') {
        inputEl.classList.add('ring-2', 'ring-tertiary');
        hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs text-tertiary';
    } else {
        hint.className = 'dup-hint font-body-sm text-body-sm mt-space-2xs text-outline';
    }
}

// ─── PASSWORD TOGGLE ─────────────────────────────────────────────────────────
/**
 * Toggle visibility input password.
 * @param {string} inputId
 * @param {string} iconId
 */
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input || !icon) { return; }
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}
