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
    ];

    public function diagnostics()
    {
        return $this->belongsToMany(Diagnostic::class, 'diagnostic_material', 'materialID', 'diagnosticID');
    }
}
