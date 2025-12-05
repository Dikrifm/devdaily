<?php namespace App\Libraries;

class GeminiAgent {
    private $apiKey;
    // UPDATED: MENGGUNAKAN GEMINI 2.5 FLASH (Valid per Juni 2025)
    // Model ini cepat & stabil. Tidak akan timeout di Termux.
    private $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct() {
        $this->apiKey = trim(getenv('GEMINI_API_KEY'));
    }

    public function analyzeDeal($productName, $marketPrice, $foundPrice, $storeName) {
        $client = \Config\Services::curlrequest();
        
        // Safety Check
        if (empty($this->apiKey)) {
            return "ERROR: API Key kosong. Masukkan di file .env";
        }

        // Kalkulasi Data
        $gap = $marketPrice - $foundPrice;
        $gapFmt = number_format(abs($gap), 0, ',', '.');
        
        // Logika Status untuk Prompt
        if ($gap > 0) {
            $status = "MURAH (Profit Rp $gapFmt)";
            $instruction = "Validasi deal ini sebagai potensi cuan, tapi tetap waspada barang palsu.";
        } else {
            $status = "MAHAL (Rugi Rp $gapFmt)";
            $instruction = "Roasting/Hina harga ini karena kemahalan. Pakai bahasa sarkas.";
        }

        // Prompt Efisien
        $prompt = "
        Role: AI Analis Pasar Black Market yang sarkas & to-the-point.
        Produk: $productName
        Pasar Wajar: Rp " . number_format($marketPrice, 0, ',', '.') . "
        Harga Toko '$storeName': Rp " . number_format($foundPrice, 0, ',', '.') . "
        Status: $status
        
        Tugas: Berikan 1 komentar singkat (max 20 kata) dalam Bahasa Indonesia Gaul/Sarkas.";

        try {
            $response = $client->post($this->endpoint, [
                'query' => ['key' => $this->apiKey],
                'json' => [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ],
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false,
                'timeout' => 25, // Flash sangat cepat, 25 detik lebih dari cukup
                'connect_timeout' => 10
            ]);

            $body = json_decode($response->getBody());
            $code = $response->getStatusCode();

            // Handle Response
            if ($code == 200) {
                return $body->candidates[0]->content->parts[0]->text ?? "AI Bisu (Format Response Berubah).";
            } else {
                // Jika masih error, baca pesan detail dari Google
                $reason = $body->error->message ?? "Unknown Error";
                return "GOOGLE REJECT ($code): $reason";
            }

        } catch (\Exception $e) {
            return "KONEKSI GAGAL: " . $e->getMessage();
        }
    }
}
