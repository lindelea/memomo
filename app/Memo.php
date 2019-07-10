<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use ModelConfig;

    /**
     * Increment OFF
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * User
     * 1対1
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
