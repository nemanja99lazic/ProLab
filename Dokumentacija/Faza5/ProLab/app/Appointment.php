<?php
/**
 *
 * Autor: autogenerisan kod (izuzev komenatara)
 * kod generisan pomoću biblioteke sa sledećeg linka:
 * https://tony-stark.medium.com/laravel-generate-model-from-database-table-d6ab72e852ce
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idAppointment
 * @property string $name
 * @property string $classroom
 * @property int $capacity
 * @property string $location
 * @property string $datetime
 * @property int $idLabExercise
 * @property LabExercise $labExercise
 * @property FreeAgent[] $freeAgents
 * @property HasAppointment[] $hasAppointments
 */
class Appointment extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idAppointment';

    /**
     * @var string[]
     */
    protected $dates = ['datetime'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'classroom', 'capacity', 'location', 'datetime', 'idLabExercise'];
    public $timestamps = false;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function labExercise()
    {
        return $this->belongsTo('App\LabExercise', 'idLabExercise', 'idLabExercise');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function freeAgents()
    {
        return $this->hasMany('App\FreeAgent', 'idDesiredAppointment', 'idAppointment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasAppointments()
    {
        return $this->hasMany('App\HasAppointment', 'idAppointment', 'idAppointment');
    }
}
