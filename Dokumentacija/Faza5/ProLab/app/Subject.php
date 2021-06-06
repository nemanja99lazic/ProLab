<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idSubject
 * @property string $name
 * @property string $code
 * @property int $idTeacher
 * @property Teacher $teacher
 * @property Student[] $students
 * @property LabExercise[] $labExercises
 * @property Project[] $projects
 * @property SubjectJoinRequest[] $subjectJoinRequests
 * @property Teacher[] $teachers
 */
class Subject extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idSubject';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'idTeacher'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'idTeacher', 'idTeacher');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany('App\Student', 'attends', 'idSubject', 'idStudent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labExercises()
    {
        return $this->hasMany('App\LabExercise', 'idSubject', 'idSubject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany('App\Project', 'idSubject', 'idSubject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjectJoinRequests()
    {
        return $this->hasMany('App\SubjectJoinRequest', 'idSubject', 'idSubject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers()
    {
        return $this->belongsToMany('App\Teacher', 'teaches', 'idSubject', 'idTeacher');
    }
}
