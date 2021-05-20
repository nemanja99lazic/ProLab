<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idTeacher
 * @property User $user
 * @property NewSubjectRequest[] $newSubjectRequests
 * @property NewSubjectRequest[] $newSubjectRequests
 * @property Subject[] $subjects
 * @property Subject[] $subjects
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
    protected $fillable = [];

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
    public function newSubjectRequests()
    {
        return $this->hasMany('App\NewSubjectRequest', 'idTeacher', 'idTeacher');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function newSubjectRequests()
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'teaches', 'idTeacher', 'idSubject');
    }
}
