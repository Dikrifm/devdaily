<?php

namespace App\Cells;

class ShopOption
{
    /**
     * Menerima parameter dari view_cell() dan meneruskannya ke View.
     */
    public function render($link, $marketPrice, $aiActive = false)
    {
        return view('cells/shop_option', [
            'link'        => $link,
            'marketPrice' => $marketPrice,
            'aiActive'    => $aiActive
        ]);
    }
}
