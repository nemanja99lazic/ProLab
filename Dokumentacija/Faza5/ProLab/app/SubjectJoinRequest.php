<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idRequest
 * @property int $idSubject
 * @property int $idStudent
 * @property Student $student
 * @property Subject $subject
 */
class SubjectJoinRequest extends Model
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
    protected $fillable = ['idSubject', 'idStudent'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Student', 'idStudent', 'idStudent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'idSubject', 'idSubject');
    }

    public static function studentRequestedToJoinTest($idStudentCheck, $idSubjectCheck)
    {
        $queryResult = SubjectJoinRequest::where('idStudent', '=', $idStudentCheck)->where('idSubject', "=", $idSubjectCheck)->get(); 
        if(!($queryResult->isEmpty()))
            return true;
        return false;
    }
}
