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
        'settlement_type_id',
        'created_at',
        'updated_at',
        'pivot'
    ];

    protected $appends = ['key'];

    public function getKeyAttribute() {
        return $this->id;
    }

    public function settlementType()
    {
        return $this->hasOne(SettlementsType::class, 'id', 'settlement_type_id');
    }

    public function zipcodes()
    {
        return $this->belongsToMany(Zipcode::class, 'zipcode_settlement');
    }
}
