<?php

namespace App\Http\Controllers;

use App\Services\GeminiVisionService;
use Illuminate\Http\Request;

class AiScanController extends Controller
{
    public function __construct(private GeminiVisionService $gemini) {}

    /**
     * POST /api/ai/scan-gulma
     * Upload foto gulma → Gemini identifikasi → return JSON
     */
    public function scanGulma(Request $request)
    {
        $request->validate([
            'foto' => 'required|array|max:10',
            'foto.*' => 'image|max:5120',
        ]);

        if (!$this->gemini->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Gemini API Key belum dikonfigurasi. Silakan set GEMINI_API_KEY di file .env',
            ], 422);
        }

        $files = $request->file('foto');
        $imagesData = [];
        foreach($files as $file) {
            $imagesData[] = [
                'base64' => base64_encode(file_get_contents($file->getRealPath())),
                'mime' => $file->getMimeType()
            ];
        }

        $result = $this->gemini->identifyWeed($imagesData);

        return response()->json($result);
    }

    /**
     * POST /api/ai/scan-evaluasi
     * Upload 2 foto (sebelum & sesudah) → Gemini analisis → return JSON
     */
    public function scanEvaluasi(Request $request)
    {
        $request->validate([
            'foto_sebelum' => 'required|image|max:5120',
            'foto_sesudah' => 'required|image|max:5120',
        ]);

        if (!$this->gemini->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Gemini API Key belum dikonfigurasi.',
            ], 422);
        }

        $before   = $request->file('foto_sebelum');
        $after    = $request->file('foto_sesudah');
        $mime     = $before->getMimeType();

        $b64Before = base64_encode(file_get_contents($before->getRealPath()));
        $b64After  = base64_encode(file_get_contents($after->getRealPath()));

        $result = $this->gemini->analyzeEfektivitas($b64Before, $b64After, $mime);

        return response()->json($result);
    }
}
