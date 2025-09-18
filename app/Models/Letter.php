<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $fillable = [
        'nomor_surat',
        'judul',
        'kategori_id',
        'tanggal_surat',
        'file_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}
