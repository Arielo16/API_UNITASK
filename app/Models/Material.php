<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $primaryKey = 'materialID';

    protected $fillable = [
        'name',
        'supplier',
        'quantity',
        'price',
        'diagnosticID',
        'created_at',
        'updated_at',
    ];

    public function diagnostics()
    {
        return $this->hasMany(Diagnostic::class, 'materialID');
    }
}
