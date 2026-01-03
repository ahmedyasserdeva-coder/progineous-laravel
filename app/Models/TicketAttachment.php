<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TicketAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'reply_id',
        'filename',
        'path',
        'disk',
        'size',
        'mime_type',
        'uploaded_by_client_id',
        'uploaded_by_admin_id',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    /**
     * Allowed file extensions
     */
    public const ALLOWED_EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'gif', 'webp',
        'pdf', 'doc', 'docx', 'txt', 'rtf',
        'xls', 'xlsx', 'csv',
        'zip', 'rar', '7z',
    ];

    /**
     * Maximum file size in bytes (10MB)
     */
    public const MAX_FILE_SIZE = 10 * 1024 * 1024;

    /**
     * Maximum files per upload
     */
    public const MAX_FILES_PER_UPLOAD = 5;

    /**
     * Get the ticket
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the reply
     */
    public function reply()
    {
        return $this->belongsTo(TicketReply::class, 'reply_id');
    }

    /**
     * Get the client who uploaded
     */
    public function uploadedByClient()
    {
        return $this->belongsTo(Client::class, 'uploaded_by_client_id');
    }

    /**
     * Get the admin who uploaded
     */
    public function uploadedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by_admin_id');
    }

    /**
     * Get the full URL to download the file
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    /**
     * Get human readable file size
     */
    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file extension
     */
    public function getExtensionAttribute(): string
    {
        return strtolower(pathinfo($this->filename, PATHINFO_EXTENSION));
    }

    /**
     * Check if file is an image
     */
    public function isImage(): bool
    {
        return in_array($this->extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    /**
     * Check if file is a document
     */
    public function isDocument(): bool
    {
        return in_array($this->extension, ['pdf', 'doc', 'docx', 'txt', 'rtf']);
    }

    /**
     * Get icon class based on file type
     */
    public function getIconClassAttribute(): string
    {
        return match(true) {
            $this->isImage() => 'text-green-500',
            in_array($this->extension, ['pdf']) => 'text-red-500',
            in_array($this->extension, ['doc', 'docx']) => 'text-blue-500',
            in_array($this->extension, ['xls', 'xlsx', 'csv']) => 'text-green-600',
            in_array($this->extension, ['zip', 'rar', '7z']) => 'text-yellow-500',
            default => 'text-gray-500',
        };
    }

    /**
     * Delete the file from storage
     */
    public function deleteFile(): bool
    {
        if (Storage::disk($this->disk)->exists($this->path)) {
            return Storage::disk($this->disk)->delete($this->path);
        }
        return true;
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Delete file when model is deleted
        static::deleting(function ($attachment) {
            $attachment->deleteFile();
        });
    }

    /**
     * Validate file extension
     */
    public static function isValidExtension(string $extension): bool
    {
        return in_array(strtolower($extension), self::ALLOWED_EXTENSIONS);
    }

    /**
     * Validate file size
     */
    public static function isValidSize(int $size): bool
    {
        return $size <= self::MAX_FILE_SIZE;
    }
}
