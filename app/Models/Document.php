<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'tbl_document';
    protected $fillable = [
        'business_id',
        'business_document_type',
        'personal_document_type',
        'document'
    ] ;
}
