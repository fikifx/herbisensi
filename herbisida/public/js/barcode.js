/* ==========================================
   HERBI Sense — Barcode Scanner JS
   Menggunakan @zxing/library
   ========================================== */

const scanner = {
  codeReader: null,
  stream: null,

  init() {
    // Lazy load library script if not loaded
    if (typeof ZXing === 'undefined') {
      const script = document.createElement('script');
      script.src = 'https://unpkg.com/@zxing/library@latest';
      script.onload = () => this.setup();
      document.head.appendChild(script);
    } else {
      this.setup();
    }
  },

  setup() {
    this.codeReader = new ZXing.BrowserMultiFormatReader();
    const startBtn = document.getElementById('start-scan-btn');
    const stopBtn  = document.getElementById('stop-scan-btn');
    
    if (startBtn) {
      startBtn.addEventListener('click', () => this.start());
    }
    if (stopBtn) {
      stopBtn.addEventListener('click', () => this.stop());
    }
  },

  async start() {
    const videoWrap = document.getElementById('scan-video-wrap');
    const resultEl  = document.getElementById('scan-result-batch');
    const startBtn  = document.getElementById('start-scan-btn');
    const stopBtn   = document.getElementById('stop-scan-btn');

    if (videoWrap) videoWrap.style.display = 'block';
    if (startBtn)  startBtn.style.display  = 'none';
    if (stopBtn)   stopBtn.style.display   = 'inline-flex';
    if (resultEl)  resultEl.textContent    = 'Mengarahkan kamera...';

    try {
      const videoInputDevices = await this.codeReader.listVideoInputDevices();
      const selectedDeviceId = videoInputDevices.length > 1 ? videoInputDevices[1].deviceId : videoInputDevices[0].deviceId;

      this.codeReader.decodeFromVideoDevice(selectedDeviceId, 'scan-video', (result, err) => {
        if (result) {
          // Barcode found!
          const batchCode = result.text;
          if (resultEl) resultEl.innerHTML = `Terdeteksi: <b>${batchCode}</b>`;
          
          // Auto fill form
          const inputBatch = document.getElementById('batch');
          if (inputBatch) inputBatch.value = batchCode;

          toast('✅ Barcode material terdeteksi!');
          
          // Play beep sound
          this.playBeep();
          
          this.stop();
        }
      });
    } catch (err) {
      console.error(err);
      toast('❌ Gagal mengakses kamera');
    }
  },

  stop() {
    if (this.codeReader) {
      this.codeReader.reset();
    }
    
    const videoWrap = document.getElementById('scan-video-wrap');
    const startBtn  = document.getElementById('start-scan-btn');
    const stopBtn   = document.getElementById('stop-scan-btn');
    
    if (videoWrap) videoWrap.style.display = 'none';
    if (startBtn)  startBtn.style.display  = 'inline-flex';
    if (stopBtn)   stopBtn.style.display   = 'none';
  },

  playBeep() {
    const ctx = new (window.AudioContext || window.webkitAudioContext)();
    const osc = ctx.createOscillator();
    const gainNode = ctx.createGain();
    
    osc.connect(gainNode);
    gainNode.connect(ctx.destination);
    
    osc.type = 'sine';
    osc.frequency.setValueAtTime(800, ctx.currentTime);
    gainNode.gain.setValueAtTime(0.1, ctx.currentTime);
    
    osc.start(ctx.currentTime);
    osc.stop(ctx.currentTime + 0.1);
  }
};

document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('scan-video')) {
    scanner.init();
  }
});
