<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<form action="/admin/products/save" method="post" enctype="multipart/form-data" class="space-y-8">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $product->id ?>">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800"><?= $title ?></h1>
        <div class="space-x-3">
            <a href="/admin/products" class="text-gray-500 hover:text-gray-700">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 shadow-sm">Simpan Produk</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Dasar</h3>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" name="name" id="nameInput" value="<?= old('name', $product->name) ?>" class="w-full rounded-lg border-gray-300 border p-2 shadow-sm" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Slug URL</label>
                            <input type="text" name="slug" id="slugInput" value="<?= old('slug', $product->slug) ?>" class="w-full bg-gray-50 text-gray-500 rounded-lg border-gray-300 border p-2 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Pasar (Rp)</label>
                            <input type="number" name="market_price" value="<?= old('market_price', $product->market_price) ?>" class="w-full rounded-lg border-gray-300 border p-2 shadow-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 border p-2 shadow-sm"><?= old('description', $product->description) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Varian Link Toko</h3>
                    <button type="button" onclick="addLinkRow()" class="text-sm text-blue-600 font-medium hover:underline">+ Tambah Link</button>
                </div>

                <div id="linksContainer" class="space-y-4">
                    <?php if(!empty($product->links)): ?>
                        <?php foreach($product->links as $index => $link): ?>
                            <div class="link-row grid grid-cols-12 gap-3 items-end bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <div class="col-span-3">
                                    <label class="text-xs text-gray-500">Marketplace</label>
                                    <select name="links[<?= $index ?>][marketplace_id]" class="w-full text-sm rounded border-gray-300">
                                        <?php foreach($marketplaces as $mp): ?>
                                            <option value="<?= $mp->id ?>" <?= $mp->id == $link->marketplace_id ? 'selected' : '' ?>><?= $mp->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-span-3">
                                    <label class="text-xs text-gray-500">Nama Toko</label>
                                    <input type="text" name="links[<?= $index ?>][store_name]" value="<?= $link->store_name ?>" class="w-full text-sm rounded border-gray-300">
                                </div>
                                <div class="col-span-2">
                                    <label class="text-xs text-gray-500">Harga</label>
                                    <input type="number" name="links[<?= $index ?>][price]" value="<?= $link->price ?>" class="w-full text-sm rounded border-gray-300">
                                </div>
                                <div class="col-span-3">
                                    <label class="text-xs text-gray-500">URL Produk</label>
                                    <input type="text" name="links[<?= $index ?>][url]" value="<?= $link->url ?>" class="w-full text-sm rounded border-gray-300">
                                </div>
                                <div class="col-span-1 text-center">
                                    <button type="button" onclick="this.closest('.link-row').remove()" class="text-red-500 hover:text-red-700">×</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <?php if(empty($product->links)): ?>
                    <p id="emptyLinkMsg" class="text-sm text-gray-400 text-center py-4">Belum ada link marketplace.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Media</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Utama</label>
                    <?php if($product->image_url): ?>
                        <img src="<?= $product->getImageUrl() ?>" class="w-full h-48 object-cover rounded-lg mb-3 border">
                    <?php endif; ?>
                    <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="border-t pt-4 mt-4">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="active" value="1" <?= $product->active ? 'checked' : '' ?> class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <span class="text-gray-900 font-medium">Publikasikan Produk</span>
                    </label>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Labels / Badges</h3>
                <div class="space-y-2">
                    <?php foreach($badges as $badge): ?>
                    <label class="flex items-center space-x-3 p-2 rounded hover:bg-gray-50 cursor-pointer border border-transparent hover:border-gray-200">
                        <input type="checkbox" name="badges[]" value="<?= $badge->id ?>" 
                            <?= in_array($badge->id, $product->activeBadges) ? 'checked' : '' ?> 
                            class="h-4 w-4 text-blue-600 rounded border-gray-300">
                        <span class="<?= $badge->color ?> px-2 py-0.5 rounded text-xs font-bold"><?= $badge->label ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <a href="/admin/badges" class="text-xs text-blue-600 hover:underline">Kelola Master Badge &rarr;</a>
                </div>
            </div>

        </div>
    </div>
</form>

<template id="linkRowTemplate">
    <div class="link-row grid grid-cols-12 gap-3 items-end bg-blue-50 p-3 rounded-lg border border-blue-100 animate-pulse-once">
        <div class="col-span-3">
            <select name="links[INDEX][marketplace_id]" class="w-full text-sm rounded border-gray-300">
                <?php foreach($marketplaces as $mp): ?>
                    <option value="<?= $mp->id ?>"><?= $mp->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-span-3">
            <input type="text" name="links[INDEX][store_name]" placeholder="Nama Toko" class="w-full text-sm rounded border-gray-300">
        </div>
        <div class="col-span-2">
            <input type="number" name="links[INDEX][price]" placeholder="Harga" class="w-full text-sm rounded border-gray-300">
        </div>
        <div class="col-span-3">
            <input type="text" name="links[INDEX][url]" placeholder="https://..." class="w-full text-sm rounded border-gray-300">
        </div>
        <div class="col-span-1 text-center">
            <button type="button" onclick="this.closest('.link-row').remove()" class="text-red-500 hover:text-red-700">×</button>
        </div>
    </div>
</template>

<script>
    // Auto Slug
    document.getElementById('nameInput').addEventListener('input', function(e) {
        let slug = e.target.value.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        document.getElementById('slugInput').value = slug;
    });

    // Dynamic Link Rows
    let linkIndex = <?= isset($product->links) ? count($product->links) : 0 ?>;

    function addLinkRow() {
        const template = document.getElementById('linkRowTemplate');
        const container = document.getElementById('linksContainer');
        const emptyMsg = document.getElementById('emptyLinkMsg');
        
        if(emptyMsg) emptyMsg.style.display = 'none';

        // Clone template
        let clone = template.content.cloneNode(true);
        
        // Replace INDEX placeholder with unique number
        let html = clone.querySelector('div').outerHTML;
        html = html.replace(/INDEX/g, linkIndex);
        
        // Insert to DOM (Hack karena template content is fragment)
        let tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        container.appendChild(tempDiv.firstChild);

        linkIndex++;
    }
</script>

<?= $this->endSection() ?>
