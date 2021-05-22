<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idTeacher
 * @property int $idSubject
 * @property Subject $subject
 * @property Teacher $teacher
 */
class Teaches extends Model
{
    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'idSubject', 'idSubject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'idTeacher', 'idTeacher');
    }
}
