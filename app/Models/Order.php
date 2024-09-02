<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'mobile',
        'date',
        'timing',
        'sider',
        'bridal',
        'address',
        'comment',
        'price',
        'status',
        'is_deleted',
        'my_earning',
        'is_paid'
    ];


    public function MembersData(){
        return $this->hasMany(Members::class,'order_id');
    }

    public function DesignImages(){
        return $this->hasMany(DesignImages::class,'order_id');
    }
}
