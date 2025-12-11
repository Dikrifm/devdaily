<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
    <p class="text-sm text-gray-500">Selamat datang kembali, <span class="font-semibold text-blue-600"><?= $user_fullname ?></span>!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Total Produk</h3>
            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Aktif</span>
        </div>
        <div class="text-3xl font-bold text-gray-900">0</div>
        <p class="text-xs text-gray-400 mt-1">Belum ada data</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Total Marketplace</h3>
            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Terhubung</span>
        </div>
        <div class="text-3xl font-bold text-gray-900">0</div>
        <p class="text-xs text-gray-400 mt-1">Channel aktif</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-4">
        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
    </div>
    <h3 class="text-lg font-medium text-gray-900">Sistem Siap Digunakan</h3>
    <p class="text-gray-500 max-w-sm mx-auto mt-2">Database v3 telah berhasil diintegrasikan. Silakan mulai dengan mengelola data Master Marketplace atau menambahkan Produk baru.</p>
</div>

<?= $this->endSection() ?>
