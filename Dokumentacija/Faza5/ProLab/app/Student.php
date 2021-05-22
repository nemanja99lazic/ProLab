<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idStudent
 * @property string $index
 * @property User $user
 * @property Subject[] $subjects
 * @property Appointment[] $appointments
 * @property SubjectJoinRequest[] $subjectJoinRequests
 * @property Team[] $teams
 */
class Student extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idStudent';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['idStudent', 'index'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'idStudent', 'idUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'attends', 'idStudent', 'idSubject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appointments()
    {
        return $this->belongsToMany('App\Appointment', 'has_appointment', 'idStudent', 'idAppointment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjectJoinRequests()
    {
        return $this->hasMany('App\SubjectJoinRequest', 'idStudent', 'idStudent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany('App\Team', 'team_members', 'idStudent', 'idTeam');
    }
}
