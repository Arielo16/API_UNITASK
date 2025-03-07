<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    use HasFactory;

    protected $primaryKey = 'diagnosticID';

    protected $fillable = [
        'reportID',
        'description',
        'images',
        'status',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'reportID', 'reportID');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'diagnostic_material', 'diagnosticID', 'materialID')
                    ->withPivot('quantity');
    }
}
