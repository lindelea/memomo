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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['updated_at_for_human'];

    /**
     * User
     * 1対1
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 人のために更新時間
     * @return string
     */
    public function getUpdatedAtForHumanAttribute()
    {
        return $this->attributes['updated_at_for_human'] = $this->updated_at->diffForHumans();
    }
}
