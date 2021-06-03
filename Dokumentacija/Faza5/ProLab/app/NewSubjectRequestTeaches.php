<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idRequest
 * @property int $idTeacher
 * @property NewSubjectRequest $newSubjectRequest
 * @property Teacher $teacher
 */
class NewSubjectRequestTeaches extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'new_subject_requests_teaches';

    /**
     * @var array
     */
    protected $fillable = ['idRequest', 'idTeacher'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function newSubjectRequest()
    {
        return $this->belongsTo('App\NewSubjectRequest', 'idRequest', 'idRequest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'idTeacher', 'idTeacher');
    }
}
