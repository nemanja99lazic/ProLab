<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idStudent
 * @property string $index
 * @property User $user
 * @property Subject[] $subjects
 * @property HasAppointment[] $hasAppointments
 * @property SubjectJoinRequest[] $subjectJoinRequests
 * @property Team[] $teams
 * @property Team[] $teamss
 */
class Student extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idStudent';

    /**
     * @var array
     */
    protected $fillable = ['index'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasAppointments()
    {
        return $this->hasMany('App\HasAppointment', 'idStudent', 'idStudent');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leaderInTeams()
    {
        return $this->hasMany('App\Team', 'idLeader', 'idStudent');
    }
}
