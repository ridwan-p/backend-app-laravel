<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualLeave extends Model
{
    use HasFactory;

    const STATUS = [
        'pending' => 'pending',
        'approved' => 'approved',
        'rejected' => 'rejected',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'description',
        'status',
    ];

    function user() {
        return $this->belongsTo(User::class);
    }
}
