<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'userdata';
    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'username',
        'fullname',
        'email',
        'age',
        'password',
        'isadmin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'isadmin' => 'boolean',
        ];
    }
    
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }
    
    public function isSeller()
    {
        return $this->isadmin == 1;
    }
}
