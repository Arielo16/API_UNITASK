<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $primaryKey = 'reportID';

    protected $fillable = [
        'folio',
        'buildingID',
        'roomID',
        'categoryID',
        'goodID',
        'priority',
        'description',
        'image',
        'id',
        'status',
        'requires_approval',
        'involve_third_parties',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'roomID', 'roomID');
    }
}
