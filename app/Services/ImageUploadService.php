<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Allowed MIME types and corresponding extensions.
     */
    protected const ALLOWED_MIME_TYPES = [
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png' => ['png'],
        'image/webp' => ['webp'],
    ];

    protected const MAX_SIZE_KB = 5120; // 5MB

    /**
     * Ensure the uploads directory exists and is secured against script execution.
     */
    public function getUploadsPath(): string
    {
        $dir = public_path('uploads/articles');

        if (! is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $htaccess = public_path('uploads/.htaccess');
        if (! file_exists($htaccess)) {
            @file_put_contents(
                $htaccess,
                "# Disable PHP execution in uploads\n".
                "<FilesMatch \"\.(?i:php|phtml|php3|php4|php5|php7|php8|phps|phar|inc|cgi|pl|py|sh)$\">\n".
                "    Order Deny,Allow\n".
                "    Deny from all\n".
                "</FilesMatch>\n"
            );
        }

        $indexHtml = public_path('uploads/index.html');
        if (! file_exists($indexHtml)) {
            @file_put_contents(
                $indexHtml,
                '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><h1>Directory access is forbidden.</h1></body></html>'
            );
        }

        return $dir;
    }

    /**
     * Validate and store uploaded image.
     *
     * @return array{success: bool, url?: string, path?: string, error?: string}
     */
    public function storeImage(UploadedFile $file): array
    {
        // 1. Check upload errors
        if (! $file->isValid()) {
            return ['success' => false, 'error' => 'File gagal diunggah atau rusak: '.$file->getErrorMessage()];
        }

        // 2. Reject SVG unconditionally
        $clientExt = strtolower($file->getClientOriginalExtension());
        $mime = strtolower((string) $file->getMimeType());

        if ($clientExt === 'svg' || str_contains($mime, 'svg') || str_contains($mime, 'xml')) {
            return ['success' => false, 'error' => 'Format file SVG tidak diizinkan demi alasan keamanan.'];
        }

        // 3. Size check
        $sizeKb = $file->getSize() / 1024;
        if ($sizeKb > self::MAX_SIZE_KB) {
            return ['success' => false, 'error' => 'Ukuran gambar melebihi batas maksimal 5MB.'];
        }

        // 4. MIME validation against whitelist
        if (! isset(self::ALLOWED_MIME_TYPES[$mime])) {
            return ['success' => false, 'error' => 'Tipe file tidak valid. Hanya format JPG, PNG, dan WebP yang diizinkan.'];
        }

        // 5. Verify image content integrity with getimagesize
        $imageInfo = @getimagesize($file->getRealPath());
        if ($imageInfo === false) {
            return ['success' => false, 'error' => 'Isi file tidak terdeteksi sebagai gambar valid.'];
        }

        // 6. Enforce safe extension matching MIME
        $allowedExtensions = self::ALLOWED_MIME_TYPES[$mime];
        $safeExtension = in_array($clientExt, $allowedExtensions, true) ? $clientExt : $allowedExtensions[0];

        // 7. Generate random, unique name to prevent collisions and path traversal
        $randomName = Str::random(32).'.'.$safeExtension;
        $targetDir = $this->getUploadsPath();

        // 8. Move file securely
        $file->move($targetDir, $randomName);

        $relativePath = 'uploads/articles/'.$randomName;
        $url = '/'.$relativePath;

        return [
            'success' => true,
            'url' => $url,
            'path' => $relativePath,
        ];
    }
}
