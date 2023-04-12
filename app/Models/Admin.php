<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{

    // when creating this model, fillable lets you create it with an array of these fields
    protected $fillable = ['information_id'];

    // when making a response, hidden doesnt return these fields
    protected $hidden = ['information_id'];

    // removes the timestamps fields -> timestamps already in information
    public $timestamps = false;

    // uuid instead of normal increment
    use HasUuids;

    // ONE TO ONE: relation between admin and information
    // admin has foreign key information_id
    public function information(): BelongsTo
    {
        return $this->belongsTo(Information::class, 'information_id', 'id');
    }
}