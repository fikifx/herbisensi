/* ==========================================
   HERBI Sense — AI Scan JS
   Gemini Vision untuk identifikasi gulma
   dan analisis efektivitas herbisida
   ========================================== */

// ===== SCAN GULMA (Tambah/Edit Blok) =====
const aiScanGulma = {
  preview: null,
  base64:  null,

  init() {
    const input   = document.getElementById('ai-foto-input');
    const preview = document.getElementById('ai-foto-preview');
    if (!input) return;

    input.addEventListener('change', e => {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = ev => {
        if (preview) {
          preview.src = ev.target.result;
          preview.classList.add('show');
        }
      };
      reader.readAsDataURL(file);
    });
  },

  async analyze() {
    const input = document.getElementById('ai-foto-input');
    if (!input || !input.files[0]) {
      alert('Pilih foto gulma terlebih dahulu!');
      return;
    }

    const loader  = document.getElementById('ai-loader');
    const result  = document.getElementById('ai-result');
    const btn     = document.getElementById('ai-analyze-btn');

    if (loader) loader.classList.add('show');
    if (result) result.style.display = 'none';
    if (btn) { btn.disabled = true; btn.textContent = '⏳ Menganalisis...'; }

    try {
      const formData = new FormData();
      formData.append('foto', input.files[0]);
      formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

      const res  = await fetch('/api/ai/scan-gulma', { method: 'POST', body: formData });
      const data = await res.json();

      if (loader) loader.classList.remove('show');

      if (data.success && data.data?.terdeteksi) {
        const d = data.data;

        // Auto-fill form fields
        setFieldIfExists('f-gulma',      `${d.nama} (${d.nama_latin})`);
        setFieldIfExists('f-kerapatan',  d.kerapatan);
        setFieldIfExists('f-herbisida',  d.herbisida);
        setFieldIfExists('f-dosis',      d.dosis);
        setFieldIfExists('f-gulma_ai_raw', JSON.stringify(d));

        // Auto-calc rekomendasi
        autoCalcRek();

        // Show result badge
        if (result) {
          result.style.display = 'block';
          document.getElementById('ai-nama').textContent     = `${d.nama} (${d.nama_latin})`;
          document.getElementById('ai-kerapatan').textContent = d.kerapatan;
          document.getElementById('ai-herbisida').textContent = d.herbisida;
          document.getElementById('ai-dosis').textContent    = `${d.dosis} L/Ha`;
          document.getElementById('ai-confidence').textContent = `${d.confidence}%`;
          const bar = document.getElementById('ai-confidence-bar');
          if (bar) bar.style.width = d.confidence + '%';
          document.getElementById('ai-deskripsi').textContent = d.deskripsi;
        }
      } else if (data.success && data.data && !data.data.terdeteksi) {
        alert('Gulma tidak terdeteksi dalam foto. Coba foto dari sudut yang berbeda.');
      } else {
        alert('⚠️ ' + (data.message || 'Gagal menganalisis foto. Pastikan konfigurasi API Key sudah benar.'));
      }
    } catch (err) {
      if (loader) loader.classList.remove('show');
      alert('❌ Error: ' + err.message);
    } finally {
      if (btn) { btn.disabled = false; btn.textContent = '🤖 Analisis AI'; }
    }
  },
};

// ===== SCAN EVALUASI (Dua Foto) =====
const aiScanEvaluasi = {
  async analyze(prefix = '') {
    const fotoBefore = document.getElementById(prefix + 'foto_sebelum');
    const fotoAfter  = document.getElementById(prefix + 'foto_sesudah');

    if (!fotoBefore?.files[0] || !fotoAfter?.files[0]) {
      alert('Upload kedua foto (sebelum & sesudah) terlebih dahulu!');
      return;
    }

    const loader = document.getElementById(prefix + 'ai-eval-loader');
    const result = document.getElementById(prefix + 'ai-eval-result');
    const btn    = document.getElementById(prefix + 'ai-eval-btn');

    if (loader) loader.classList.add('show');
    if (result) result.style.display = 'none';
    if (btn) { btn.disabled = true; btn.textContent = '⏳ Menganalisis...'; }

    try {
      const formData = new FormData();
      formData.append('foto_sebelum', fotoBefore.files[0]);
      formData.append('foto_sesudah', fotoAfter.files[0]);
      formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

      const res  = await fetch('/api/ai/scan-evaluasi', { method: 'POST', body: formData });
      const data = await res.json();

      if (loader) loader.classList.remove('show');

      if (data.success && data.data) {
        const d = data.data;

        // Auto-fill form
        setFieldIfExists(prefix + 'efektivitas', d.efektivitas);
        setFieldIfExists(prefix + 'kategori',    d.kategori);
        setFieldIfExists(prefix + 'catatan',     d.catatan);
        setFieldIfExists(prefix + 'foto_ai_raw', JSON.stringify(d));

        // Show result
        if (result) {
          result.style.display = 'block';
          const effEl = document.getElementById(prefix + 'ai-eval-efektivitas');
          if (effEl) effEl.textContent = d.efektivitas + '%';
          const catEl = document.getElementById(prefix + 'ai-eval-kategori');
          if (catEl) catEl.textContent = d.kategori;
          const noteEl = document.getElementById(prefix + 'ai-eval-catatan');
          if (noteEl) noteEl.textContent = d.catatan;
          const bar = document.getElementById(prefix + 'ai-eval-bar');
          if (bar) bar.style.width = d.efektivitas + '%';
        }
      } else {
        alert('⚠️ ' + (data.message || 'Gagal menganalisis foto.'));
      }
    } catch (err) {
      if (loader) loader.classList.remove('show');
      alert('❌ Error: ' + err.message);
    } finally {
      if (btn) { btn.disabled = false; btn.textContent = '🤖 Analisis AI'; }
    }
  },
};

// ===== FOTO PREVIEW HELPER =====
function setupPhotoPreview(inputId, previewId) {
  const input   = document.getElementById(inputId);
  const preview = document.getElementById(previewId);
  if (!input || !preview) return;

  input.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
      preview.src = ev.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  });
}

// ===== UTILITY =====
function setFieldIfExists(id, value) {
  const el = document.getElementById(id);
  if (el && value !== null && value !== undefined) el.value = value;
}

// Init on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  aiScanGulma.init();
  setupPhotoPreview('m_foto_sebelum', 'm_preview-sebelum');
  setupPhotoPreview('m_foto_sesudah', 'm_preview-sesudah');
  setupPhotoPreview('d_foto_sebelum', 'd_preview-sebelum');
  setupPhotoPreview('d_foto_sesudah', 'd_preview-sesudah');
});
