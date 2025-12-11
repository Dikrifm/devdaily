<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>
<div class="max-w-md mx-auto">
    <div class="flex items-center mb-6">
        <a href="/admin/badges" class="text-gray-500 mr-3">Kembali</a>
        <h1 class="text-2xl font-bold text-gray-800"><?= $title ?></h1>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6">
        <form action="/admin/badges/save" method="post" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $badge->id ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teks Label</label>
                <input type="text" name="label" value="<?= old('label', $badge->label) ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 p-2 border" placeholder="MISAL: TERLARIS" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Warna (Tailwind Class)</label>
                <input type="text" name="color" value="<?= old('color', $badge->color) ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 p-2 border" placeholder="bg-red-500 text-white" required>
                <div class="mt-2 flex gap-2 text-xs">
                    <span class="cursor-pointer bg-red-500 text-white px-2 py-1 rounded" onclick="document.getElementsByName('color')[0].value='bg-red-500 text-white'">Red</span>
                    <span class="cursor-pointer bg-blue-500 text-white px-2 py-1 rounded" onclick="document.getElementsByName('color')[0].value='bg-blue-500 text-white'">Blue</span>
                    <span class="cursor-pointer bg-green-500 text-white px-2 py-1 rounded" onclick="document.getElementsByName('color')[0].value='bg-green-500 text-white'">Green</span>
                    <span class="cursor-pointer bg-amber-500 text-white px-2 py-1 rounded" onclick="document.getElementsByName('color')[0].value='bg-amber-500 text-white'">Amber</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Simpan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
