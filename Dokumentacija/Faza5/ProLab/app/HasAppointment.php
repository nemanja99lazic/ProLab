<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idAppointment
 * @property int $idStudent
 * @property Appointment $appointment
 * @property Student $student
 * @property FreeAgent[] $freeAgents
 * @property FreeAgent[] $freeAgentss
 */
class HasAppointment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'has_appointment';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo('App\Appointment', 'idAppointment', 'idAppointment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Student', 'idStudent', 'idStudent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function freeAgents()
    {
        return $this->hasMany('App\FreeAgent', 'idAppointment', 'idAppointment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function freeAgentss()
    {
        return $this->hasMany('App\FreeAgent', 'idStudent', 'idStudent');
    }
}
