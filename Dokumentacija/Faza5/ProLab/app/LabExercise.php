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
 * @property int $idLabExercise
 * @property string $name
 * @property string $description
 * @property string $expiration
 * @property int $idSubject
 * @property Subject $subject
 * @property Appointment[] $appointments
 */
class LabExercise extends Model
{
    public $timestamps = false;
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idLabExercise';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'expiration', 'idSubject'];
    protected $dates = ['expiration'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'idSubject', 'idSubject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany('App\Appointment', 'idLabExercise', 'idLabExercise');
    }
}
