<?php
// app/Models/Document.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'document_number',
        'description',
        'hash',
        'file_path',
        'qr_code_path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get full URL untuk signature file
     */
    public function getSignatureUrlAttribute(): string
    {
        return $this->file_path ? Storage::url($this->file_path) : '';
    }

    /**
     * Get full URL untuk QR code
     */
    public function getQrCodeUrlAttribute(): string
    {
        return $this->qr_code_path ? asset('storage/' . $this->qr_code_path) : '';
    }

    /**
     * Get verification URL
     */
    public function getVerificationUrlAttribute(): string
    {
        return route('verify.id', $this->id);
    }

    /**
     * Scope untuk mencari dokumen berdasarkan query
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('document_number', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeDateRange($query, $startDate = null, $endDate = null)
    {
        return $query->when($startDate, function ($q) use ($startDate) {
            return $q->whereDate('created_at', '>=', $startDate);
        })->when($endDate, function ($q) use ($endDate) {
            return $q->whereDate('created_at', '<=', $endDate);
        });
    }

    /**
     * Boot method untuk cleanup files saat model dihapus
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($document) {
            // Cleanup files ketika dokumen dihapus
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            if ($document->qr_code_path) {
                $fullPath = public_path('storage/' . $document->qr_code_path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        });
    }
}