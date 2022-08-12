<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function documentType(){
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function attachements(){
        return $this->hasMany(DocumentAttachement::class, 'document_id');
    }
}
