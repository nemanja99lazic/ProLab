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
    public $timestamps = false;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        date();
        return $this->belongsTo('App\Appointment', 'idDesiredAppointment', 'idAppointment');
    }
}
