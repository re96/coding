<?php

namespace App\Domain\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Domain\User\Contracts\UserInterface;
use App\Domain\Order\Models\Order;

class User extends Authenticatable implements UserInterface
{
    use HasApiTokens;

    /**
     * Table name
     */
    protected $table = 'users';

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
        //
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
        'name',
        'nickname',
        'password',
        'phone',
        'email',
        'gender',
        'created_at',
    ];

    /**
     * The attributes that should be hidden
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
        return $this->where('email', $username)->first();
    }

    /**
     * 관련된 주문 정보를 반환합니다.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    /**
     * 관련된 가장 최근 주문 정보를 반환합니다.
     */
    public function latestOrder()
    {
        return $this->hasOne(Order::class, 'user_id', 'id')->latestOfMany();
    }
}
