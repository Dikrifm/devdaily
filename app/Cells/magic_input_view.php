<div id="magic-zone" class="mb-8 relative group">
    <div class="absolute -inset-1 bg-gradient-to-r from-<?= $theme ?>-500 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
    <div class="relative">
        <textarea id="magicInput" rows="2" class="w-full bg-white dark:bg-slate-900 border-none rounded-xl p-4 pl-12 text-xs font-mono shadow-xl ring-1 ring-slate-900/5 dark:ring-white/10 focus:ring-2 focus:ring-<?= $theme ?>-500 outline-none resize-none placeholder:text-slate-400" placeholder="✨ Tempel teks 'Share' dari Shopee/Tokopedia di sini..."></textarea>
        <div class="absolute left-4 top-4 text-2xl animate-pulse">🪄</div>
        <button onclick="document.getElementById('magicInput').value=''" class="absolute right-2 top-2 text-slate-400 hover:text-red-500 p-2">✕</button>
    </div>
</div>

<script>
    document.getElementById('magicInput').addEventListener('input', function() {
        if(this.value.length > 10) parseMagicText(this.value);
    });

    function parseMagicText(text) {
        let found = false;
        
        // 1. Regex Harga (Rp ...)
        const priceRegex = /Rp\s?([0-9.,]+)/i;
        const priceMatch = text.match(priceRegex);
        const priceField = document.getElementById('<?= $targetPrice ?>');

        if (priceMatch && priceMatch[1] && priceField) {
            let rawPrice = priceMatch[1].replace(/[^0-9]/g, '');
            if (rawPrice.length > 3) {
                priceField.value = rawPrice;
                flashField(priceField);
                found = true;
            }
        }

        // 2. Regex Nama (Hapus Cek... potong sebelum harga)
        const nameField = document.getElementById('<?= $targetName ?>');
        if (nameField) {
            let cleanName = text.replace(/^(Cek|Jual|Promo)\s+/i, '');
            const splitters = [/dengan harga/i, /seharga/i, /Rp[\s0-9]/, /http/];
            for (let regex of splitters) {
                if (regex.test(cleanName)) cleanName = cleanName.split(regex)[0];
            }
            cleanName = cleanName.trim().replace(/[-:,\s]+$/, '');
            
            if (cleanName.length > 3) {
                // Hanya isi jika kosong atau user konfirmasi
                if (nameField.value === '' || confirm('Ganti nama produk?')) {
                    nameField.value = cleanName;
                    flashField(nameField);
                    found = true;
                }
            }
        }

        // 3. Regex Link (Khusus untuk Form Link)
        const linkField = document.getElementById('<?= $targetLink ?>');
        if (linkField) {
            const urlRegex = /(https?:\/\/[^\s]+)/g;
            const urlMatch = text.match(urlRegex);
            if (urlMatch && urlMatch[0]) {
                linkField.value = urlMatch[0]; // Ambil URL pertama
                flashField(linkField);
                if(typeof detectMarketplace === 'function') detectMarketplace(); // Trigger fungsi eksternal jika ada
                found = true;
            }
        }

        if (found) {
            setTimeout(() => { document.getElementById('magicInput').value = ''; }, 500);
        }
    }

    function flashField(el) {
        el.style.transition = "background-color 0.5s";
        el.style.backgroundColor = "rgba(16, 185, 129, 0.2)";
        setTimeout(() => { el.style.backgroundColor = "transparent"; }, 500);
    }
</script>
