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
}
