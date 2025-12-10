<?php namespace App\Cells;

class MagicInput {
    // ID elemen target di form utama yang akan diisi otomatis
    public $targetName = 'nameField';
    public $targetPrice = 'priceField';
    public $targetLink = 'linkField'; // Opsional untuk form link
    public $theme = 'emerald';

    public function render() {
        return view('App\Cells\magic_input_view', [
            'targetName' => $this->targetName,
            'targetPrice' => $this->targetPrice,
            'targetLink' => $this->targetLink,
            'theme' => $this->theme
        ]);
    }
}
