<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliverables extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'semester_id',
        'school_year_id',
        'file',
        'status',
        'deliverables_category_id'
    ];

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 0:
                return 'Pending';
            case 1:
                return 'Approved';
            case 2:
                return 'Rejected';
            default:
                return 'Unknown';
        }
    }

    public function deliverables()
    {
        return $this->hasMany(userCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    public function category()
    {
        return $this->belongsTo(DeliverablesCategory::class,'deliverables_category_id');
    } 
}
