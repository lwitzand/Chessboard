<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Chessboard;
use App\Models\Tile;

class Piece extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'pieces';

    protected $fillable = [
        'id',
        'name',
        'identifier'
    ];

    public function chessboard()
    {
        return $this->belongsTo(Chessboard::class);
    }

    public function tile()
    {
        return $this->hasOne(Tile::class);
    }
}
