<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Settlement extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'zone_type',
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

    public function settlementType()
    {
        return $this->hasOne(SettlementType::class);
    }
}
