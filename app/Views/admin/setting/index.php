<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Sistem</h1>
    <button type="submit" form="settingForm" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition">
        Simpan Perubahan
    </button>
</div>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php endif; ?>

<form id="settingForm" action="/admin/settings/update" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div x-data="{ activeTab: 'general' }" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="border-b border-gray-200 bg-gray-50 overflow-x-auto">
            <nav class="flex -mb-px">
                <?php foreach($groupedIdentities as $group => $items): ?>
                    <button type="button" @click="activeTab = '<?= $group ?>'" 
                        :class="{ 'border-blue-500 text-blue-600 bg-white': activeTab === '<?= $group ?>', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== '<?= $group ?>' }"
                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm capitalize transition">
                        <?= $group ?>
                    </button>
                <?php endforeach; ?>
                
                <div class="w-px bg-gray-300 my-3 mx-2"></div>

                <?php foreach($groupedConfigs as $group => $items): ?>
                    <button type="button" @click="activeTab = '<?= $group ?>'" 
                        :class="{ 'border-purple-500 text-purple-600 bg-white': activeTab === '<?= $group ?>', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== '<?= $group ?>' }"
                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm capitalize transition">
                        System: <?= $group ?>
                    </button>
                <?php endforeach; ?>
            </nav>
        </div>

        <div class="p-6">
            <?php foreach($groupedIdentities as $group => $items): ?>
                <div x-show="activeTab === '<?= $group ?>'" class="space-y-6">
                    <h3 class="text-lg font-medium text-gray-900 capitalize border-b pb-2 mb-4">Konfigurasi <?= $group ?></h3>
                    <?php foreach($items as $item): ?>
                        <?= view('admin/setting/_input_builder', ['item' => $item, 'type' => 'identity']) ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <?php foreach($groupedConfigs as $group => $items): ?>
                <div x-show="activeTab === '<?= $group ?>'" class="space-y-6">
                    <h3 class="text-lg font-medium text-purple-900 capitalize border-b pb-2 mb-4">System: <?= $group ?></h3>
                    <div class="bg-purple-50 p-4 rounded-lg mb-4 text-sm text-purple-700">
                        Area ini berisi konfigurasi sensitif (API Keys, Server Config). Harap berhati-hati.
                    </div>
                    <?php foreach($items as $item): ?>
                        <?= view('admin/setting/_input_builder', ['item' => $item, 'type' => 'config']) ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</form>

<script src="//unpkg.com/alpinejs" defer></script>

<?= $this->endSection() ?>
