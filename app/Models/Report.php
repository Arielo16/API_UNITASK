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
        'userID',
        'status',
        'requires_approval',
        'involve_third_parties',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'roomID', 'roomID');
    }

    public function good()
    {
        return $this->belongsTo(Good::class, 'goodID', 'goodID');
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'buildingID', 'buildingID');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID', 'categoryID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
}
