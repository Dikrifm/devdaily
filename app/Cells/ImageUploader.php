<?php namespace App\Cells;

class ImageUploader {
    public $currentImage = ''; // URL gambar saat ini (untuk edit mode)
    public $theme = 'emerald';

    public function render() {
        return view('App\Cells\image_uploader_view', [
            'currentImage' => $this->currentImage,
            'theme' => $this->theme
        ]);
    }
}
