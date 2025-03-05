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

    // Eliminar la relación con Report
}
