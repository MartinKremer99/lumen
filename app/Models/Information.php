<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Information extends Model
{
    protected $fillable = ['first_name', 'last_name', "email"];
    protected $hidden = ['password', 'token'];

    use HasUuids;

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

}