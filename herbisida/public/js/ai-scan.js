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
    const container = document.getElementById('ai-foto-preview-container');
    if (!input) return;

    input.addEventListener('change', e => {
      if (container) container.innerHTML = '';
      const files = e.target.files;
      if (!files || files.length === 0) return;

      Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = ev => {
          const img = document.createElement('img');
          img.src = ev.target.result;
          img.className = 'photo-preview show';
          img.style.width = '80px';
          img.style.height = '80px';
          img.style.objectFit = 'cover';
          img.style.borderRadius = '8px';
          img.style.flexShrink = '0';
          if (container) container.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
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
      const files = input.files;
      const formData = new FormData();
      for(let i = 0; i < files.length; i++) {
        const compressedFile = await compressImage(files[i]);
        formData.append('foto[]', compressedFile);
      }
      formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

      const res  = await fetch('/api/ai/scan-gulma', { 
        method: 'POST', 
        headers: {
          'Accept': 'application/json'
        },
        body: formData 
      });
      const data = await res.json();

      if (loader) loader.classList.remove('show');

      if (data.success && data.data?.terdeteksi) {
        const d = data.data;

        // Auto-fill form fields
        let mainWeedName = d.nama || '';
        let mainWeedLatin = d.nama_latin || '';
        if(d.weeds && d.weeds.length > 0) {
            const dom = d.weeds.reduce((prev, curr) => (prev.total_individu > curr.total_individu) ? prev : curr, d.weeds[0]);
            mainWeedName = dom.nama;
            if(dom.nama_latin) mainWeedLatin = dom.nama_latin;
        }
        
        let finalGulma = mainWeedName;
        if(mainWeedLatin) finalGulma += ` (${mainWeedLatin})`;
        
        setFieldIfExists('f-gulma',      finalGulma);
        setFieldIfExists('f-kerapatan',  extractNumber(d.kerapatan_total || d.kerapatan));
        setFieldIfExists('f-herbisida',  d.herbisida);
        setFieldIfExists('f-dosis',      extractNumber(d.dosis));
        setFieldIfExists('f-gulma_ai_raw', JSON.stringify(d));

        // Auto-calc rekomendasi
        autoCalcRek();

        // Show result badge
        if (result) {
          result.style.display = 'block';
          
          const tbody = document.getElementById('ai-gulma-table-body');
          if(tbody) {
              tbody.innerHTML = '';
              let we = d.weeds || [{nama: d.nama, total_individu: d.kerapatan, kerapatan: d.kerapatan}];
              we.forEach(w => {
                  let tr = document.createElement('tr');
                  tr.innerHTML = `
                    <td style="padding: 4px 0;">${w.nama}</td>
                    <td style="padding: 4px 0; text-align:right;">${w.total_individu}</td>
                    <td style="padding: 4px 0; text-align:right;">${w.kerapatan}</td>
                  `;
                  tbody.appendChild(tr);
              });
          }
          
          const totalIndivEl = document.getElementById('ai-total-individu');
          if(totalIndivEl) totalIndivEl.textContent = d.total_individu || d.kerapatan || '-';
          
          const totalKerapEl = document.getElementById('ai-total-kerapatan');
          if(totalKerapEl) totalKerapEl.textContent = d.kerapatan_total || d.kerapatan || '-';

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
      const fileBefore = fotoBefore.files[0];
      const fileAfter  = fotoAfter.files[0];
      
      const [compBefore, compAfter] = await Promise.all([
        compressImage(fileBefore),
        compressImage(fileAfter)
      ]);
      
      const formData = new FormData();
      formData.append('foto_sebelum', compBefore);
      formData.append('foto_sesudah', compAfter);
      formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

      const res  = await fetch('/api/ai/scan-evaluasi', { 
        method: 'POST', 
        headers: {
          'Accept': 'application/json'
        },
        body: formData 
      });
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
  if (el && value !== null && value !== undefined && value !== '') el.value = value;
}

function extractNumber(val) {
  if (val === null || val === undefined) return '';
  let str = val.toString().replace(/,/g, '.');
  let num = parseFloat(str.replace(/[^\d.-]/g, ''));
  return isNaN(num) ? '' : num;
}

// ===== CLIENT-SIDE COMPRESSION =====
async function compressImage(file, maxWidth = 1200, quality = 0.7) {
  if (!file || !file.type.match(/image.*/)) return file;
  
  return new Promise((resolve) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = event => {
      const img = new Image();
      img.src = event.target.result;
      img.onload = () => {
        const canvas = document.createElement('canvas');
        let width = img.width;
        let height = img.height;

        if (width > maxWidth) {
          height = Math.round((height * maxWidth) / width);
          width = maxWidth;
        }

        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, width, height);

        canvas.toBlob(blob => {
          resolve(new File([blob], file.name, {
            type: 'image/jpeg',
            lastModified: Date.now()
          }));
        }, 'image/jpeg', quality);
      };
    };
  });
}

// Init on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  aiScanGulma.init();
  setupPhotoPreview('m_foto_sebelum', 'm_preview-sebelum');
  setupPhotoPreview('m_foto_sesudah', 'm_preview-sesudah');
  setupPhotoPreview('d_foto_sebelum', 'd_preview-sebelum');
  setupPhotoPreview('d_foto_sesudah', 'd_preview-sesudah');
});
