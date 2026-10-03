<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    // Direct Model to use the 'requests' table
    protected $table = 'requests';

    protected $fillable = [
        'requester_name',
        'requester_email',
        'item_name',
        'quantity',
        'purpose',
        'status',
    ];
}