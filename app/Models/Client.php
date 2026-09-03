<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



#[Fillable(['user_id','client_name', 'email', 'phone_number'])]

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'client_name', 'email','phone_number', ];


     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    

    public function invoices(): HasMany{
        return $this->hasMany(Invoice::class);
    }
}
