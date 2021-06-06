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
 * @property int $idHasAppointment
 * @property int $idStudent
 * @property int $idAppointment
 * @property Appointment $appointment
 * @property Student $student
 */
class HasAppointment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'has_appointment';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idHasAppointment';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['idStudent', 'idAppointment'];

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
}
