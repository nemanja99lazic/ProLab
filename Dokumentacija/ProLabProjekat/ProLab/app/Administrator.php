<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idAdministrator
 * @property User $user
 */
class Administrator extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idAdministrator';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'idAdministrator', 'idUser');
    }
}
