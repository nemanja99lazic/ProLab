<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idRequest
 * @property string $subjectName
 * @property int $idTeacher
 * @property Teacher $teacher
 * @property Teacher[] $teachers
 */
class NewSubjectRequest extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idRequest';

    /**
     * @var array
     */
    protected $fillable = ['subjectName', 'idTeacher'];

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
    public function teachers()
    {
        return $this->belongsToMany('App\Teacher', 'new_subject_requests_teaches', 'idRequest', 'idTeacher');
    }
}
