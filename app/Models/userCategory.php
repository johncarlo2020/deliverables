<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'deliverables_category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }



}
