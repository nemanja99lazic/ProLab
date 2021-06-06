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

    /**
     *  Proverava da li je student vec poslao zahtev za prijavu na predmet
     * 
     * @param int idStudentCheck - id studenta za proveru
     * @param int idSubjectCheck - id predmeta za proveru
     * 
     * @return boolean - true - vec poslao zahtev; false - nije poslao zahtev;
     * 
     * - Nemanja Lazic 2018/0004
     */
    public static function studentRequestedToJoinTest($idStudentCheck, $idSubjectCheck)
    {
        $queryResult = SubjectJoinRequest::where('idStudent', '=', $idStudentCheck)->where('idSubject', "=", $idSubjectCheck)->get(); 
        if(!($queryResult->isEmpty()))
            return true;
        return false;
    }
}
