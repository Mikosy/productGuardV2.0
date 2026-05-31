<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'state',
        'password',
        
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    // A user (Dealer/Farmer) can have many bags in their inventory
    public function fertilizerBags()
    {
        // A user (Dealer/Farmer) can have many bags in their inventory
        return $this->hasMany(FertilizerBag::class);
    }
    public function assignToDealer(Request $request, FertilizerBag $bag)
    {
        $bag->update([
            'user_id' => $request->dealer_id,
            'status' => 'in_transit',
            'dispatched_at' => now(),
        ]);
        
        return back()->with('success', "Bag {$bag->tag_number} dispatched to Dealer.");
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
