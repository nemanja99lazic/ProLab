<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idHasAppointment
 * @property int $idDesiredAppointment
 * @property Appointment $appointment
 */
class FreeAgent extends Model
{
    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo('App\Appointment', 'idDesiredAppointment', 'idAppointment');
    }
}
