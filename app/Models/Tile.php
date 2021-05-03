<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Chestboard;
use App\Models\Piece;

class Tile extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'tiles';

    protected $fillable = [
        'file',
        'rank'
    ];

    protected $attributes = [
        'save' => True
    ];

    protected $files = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
    protected $ranks = [1, 2, 3, 4, 5, 6, 7, 8];

    public function getCoordinateAttribute()
    {
        return "{$this->file}{$this->rank}";
    }

    public function chessboard()
    {
        return $this->belongsTo(Chessboard::class);
    }

    public function piece()
    {
        return $this->hasOne(Piece::class);
    }
}
