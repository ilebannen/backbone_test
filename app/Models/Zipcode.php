<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Zipcode extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'zip_code',
        'locality',
        'federal_entity_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'federal_entity_id',
        'municipality_id',
        'created_at',
        'updated_at',
    ];

    public function federalEntity()
    {
        return $this->hasOne(FederalEntity::class, 'id', 'federal_entity_id');
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'zipcode_id', 'id');
    }

    public function municipality()
    {
        return $this->hasOne(Municipality::class, 'id', 'municipality_id');
    }

}
