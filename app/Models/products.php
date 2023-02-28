<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_description',
        'section_id'
    ];
    /**
     * or can use
     * protected $guarded = [];
     */

    // to get sections name

    public function section(){
        return $this->belongsTo(sections::class);
    }
}
