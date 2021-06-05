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
    protected $fillable = ['idTeacher', 'idSubject'];

    public $timestamps = false;

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

    /**
     * Provera da li profesor predaje predmet
     * 
     * @param int idTeacher 
     * @param int idSubject
     * 
     * @return boolean true - predaje; false - ne predaje
     */
    public static function teachesCheck($idTeacher, $idSubject)
    {
        $queryResult = Teaches::where('idTeacher', '=', $idTeacher)->where('idSubject', '=', $idSubject)->get();
        if(!($queryResult->isEmpty()))
            return true;
        return false;
    }
}
