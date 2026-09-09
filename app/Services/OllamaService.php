<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OllamaService
{
    protected ?string $apiKey;
    protected string $baseUrl;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.ollama.key');
        $this->baseUrl = config('services.ollama.base_url', 'https://api.ollama.com');
        $this->model = config('services.ollama.model', 'gemma4:31b-cloud');
    }

    /**
     * Resolve the appropriate chat endpoint based on the base URL.
     */
    protected function getChatEndpoint(): string
    {
        $parsed = parse_url($this->baseUrl);
        $scheme = $parsed['scheme'] ?? 'https';
        $host = $parsed['host'] ?? 'api.ollama.com';
        $port = isset($parsed['port']) ? ':' . $parsed['port'] : '';
        
        return "{$scheme}://{$host}{$port}/api/chat";
    }

    /**
     * Test connection to Ollama API.
     */
    public function ping(): array
    {
        try {
            $endpoint = $this->getChatEndpoint();
            $response = Http::withToken($this->apiKey)
                ->timeout(15)
                ->post($endpoint, [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'user', 'content' => 'Ping. Jawab 1 kata: OK']
                    ],
                    'stream' => false,
                ]);

            if ($response->successful()) {
                return ['success' => true, 'message' => 'Connected successfully to Ollama Cloud'];
            }

            return [
                'success' => false,
                'message' => 'Ollama API returned status ' . $response->status() . ': ' . $response->body()
            ];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Ollama connection failed: ' . $e->getMessage()];
        }
    }

    /**
     * Generate structured B2B article draft using Ollama.
     */
    public function generateArticle(array $params): array
    {
        $serviceName = $params['service_name'] ?? 'Pelatihan & Sertifikasi K3';
        $category = $params['category'] ?? 'pelatihan';
        $cityName = $params['city_name'] ?? 'Nasional';
        $kecamatanName = $params['kecamatan_name'] ?? null;
        $topic = $params['topic'] ?? "Panduan Implementasi {$serviceName} di {$cityName}";
        $keyword = $params['target_keyword'] ?? "{$serviceName} {$cityName}";
        $intent = $params['search_intent'] ?? 'Informasional Komersial B2B';
        $tone = $params['tone'] ?? 'Professional B2B';
        $wordCount = $params['word_count'] ?? 1500;
        $extraInstructions = $params['additional_instructions'] ?? '';
        $seoOverride = $params['seo_override'] ?? null;

        $seoContext = '';
        if ($seoOverride) {
            $seoContext = "\n- Existing SEO Context (Override):\n" .
                          "    - Prioritas SEO Title: {$seoOverride['seo_title']}\n" .
                          "    - Prioritas Meta Description: {$seoOverride['meta_description']}\n" .
                          "    - Fokus Heading: {$seoOverride['custom_heading']}\n" .
                          "    - Poin Kunci Konten: {$seoOverride['custom_content']}\n" .
                          "    (Gunakan data override ini sebagai referensi utama untuk menjaga konsistensi strategi regional, namun tetap kembangkan menjadi artikel lengkap yang mendalam).";
        }

        $locationContext = $cityName;
        if ($kecamatanName) {
            $locationContext = "Kecamatan {$kecamatanName}, Kota/Kabupaten {$cityName}";
        }

        $systemPrompt = <<<PROMPT
Anda adalah Lead Technical Content Specialist dan Praktisi K3 (Keselamatan & Kesehatan Kerja) Senior di Indonesia.
Tugas Anda adalah menulis draf artikel mendalam, faktual, otoritatif, dan berstandar industri B2B dalam Bahasa Indonesia formal.

ATURAN KONTEN & KUALITAS:
1. Gaya bahasa: Profesional B2B, lugas, presisi teknis, mengalir alami.
2. DILARANG: Filler AI klise ("Di era modern saat ini", "tak dapat dipungkiri"), kalimat berulang, keyword stuffing.
3. DILARANG: Membuat klaim izin palsu, nomor SK bodong, atau data statistik fiktif.
4. Gunakan konteks regulasi nyata Indonesia yang relevan (misal UU No. 1/1970, PP 50/2012, Permenaker terkait, standar BNSP/SNI jika relevan).
5. Format Konten: Gunakan tag HTML semantik: <h2>, <h3>, <p>, <ul>, <ol>, <li>, <strong>, <table><thead><tr><th>...</th></tr></thead><tbody><tr><td>...</td></tr></tbody></table>, dan callout <blockquote>.
6. Artikel harus memiliki struktur lengkap:
   - Pendahuluan & Urgensi di Kawasan {$locationContext}
   - Dasar Regulasi & Kepatuhan Hukum Nasional
   - Penjelasan Komprehensif Program & Metodologi {$serviceName}
   - Tabel Parameter Teknis / Silabus / Rincian Operasional
   - Studi Kasus / Penerapan Praktis di Fasilitas Industri
   - Tanya Jawab (FAQ) Praktis
   - Ajakan Bertindak (CTA) Konsultasi Resmi Bersama TrainingKota

OUTPUT WAJIB:
Kembalikan HANYA dokumen JSON valid tanpa markdown code block ```json di sekitarnya.
Format skema JSON:
{
  "title": "Judul Artikel Menarik dan Otoritatif",
  "seo_title": "SEO Title Max 60 Karakter | TrainingKota",
  "meta_description": "Meta description persuasif max 155 karakter mengandung keyword dan ajakan tindakan.",
  "slug": "slug-url-ramah-seo",
  "excerpt": "Ringkasan eksekutif 2-3 kalimat mengenai intisari artikel.",
  "content": "<p>Isi artikel lengkap dalam HTML semantik...</p>",
  "suggested_faqs": [
    {"q": "Pertanyaan 1...", "a": "Jawaban ringkas dan padat 1..."},
    {"q": "Pertanyaan 2...", "a": "Jawaban ringkas dan padat 2..."}
  ],
  "suggested_internal_links": [
    {"text": "Teks Anchor", "url": "/{$category}"}
  ]
}
PROMPT;

        $userPrompt = <<<PROMPT
Silakan buat artikel lengkap dan mendalam dengan rincian berikut:
- Layanan K3: {$serviceName} (Kategori: {$category})
- Lokasi Target: {$locationContext}
- Topik Utama: {$topic}
- Target Keyword: {$keyword}
- Search Intent: {$intent}
- Nada Bahasa (Tone): {$tone}
- Target Panjang Kata: minimal {$wordCount} kata
- Instruksi Tambahan: {$extraInstructions}{$seoContext}

Pastikan artikel berbobot tinggi untuk pengambil keputusan perusahaan (HSE Manager, HRD, Direktur Operasional).
Keluarkan format HANYA JSON murni yang dapat di-parse oleh json_decode() PHP.
PROMPT;

        try {
            $endpoint = $this->getChatEndpoint();
            $response = Http::withToken($this->apiKey)
                ->timeout(120)
                ->post($endpoint, [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'stream' => false,
                ]);

            if (!$response->successful()) {
                Log::error('Ollama API Error: ' . $response->body());
                throw new \Exception('Ollama API Error [' . $response->status() . ']: ' . $response->body());
            }

            $body = $response->json();
            $rawContent = $body['message']['content'] ?? '';

            if (empty($rawContent)) {
                throw new \Exception('Ollama mengembalikan respon kosong.');
            }

            // Clean markdown fences if any
            $cleanedJson = trim($rawContent);
            if (str_starts_with($cleanedJson, '```json')) {
                $cleanedJson = substr($cleanedJson, 7);
            } elseif (str_starts_with($cleanedJson, '```')) {
                $cleanedJson = substr($cleanedJson, 3);
            }
            if (str_ends_with($cleanedJson, '```')) {
                $cleanedJson = substr($cleanedJson, 0, -3);
            }
            $cleanedJson = trim($cleanedJson);

            $parsed = json_decode($cleanedJson, true);

            if (!is_array($parsed) || empty($parsed['title'])) {
                // Fallback if model returned text instead of pure JSON
                return [
                    'success' => true,
                    'title' => $topic,
                    'seo_title' => Str::limit($topic . ' - TrainingKota', 60),
                    'meta_description' => Str::limit("Panduan {$serviceName} di {$locationContext}. Konsultasi resmi berstandar Kemnaker RI.", 155),
                    'slug' => Str::slug($topic),
                    'excerpt' => Str::limit(strip_tags($rawContent), 200),
                    'content' => nl2br(e($rawContent)),
                    'suggested_faqs' => [],
                    'suggested_internal_links' => [],
                    'raw' => $rawContent,
                ];
            }

            return array_merge(['success' => true], $parsed);
        } catch (\Throwable $e) {
            Log::error('OllamaService Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
