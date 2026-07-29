/* ==========================================
   HERBI Sense — Main JS
   Toast, Modal, Confirm, Auto-calc
   ========================================== */

// ===== TOAST =====
function toast(msg) {
  // Mobile
  const t = document.getElementById('toast');
  if (t) {
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2200);
  }
  // Desktop
  const dt = document.getElementById('desktop-toast');
  if (dt) {
    dt.textContent = msg;
    dt.classList.add('show');
    setTimeout(() => dt.classList.remove('show'), 2200);
  }
}

// ===== MODAL CRUD =====
function openModal(mode, blockId) {
  const overlay = document.getElementById('modal-overlay');
  const title   = document.getElementById('modal-title');
  if (!overlay) return;

  // Reset form
  document.getElementById('f-block-code').value   = '';
  document.getElementById('f-afdeling').value     = 'OF';
  document.getElementById('f-luas').value         = '';
  document.getElementById('f-dosis').value        = '';
  document.getElementById('f-gulma').value        = '';
  document.getElementById('f-kerapatan').value    = 'Sedang';
  document.getElementById('f-status').value       = 'Belum Selesai';
  document.getElementById('f-herbisida').value    = 'Glyphosate 480 SL';
  document.getElementById('f-rekomendasi').value  = '';

  const form    = document.getElementById('crud-form');
  const codeField = document.getElementById('f-block-code');

  if (mode === 'add') {
    title.textContent = 'Tambah Blok Baru';
    form.action = form.dataset.storeUrl;
    document.getElementById('f-method').value = 'POST';
    codeField.disabled = false;
  } else if (mode === 'edit' && blockId) {
    title.textContent = 'Edit Blok';
    form.action = form.dataset.updateBaseUrl + '/' + blockId;
    document.getElementById('f-method').value = 'PUT';
    codeField.disabled = true;

    // Fetch block data
    fetch('/api/block/' + blockId)
      .then(r => r.json())
      .then(b => {
        codeField.value = b.block_code;
        document.getElementById('f-afdeling').value    = b.afdeling;
        document.getElementById('f-luas').value        = b.luas;
        document.getElementById('f-dosis').value       = b.dosis;
        document.getElementById('f-gulma').value       = b.gulma;
        document.getElementById('f-kerapatan').value   = b.kerapatan;
        document.getElementById('f-status').value      = b.status;
        document.getElementById('f-herbisida').value   = b.herbisida;
        document.getElementById('f-rekomendasi').value = b.rekomendasi;
      });
  }

  overlay.classList.add('open');
}

function closeModal() {
  const overlay = document.getElementById('modal-overlay');
  if (overlay) overlay.classList.remove('open');
}

function closeModalOutside(e) {
  if (e.target === document.getElementById('modal-overlay')) closeModal();
}

// ===== CONFIRM DELETE =====
let deleteUrl = null;

function confirmDelete(url, blockCode) {
  deleteUrl = url;
  const overlay = document.getElementById('confirm-overlay');
  const sub     = document.getElementById('confirm-sub');
  if (sub) sub.textContent = `Blok ${blockCode} akan dihapus permanen dan tidak dapat dikembalikan.`;
  if (overlay) overlay.classList.add('open');
}

function closeConfirm() {
  const overlay = document.getElementById('confirm-overlay');
  if (overlay) overlay.classList.remove('open');
  deleteUrl = null;
}

function execDelete() {
  if (!deleteUrl) return;
  document.getElementById('delete-form').action = deleteUrl;
  document.getElementById('delete-form').submit();
}

// ===== AUTO-CALC REKOMENDASI =====
function autoCalcRek() {
  const luas  = parseFloat(document.getElementById('f-luas')?.value) || 0;
  const dosis = parseFloat(document.getElementById('f-dosis')?.value) || 0;
  const rekEl = document.getElementById('f-rekomendasi');
  if (rekEl && luas && dosis) {
    rekEl.value = Math.round(luas * dosis);
  }
}

// ===== FILTER CHIPS (client-side aktif state) =====
document.querySelectorAll('.chip[data-filter]').forEach(chip => {
  chip.addEventListener('click', () => {
    document.querySelectorAll('.chip[data-filter]').forEach(c => c.classList.remove('active'));
    chip.classList.add('active');
  });
});

// ===== PEMAKAIAN FORM (AJAX) =====
function submitPemakaian(event) {
  event.preventDefault();
  const form = event.target;
  const data = new FormData(form);
  const btn  = form.querySelector('button[type=submit]');

  btn.disabled = true;
  btn.textContent = 'Menyimpan...';

  fetch(form.action, {
    method: 'POST',
    body: data,
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
  })
  .then(r => r.json())
  .then(res => {
    if (res.success) {
      toast('✅ ' + res.message);
      form.reset();
      // Update aktual display
      const aktualEl = document.getElementById('aktual-display');
      if (aktualEl) aktualEl.textContent = res.aktual + ' L';
      // Reload to show new riwayat row
      setTimeout(() => location.reload(), 600);
    } else {
      toast('❌ ' + (res.message || 'Gagal menyimpan'));
    }
  })
  .catch(() => toast('❌ Error koneksi'))
  .finally(() => {
    btn.disabled = false;
    btn.textContent = 'Tambah Pemakaian';
  });
}

// ===== PWA INSTALL =====
let deferredPrompt = null;
window.addEventListener('beforeinstallprompt', e => {
  e.preventDefault();
  deferredPrompt = e;
  const btn = document.getElementById('pwa-install-btn');
  if (btn) btn.style.display = 'flex';
});

function installPWA() {
  if (deferredPrompt) {
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then(() => { deferredPrompt = null; });
  }
}

// ===== REGISTER SERVICE WORKER =====
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js').catch(() => {});
}
