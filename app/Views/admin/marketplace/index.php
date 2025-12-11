<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Marketplace</h1>
    <a href="/admin/marketplaces/new" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Baru
    </a>
</div>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('message') ?></span>
    </div>
<?php endif; ?>

<div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Marketplace</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warna Label</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($marketplaces as $mp): ?>
            <tr id="row-<?= $mp->id ?>" class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($mp->icon): ?>
                        <img src="<?= $mp->getIconUrl() ?>" alt="<?= $mp->name ?>" class="h-8 w-8 object-contain">
                    <?php else: ?>
                        <span class="text-gray-400 text-xs">No Icon</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900"><?= $mp->name ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500"><?= $mp->slug ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white <?= $mp->color ?>">
                        <?= $mp->color ?>
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <a href="/admin/marketplaces/edit/<?= $mp->id ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    
                    <button 
                        hx-delete="/admin/marketplaces/delete/<?= $mp->id ?>"
                        hx-confirm="Yakin ingin menghapus marketplace ini?"
                        hx-target="#row-<?= $mp->id ?>"
                        hx-swap="outerHTML"
                        class="text-red-600 hover:text-red-900 ml-2">
                        Hapus
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php if(empty($marketplaces)): ?>
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                    Belum ada data marketplace. Silakan tambah baru.
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
