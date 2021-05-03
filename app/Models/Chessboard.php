<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Tile;

class Chessboard extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'chessboards';

    protected $fillable = [
        'id',
        'size'
    ];

    public function tiles()
    {
        return $this->hasMany(Tile::class);
    }
}
