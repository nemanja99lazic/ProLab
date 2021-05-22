<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idTeacher
 * @property User $user
 * @property NewSubjectRequest[] $newSubjectRequests
 * @property NewSubjectRequest[] $newSubjectRequestss
 * @property Subject[] $subjects
 * @property Subject[] $subjectss
 */
class Teacher extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTeacher';

    /**
     * @var array
     */
    protected $fillable = ['idTeacher'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'idTeacher', 'idUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newSubjectRequest()
    {
        return $this->hasMany('App\NewSubjectRequest', 'idTeacher', 'idTeacher');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function newSubjectRequestss()
    {
        return $this->belongsToMany('App\NewSubjectRequest', 'new_subject_requests_teaches', 'idTeacher', 'idRequest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects()
    {
        return $this->hasMany('App\Subject', 'idTeacher', 'idTeacher');
    }

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjectss()
    {
        return $this->belongsToMany('App\Subject', 'teaches', 'idTeacher', 'idSubject');
    }
}
