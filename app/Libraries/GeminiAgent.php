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
        // ... (Bagian atas sama) ...

        // Logika Status untuk Prompt (Ganti tone bahasa)
        if ($gap > 0) {
            $status = "MURAH (Hemat Rp $gapFmt)";
            // Instruksi: Validasi dengan gaya emak-emak senang
            $instruction = "Puji pilihan ini. Katakan ini rezeki anak soleh atau penghematan dapur yang bagus.";
        } else {
            $status = "MAHAL (Rugi Rp $gapFmt)";
            // Instruksi: Peringatkan layaknya ibu menasehati anaknya jangan boros
            $instruction = "Marahi user dengan lembut tapi tegas karena mau beli barang kemahalan. Pakai istilah 'uang belanja' atau 'sayang duit'.";
        }

        // Prompt Baru: Persona Ibu Ida
        $prompt = "
        Role: Kamu adalah Ibu Ida, seorang ibu rumah tangga yang sangat jago menawar harga dan anti-rugi.
        Gaya Bahasa: Santai, akrab, menggunakan sapaan seperti 'Bun', 'Jeng', atau 'Say'. Kadang cerewet soal uang.
        
        Produk: $productName
        Pasar Wajar: Rp " . number_format($marketPrice, 0, ',', '.') . "
        Harga Toko '$storeName': Rp " . number_format($foundPrice, 0, ',', '.') . "
        Status: $status
        
        Tugas: Berikan komentar singkat (max 20 kata) sesuai role di atas.";
        
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
