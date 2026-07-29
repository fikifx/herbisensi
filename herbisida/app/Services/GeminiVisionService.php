<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiVisionService
{
    private string $apiKey;
    private string $model;
    private string $endpoint;

    public function __construct()
    {
        $this->apiKey   = config('services.gemini.key', '');
        $this->model    = config('services.gemini.model', 'gemini-1.5-flash');
        $this->endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/';
    }

    /**
     * Identifikasi gulma dari foto menggunakan Gemini Vision.
     */
    public function identifyWeed(string $base64Image, string $mimeType = 'image/jpeg'): array
    {
        $prompt = <<<PROMPT
Kamu adalah ahli agronomi perkebunan kelapa sawit Indonesia.
Analisis foto ini dan identifikasi gulma yang terlihat.

Berikan respons dalam format JSON berikut (tanpa markdown, hanya JSON murni):
{
  "nama": "nama gulma dalam bahasa Indonesia",
  "nama_latin": "nama ilmiah gulma",
  "kerapatan": "Rendah atau Sedang atau Tinggi",
  "herbisida": "nama herbisida yang direkomendasikan untuk perkebunan sawit",
  "dosis": 3.0,
  "confidence": 90,
  "deskripsi": "deskripsi singkat gulma dan alasan rekomendasi",
  "terdeteksi": true
}

Jika tidak ada gulma yang terdeteksi, set "terdeteksi": false dan isi field lainnya dengan null.
PROMPT;

        try {
            $response = Http::timeout(30)->post(
                $this->endpoint . $this->model . ':generateContent?key=' . $this->apiKey,
                [
                    'contents' => [[
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inlineData' => [
                                    'mimeType' => $mimeType,
                                    'data'     => $base64Image,
                                ],
                            ],
                        ],
                    ]],
                    'generationConfig' => [
                        'temperature'     => 0.2,
                        'maxOutputTokens' => 512,
                    ],
                ]
            );

            if ($response->successful()) {
                $text = $response->json('candidates.0.content.parts.0.text', '{}');
                $text = preg_replace('/```json\s*|\s*```/', '', $text);
                $data = json_decode(trim($text), true);
                if (json_last_error() === JSON_ERROR_NONE && isset($data['terdeteksi'])) {
                    return ['success' => true, 'data' => $data];
                }
            }

            Log::error('Gemini identifyWeed error', ['response' => $response->body()]);
            return ['success' => false, 'message' => 'Gagal menganalisis foto'];

        } catch (\Exception $e) {
            Log::error('Gemini exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Analisis efektivitas herbisida dari dua foto (sebelum & sesudah).
     */
    public function analyzeEfektivitas(string $base64Before, string $base64After, string $mimeType = 'image/jpeg'): array
    {
        $prompt = <<<PROMPT
Kamu adalah ahli agronomi perkebunan kelapa sawit Indonesia.
Bandingkan dua foto lahan ini: foto pertama SEBELUM aplikasi herbisida, foto kedua SESUDAH aplikasi herbisida (14 hari setelah aplikasi).

Berikan respons dalam format JSON berikut (tanpa markdown, hanya JSON murni):
{
  "efektivitas": 85,
  "kategori": "Cukup Efektif",
  "catatan": "penjelasan detail hasil pengendalian gulma",
  "penurunan_gulma_persen": 70
}

Kategori: "Sangat Efektif" (>90%), "Efektif" (75-90%), "Cukup Efektif" (50-75%), "Kurang Efektif" (<50%)
PROMPT;

        try {
            $response = Http::timeout(30)->post(
                $this->endpoint . $this->model . ':generateContent?key=' . $this->apiKey,
                [
                    'contents' => [[
                        'parts' => [
                            ['text' => $prompt],
                            ['inlineData' => ['mimeType' => $mimeType, 'data' => $base64Before]],
                            ['inlineData' => ['mimeType' => $mimeType, 'data' => $base64After]],
                        ],
                    ]],
                    'generationConfig' => ['temperature' => 0.2, 'maxOutputTokens' => 512],
                ]
            );

            if ($response->successful()) {
                $text = $response->json('candidates.0.content.parts.0.text', '{}');
                $text = preg_replace('/```json\s*|\s*```/', '', $text);
                $data = json_decode(trim($text), true);
                if (json_last_error() === JSON_ERROR_NONE && isset($data['efektivitas'])) {
                    return ['success' => true, 'data' => $data];
                }
            }

            return ['success' => false, 'message' => 'Gagal menganalisis foto'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && $this->apiKey !== 'your_gemini_api_key_here';
    }
}
