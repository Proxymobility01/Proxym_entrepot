<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersEntrepot extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_entrepot_unique_id', 'nom','prenom','phone' ,'email',  'password','ville','photo',   'quartier', 'id_role_entite', 'id_entrepot',
    ];

    // Relation avec le rôle (un utilisateur a un rôle)
    public function role()
    {
        return $this->belongsTo(RoleEntite::class, 'id_role_entite');
    }

    // Relation avec l'agence (un utilisateur appartient à une agence)
    public function entrepot()
    {
        return $this->belongsTo(Entrepot::class, 'id_entrepot');
    }
}
