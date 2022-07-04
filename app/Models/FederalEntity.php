<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FederalEntity extends Model
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
        'created_at',
        'updated_at',
    ];

    protected $appends = ['key'];

    public function getKeyAttribute() {
        return $this->id;
    }
}
