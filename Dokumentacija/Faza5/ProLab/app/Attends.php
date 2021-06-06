<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idStudent
 * @property int $idSubject
 * @property Student $student
 * @property Subject $subject
 */
class Attends extends Model
{
    /**
     * @var array
     */
    protected $fillable = [];

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
     *  Proverava da li student pohadja predmet
     * 
     * @param int idStudentCheck id studenta za proveru
     * @param int idSubjectCheck id predmeta za proveru
     * 
     * @return boolean true - pohadja predmet; false- ne pohadja predmet
     * 
     * - Nemanja Lazic 2018/0004
     */
    public static function studentAttendsSubjectTest($idStudentCheck, $idSubjectCheck)
    {
        $queryResult = Attends::where('idStudent', '=', $idStudentCheck)->where('idSubject', "=", $idSubjectCheck)->get();
        if(!($queryResult->isEmpty()))
            return true;
        return false;

    }
}
