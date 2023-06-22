<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverablesCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function categories()
    {
        return $this->HasMany(userCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
