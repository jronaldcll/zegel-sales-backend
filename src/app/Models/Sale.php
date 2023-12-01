<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    /**
     * Override fillable property data.
     *
     * @var array
     */
    protected $fillable = [
        'client',
        'operation_date',
        'expiration_date',
        'payment_condition',
        'currency',
        'sale_detail',
        'subtotal',
        'igv',
        'total',
        'comment',
        'user_id'
    ];

    protected $casts = [
        'sale_detail' => 'array',     // Por ejemplo, castear a tipo de dato arreglo
    ];

    /**
     * User
     *
     * Get User Uploaded By Product
     *
     * @return object
     */
    public function user(): object
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email');
    }

}
