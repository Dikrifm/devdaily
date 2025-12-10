<script>
    // --- 0. MANUAL SUBMIT (PENYELAMAT TOMBOL MACET) ---
    // Fungsi ini dipanggil oleh tombol Simpan di form.php
    function submitFormManually() {
        console.log("Proses simpan manual dimulai...");
        
        // 1. Paksa Sinkronisasi Harga
        // Kita ambil angka dari tampilan (Rp 10.000) -> Ubah jadi angka murni (10000) -> Masukkan ke input hidden
        const pDisplay = document.getElementById('priceDisplay');
        const pReal = document.getElementById('priceReal');
        
        if(pDisplay && pReal) {
            const cleanVal = pDisplay.value.replace(/[^0-9]/g, '');
            pReal.value = cleanVal;
            console.log("Harga sinkron: " + cleanVal);
        }

        // 2. Validasi Sederhana di Sisi Klien
        const nameField = document.getElementById('nameField');
        if(nameField && nameField.value.trim().length < 2) {
            alert('⚠️ Nama produk wajib diisi minimal 2 karakter!');
            nameField.focus();
            return;
        }

        if(!pReal || pReal.value === '' || pReal.value === '0') {
            alert('⚠️ Harga produk wajib diisi!');
            if(pDisplay) pDisplay.focus();
            return;
        }

        // 3. Kirim Form (Bypass Validasi HTML5)
        const form = document.getElementById('productForm');
        if(form) {
            form.submit();
        } else {
            alert("Error: Form tidak ditemukan!");
        }
    }

    // --- 1. MAGIC TEXT PARSER (CLEANER ENGINE) ---
    const magicArea = document.getElementById('magicPasteArea');
    if(magicArea) {
        magicArea.addEventListener('input', function() {
            let text = this.value;
            if(text.length < 5) return;

            // A. Ambil Harga (Cari Rp...)
            const priceMatch = text.match(/Rp\s?([0-9.,]+)/i);
            if (priceMatch) {
                let raw = priceMatch[1].replace(/\./g, '').split(',')[0];
                updatePrice(raw);
                text = text.replace(priceMatch[0], '');
            }

            // B. Buang Link (URL + Tracking)
            text = text.replace(/(https?:\/\/[^\s]+)/g, '');

            // C. Sanitasi Kata Sampah (Stop Words)
            const junk = ["Cek", "Lihat", "Beli", "Dapatkan di", "sekarang!", "dengan harga", "seharga", "Jual", "Murah", "Promo", "Original", "Termurah"];
            junk.forEach(word => {
                const reg = new RegExp(word, "gi");
                text = text.replace(reg, '');
            });

            // D. Bersihkan Simbol Aneh & Spasi Ganda
            text = text.replace(/[^\w\s\-\/\(\).,]/gi, ' ').replace(/\s+/g, ' ').trim();

            // E. Masukkan ke Kolom Nama & Expand
            const nameField = document.getElementById('nameField');
            if(nameField) {
                nameField.value = text;
                autoExpand(nameField);
            }
            
            // F. Feedback & Reset
            this.value = '';
            this.placeholder = "✨ Teks berhasil disalin!";
            setTimeout(() => this.placeholder = "Tempel teks di sini...", 2000);
        });
    }

    // --- 2. AUTO EXPAND TEXTAREA ---
    function autoExpand(field) {
        field.style.height = 'inherit'; // Reset
        const computed = window.getComputedStyle(field);
        const height = parseInt(computed.getPropertyValue('border-top-width'), 10)
                     + parseInt(computed.getPropertyValue('padding-top'), 10)
                     + field.scrollHeight
                     + parseInt(computed.getPropertyValue('padding-bottom'), 10)
                     + parseInt(computed.getPropertyValue('border-bottom-width'), 10);
        field.style.height = height + 'px';
    }
    // Init saat load (untuk mode Edit)
    window.addEventListener('load', () => {
        const nf = document.getElementById('nameField');
        if(nf) autoExpand(nf);
    });

    // --- 3. PRICE MASKING (000.000) ---
    const pDisplay = document.getElementById('priceDisplay');
    const pReal = document.getElementById('priceReal');

    if(pDisplay) {
        pDisplay.addEventListener('input', function(e) {
            let val = this.value.replace(/[^0-9]/g, '');
            updatePrice(val);
        });
    }

    function updatePrice(rawVal) {
        if(!rawVal) { 
            if(pDisplay) pDisplay.value = ''; 
            if(pReal) pReal.value = ''; 
            return; 
        }
        if(pReal) pReal.value = rawVal;
        if(pDisplay) pDisplay.value = new Intl.NumberFormat('id-ID').format(rawVal);
    }

    // --- 4. IMAGE TABS & PASTE LOGIC ---
    function switchImgTab(mode) {
        ['upload','link','paste'].forEach(m => {
            const panel = document.getElementById('panel-'+m);
            const tab = document.getElementById('tab-'+m);
            if(panel && tab) {
                panel.classList.add('hidden');
                tab.classList.remove('bg-white','dark:bg-slate-800','shadow','text-emerald-600');
                tab.classList.add('text-slate-500');
            }
        });
        const activePanel = document.getElementById('panel-'+mode);
        const activeTab = document.getElementById('tab-'+mode);
        
        if(activePanel) activePanel.classList.remove('hidden');
        if(activeTab) {
            activeTab.classList.add('bg-white','dark:bg-slate-800','shadow','text-emerald-600');
            activeTab.classList.remove('text-slate-500');
        }
    }

    // Event Paste Global
    document.addEventListener('paste', function(e) {
        // Cek apakah tab Paste sedang aktif
        const pastePanel = document.getElementById('panel-paste');
        if (!pastePanel || pastePanel.classList.contains('hidden')) return;

        if (e.clipboardData && e.clipboardData.items) {
            const items = e.clipboardData.items;
            for (let i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") !== -1) {
                    const blob = items[i].getAsFile();
                    const url = URL.createObjectURL(blob);
                    
                    // Tampilkan Preview
                    document.getElementById('imgPreview').src = url;
                    document.getElementById('imgPreviewBox').classList.remove('hidden');
                    
                    // Masukkan ke Input File (Simulasi)
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(blob);
                    const fileInput = document.getElementById('fileField'); // Pastikan ID ini ada di form.php
                    if(fileInput) fileInput.files = dataTransfer.files; 
                    
                    // Reset UI
                    pastePanel.innerHTML = '<span class="text-emerald-600 font-bold">✅ Gambar Tersalin!</span>';
                }
            }
        }
    });

    function triggerPaste() {
        alert("Silakan tekan Ctrl+V (PC) atau Tahan Lama & Tempel (HP) sekarang.");
    }

    function previewFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('imgPreview');
                if(img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUrl(url) {
        if(url.length > 10) {
            const img = document.getElementById('imgPreview');
            if(img) {
                img.src = url;
                img.classList.remove('hidden');
            }
        }
    }

    function clearImage() {
        const img = document.getElementById('imgPreview');
        if(img) {
            img.src = '';
            img.classList.add('hidden');
        }
        const fileIn = document.getElementById('fileField');
        if(fileIn) fileIn.value = '';
        const urlIn = document.getElementById('urlField');
        if(urlIn) urlIn.value = '';
    }

    // --- 5. BADGE LIMITER ---
    function limitChecks(checkbox) {
        const checks = document.querySelectorAll('input[name="badge_ids[]"]:checked');
        if (checks.length > 3) { 
            checkbox.checked = false; 
            alert('Maksimal 3 label!'); 
        }
    }
</script>
