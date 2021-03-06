<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Municipality extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['key'];

    public function getKeyAttribute() {
        return $this->id;
    }
}
