<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo_path', 'description', 'website_url', 'category', 'status', 'sort_order',
    ];

    public const CATEGORY_LABELS = [
        'ciencia_politica' => 'Ciência, Educação e Política Científica',
        'edicao_indexacao' => 'Edição Científica e Indexação',
        'ciencia_aberta' => 'Ciência Aberta e Repositórios',
        'africa_lusofonia' => 'África e Países Lusófonos',
    ];

    public function logoUrl(): ?string
    {
        return $this->logo_path ? Storage::disk('public')->url($this->logo_path) : null;
    }
}
