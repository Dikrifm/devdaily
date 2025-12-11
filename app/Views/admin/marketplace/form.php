<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="/admin/marketplaces" class="text-gray-500 hover:text-gray-700 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800"><?= $title ?></h1>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6">
        
        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded mb-6 text-sm">
                <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li>• <?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="/admin/marketplaces/save" method="post" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $marketplace->id ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Marketplace</label>
                <input type="text" name="name" id="nameInput" value="<?= old('name', $marketplace->name) ?>" 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition" 
                    placeholder="Contoh: Shopee" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug (URL Friendly)</label>
                <input type="text" name="slug" id="slugInput" value="<?= old('slug', $marketplace->slug) ?>" 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 text-gray-500" 
                    placeholder="shopee" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Warna Label (Tailwind Class)</label>
                <div class="flex gap-2 mb-2">
                    <button type="button" onclick="setColor('bg-orange-500')" class="w-6 h-6 rounded-full bg-orange-500 border hover:scale-110 transition"></button>
                    <button type="button" onclick="setColor('bg-green-500')" class="w-6 h-6 rounded-full bg-green-500 border hover:scale-110 transition"></button>
                    <button type="button" onclick="setColor('bg-blue-500')" class="w-6 h-6 rounded-full bg-blue-500 border hover:scale-110 transition"></button>
                    <button type="button" onclick="setColor('bg-black')" class="w-6 h-6 rounded-full bg-black border hover:scale-110 transition"></button>
                    <button type="button" onclick="setColor('bg-pink-500')" class="w-6 h-6 rounded-full bg-pink-500 border hover:scale-110 transition"></button>
                </div>
                <input type="text" name="color" id="colorInput" value="<?= old('color', $marketplace->color) ?>" 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    placeholder="bg-orange-500">
                <p class="text-xs text-gray-400 mt-1">Gunakan class background Tailwind.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Icon Logo</label>
                <div class="flex items-center space-x-4">
                    <?php if($marketplace->icon): ?>
                        <div class="shrink-0">
                            <img src="<?= $marketplace->getIconUrl() ?>" class="h-12 w-12 object-contain border rounded-lg p-1">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="icon" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                </div>
                <p class="text-xs text-gray-400 mt-1">Format: PNG/JPG. Maks 1MB. (Kosongkan jika tidak ingin mengubah)</p>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white font-medium py-2 px-6 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Simple Auto Slug
    document.getElementById('nameInput').addEventListener('input', function(e) {
        let slug = e.target.value.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('slugInput').value = slug;
    });

    // Helper Color Picker
    function setColor(color) {
        document.getElementById('colorInput').value = color;
    }
</script>

<?= $this->endSection() ?>
