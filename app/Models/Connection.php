<?php

namespace App\Models;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Connection extends Model
{
    use HasFactory, Uuidable;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'host', 'username', 'password', 'user_id'];

    protected static function booted()
    {
        static::saving(function ($connection) {
            if($connection->password !== null) {
                $connection->password = Hash::make($connection->password);
            }
        });

        static::creating(function ($connection) {
            $connection->user_id = auth()->user()->id;
        });
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
