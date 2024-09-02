<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAccess extends Model
{
    use HasFactory;

    protected $table = "tbl_admin_access";

    protected $fillable = [
        'admin_id',
        'module_id',
        'access_id',
    ];
}
