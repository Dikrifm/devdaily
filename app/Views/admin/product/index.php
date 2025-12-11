<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Produk</h1>
    <a href="/admin/products/new" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">Tambah Produk</a>
</div>

<div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Pasar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($products as $p): ?>
            <tr id="row-<?= $p->id ?>" class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0">
                            <img class="h-10 w-10 rounded-lg object-cover" src="<?= $p->getImageUrl() ?>" alt="">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900"><?= $p->name ?></div>
                            <div class="text-xs text-gray-500"><?= $p->slug ?></div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?= $p->getFormattedPrice() ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($p->active): ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    <?php else: ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <a href="/admin/products/edit/<?= $p->id ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <button hx-delete="/admin/products/delete/<?= $p->id ?>" hx-target="#row-<?= $p->id ?>" hx-swap="outerHTML" hx-confirm="Yakin?" class="text-red-600 hover:text-red-900 ml-2">Hapus</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
