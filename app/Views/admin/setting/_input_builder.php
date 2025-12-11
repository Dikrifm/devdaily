<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-b border-gray-100 pb-4 last:border-0">
    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-gray-700 capitalize">
            <?= str_replace('_', ' ', $item->key) ?>
        </label>
        <p class="text-xs text-gray-400 mt-1 font-mono"><?= $item->key ?></p>
    </div>
    
    <div class="md:col-span-2">
        <?php 
            $name = $type . '[' . $item->id . ']'; 
            $val  = esc($item->value);
        ?>

        <?php if ($item->type === 'text' || $item->type === 'number'): ?>
            <input type="<?= $item->type ?>" name="<?= $name ?>" value="<?= $val ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
        
        <?php elseif ($item->type === 'textarea'): ?>
            <textarea name="<?= $name ?>" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"><?= $val ?></textarea>
        
        <?php elseif ($item->type === 'boolean'): ?>
            <select name="<?= $name ?>" class="w-40 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 text-sm">
                <option value="1" <?= $item->value == '1' ? 'selected' : '' ?>>Aktif (True)</option>
                <option value="0" <?= $item->value == '0' ? 'selected' : '' ?>>Non-Aktif (False)</option>
            </select>

        <?php elseif ($item->type === 'password'): ?>
            <div class="relative" x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'" name="<?= $name ?>" value="<?= $val ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 text-sm font-mono bg-gray-50">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 px-3 flex items-center text-sm text-gray-500 hover:text-blue-600">
                    <span x-text="show ? 'Hide' : 'Show'">Show</span>
                </button>
            </div>

        <?php elseif ($item->type === 'image'): ?>
            <div class="flex items-center space-x-4">
                <?php if($item->value): ?>
                    <img src="<?= base_url($item->value) ?>" class="h-12 w-auto border p-1 rounded bg-gray-100">
                <?php endif; ?>
                <input type="file" name="file_<?= $type ?>_<?= $item->id ?>" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <input type="hidden" name="<?= $name ?>" value="<?= $val ?>">
            </div>
        <?php endif; ?>
    </div>
</div>
