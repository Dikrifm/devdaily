<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Badge & Label</h1>
    <a href="/admin/badges/new" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
        Tambah Baru
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php foreach($badges as $b): ?>
    <div id="badge-<?= $b->id ?>" class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold shadow-sm <?= $b->color ?>">
                <?= $b->label ?>
            </span>
            <p class="text-xs text-gray-400 mt-2">Class: <?= $b->color ?></p>
        </div>
        <div class="flex space-x-2">
            <a href="/admin/badges/edit/<?= $b->id ?>" class="text-gray-400 hover:text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </a>
            <button hx-delete="/admin/badges/delete/<?= $b->id ?>" hx-target="#badge-<?= $b->id ?>" hx-swap="outerHTML" hx-confirm="Hapus badge ini?" class="text-gray-400 hover:text-red-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>
