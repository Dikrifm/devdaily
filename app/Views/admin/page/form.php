<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>
<form action="/admin/pages/save" method="post" class="max-w-4xl mx-auto space-y-6">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $page->id ?>">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800"><?= $title ?></h1>
        <div class="space-x-3">
            <a href="/admin/pages" class="text-gray-500 hover:text-gray-700">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 shadow-sm">Simpan</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Halaman</label>
                    <input type="text" name="title" id="titleInput" value="<?= old('title', $page->title) ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 p-2 border" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug (URL)</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">/p/</span>
                        <input type="text" name="slug" id="slugInput" value="<?= old('slug', $page->slug) ?>" class="flex-1 rounded-r-lg border-gray-300 focus:border-blue-500 p-2 border shadow-sm" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                    <textarea name="content" rows="15" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 p-2 border font-mono text-sm"><?= old('content', $page->content) ?></textarea>
                    <p class="text-xs text-gray-400 mt-1">Support Basic HTML Tags</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="font-bold text-gray-500 text-xs uppercase">Publikasi</h3>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="active" value="1" <?= $page->active ? 'checked' : '' ?> class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="text-gray-900 font-medium">Aktifkan Halaman</span>
                </label>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="font-bold text-gray-500 text-xs uppercase">Konfigurasi SEO</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" value="<?= old('meta_title', $page->meta_title) ?>" class="w-full rounded-lg border-gray-300 shadow-sm p-2 border text-sm" placeholder="Judul di Google">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm p-2 border text-sm" placeholder="Deskripsi di Google"><?= old('meta_description', $page->meta_description) ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // Auto Slug
    document.getElementById('titleInput').addEventListener('input', function(e) {
        let slug = e.target.value.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        document.getElementById('slugInput').value = slug;
    });
</script>
<?= $this->endSection() ?>
