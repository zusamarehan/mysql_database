<?php

namespace App\Models;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            $connection->password = base64_encode(env('APP_KEY').$connection->password.env('APP_KEY'));
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
