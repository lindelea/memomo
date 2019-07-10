<?php

namespace App;

use Illuminate\Support\Str;

trait ModelConfig
{
    /**
     * Model 設定
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    /**
     * カラム配列で取得
     * @return array
     */
    public function attributes()
    {
        return $this->attributesToArray();
    }
}