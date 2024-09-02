<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignImages extends Model
{
    use HasFactory;
    protected $table = 'design_images';
    protected $fillable = [
        'order_id',
        'image',
    ];
}
