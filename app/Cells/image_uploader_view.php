<div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl p-2">
    <div class="flex bg-slate-100 dark:bg-black rounded-xl p-1 mb-3">
        <button type="button" onclick="switchImgTab('upload')" id="btn-upload" class="flex-1 py-2 text-xs font-bold rounded-lg bg-white dark:bg-slate-800 shadow text-<?= $theme ?>-600 transition-all">UPLOAD</button>
        <button type="button" onclick="switchImgTab('link')" id="btn-link" class="flex-1 py-2 text-xs font-bold rounded-lg text-slate-500 hover:text-<?= $theme ?>-500 transition-all">URL</button>
    </div>

    <div class="p-2">
        <div id="input-upload">
            <input type="file" id="file-field" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-<?= $theme ?>-50 file:text-<?= $theme ?>-700 hover:file:bg-<?= $theme ?>-100" onchange="previewFile()">
        </div>
        <div id="input-link" class="hidden">
            <input type="url" id="url-field" name="image_url" class="w-full bg-slate-50 dark:bg-black border border-slate-300 dark:border-slate-700 p-3 rounded-xl outline-none text-xs" placeholder="https://..." oninput="previewUrl()">
        </div>
    </div>

    <?php 
        $hasImg = !empty($currentImage);
        $src = $hasImg ? ((strpos($currentImage,'http')===0) ? $currentImage : base_url($currentImage)) : '';
    ?>
    <div id="img-preview-box" class="<?= $hasImg ? '' : 'hidden' ?> mt-2 relative h-48 bg-slate-100 dark:bg-black rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800">
        <img id="real-preview" src="<?= $src ?>" class="w-full h-full object-contain">
        <button type="button" onclick="resetImg()" class="absolute top-2 right-2 bg-red-500 text-white w-6 h-6 rounded-full text-xs shadow">✕</button>
    </div>
</div>

<script>
    function switchImgTab(mode) {
        const up = document.getElementById('input-upload');
        const ln = document.getElementById('input-link');
        const bUp = document.getElementById('btn-upload');
        const bLn = document.getElementById('btn-link');
        
        if(mode==='upload') {
            up.classList.remove('hidden'); ln.classList.add('hidden');
            bUp.classList.add('bg-white','dark:bg-slate-800','shadow'); bLn.classList.remove('bg-white','dark:bg-slate-800','shadow');
        } else {
            ln.classList.remove('hidden'); up.classList.add('hidden');
            bLn.classList.add('bg-white','dark:bg-slate-800','shadow'); bUp.classList.remove('bg-white','dark:bg-slate-800','shadow');
        }
    }
    function previewFile() {
        const file = document.getElementById('file-field').files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => { showP(e.target.result); };
            reader.readAsDataURL(file);
        }
    }
    function previewUrl() {
        const url = document.getElementById('url-field').value;
        if(url.length > 5) showP(url);
    }
    function showP(src) {
        document.getElementById('real-preview').src = src;
        document.getElementById('img-preview-box').classList.remove('hidden');
    }
    function resetImg() {
        document.getElementById('real-preview').src = '';
        document.getElementById('img-preview-box').classList.add('hidden');
        document.getElementById('file-field').value = '';
        document.getElementById('url-field').value = '';
    }
</script>
