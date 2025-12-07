<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'offer_id']; // Champs autorisés

    // Une candidature appartient à une offre
    public function offer() {
        return $this->belongsTo(Offer::class);
    }

    // Une candidature appartient à un étudiant (User)
    public function user() {
        return $this->belongsTo(User::class);
    }
}