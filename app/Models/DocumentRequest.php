<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['requestor_name', 'document_type', 'purpose', 'status'])]
class DocumentRequest extends Model
{
    //
}
