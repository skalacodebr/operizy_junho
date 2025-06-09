<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralTransactionOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'req_amount',
        'req_user_id',
        'status',
        'date',
    ];

    public function getCompany()
    {
        return $this->hasOne('App\Models\User', 'id', 'req_user_id');
    }

    public static $status = [
        'Rejected',
        'In Progress',
        'Approved',
    ];
}
