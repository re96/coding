<?php

namespace App\Domain\Order\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Table name
     */
    protected $table = 'orders';

    /**
     * PK column name
     */
    protected $primaryKey = 'id';

    /**
     * Timestamp
     */
    const UPDATED_AT = null;

    /**
     * The attributes that should be cast
     */
    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form
     */
    protected $appends = [
        //
    ];

    /**
     * The attributes that should be mass-assignable
     */
    protected $fillable = [
        'id',
        'user_id',
        'ord_no',
        'product_name',
        'paid_at',
        'created_at',
    ];

    /**
     * The attributes that should be hidden
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
}
