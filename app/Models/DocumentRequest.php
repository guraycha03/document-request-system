<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    // Direct Model to use the 'requests' table
    protected $table = 'requests';

    /**
     * Mass-assignment allowlist: only the fields a student may provide.
     * user_id, requester_name, requester_email and status are written by the
     * controller from the signed-in account and must never be trusted from input.
     */
 protected $fillable = [
        'item_name',
        'quantity',
        'purpose',
    ];
}   