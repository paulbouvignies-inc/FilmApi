<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $table = 'films';

    public $timestamps = false;

    protected $fillable = [
        'nom',
        'synopsis',
        'note',
        'date_de_sortie',
        'poster'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


}
