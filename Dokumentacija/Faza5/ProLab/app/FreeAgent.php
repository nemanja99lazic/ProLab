<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idStudent
 * @property int $idAppointment
 * @property int $idDesiredAppointment
 * @property HasAppointment $hasAppointment
 * @property Appointment $appointment
 * @property HasAppointment $hasAppointment
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
    public function hasAppointment()
    {
        return $this->belongsTo('App\HasAppointment', 'idAppointment', 'idAppointment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo('App\Appointment', 'idDesiredAppointment', 'idAppointment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hasAppointment()
    {
        return $this->belongsTo('App\HasAppointment', 'idStudent', 'idStudent');
    }
}
