<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 1. L'import indispensable
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory; // 2. L'activation de la Factory (C'est ce qui manquait !)

    // Autoriser le remplissage automatique de ces colonnes
    protected $fillable = [
        'title',
        'company_name',
        'description',
        'user_id'
    ];

    // La relation : Une offre appartient à un utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications() {
        return $this->hasMany(Application::class);
    }
}