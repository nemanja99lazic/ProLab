<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idUser
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $forename
 * @property string $surname
 * @property Administrator $administrator
 * @property Student $student
 * @property Teacher $teacher
 */
class User extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idUser';

    /**
     * @var array
     */
    protected $fillable = ['username', 'password', 'email', 'forename', 'surname'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function administrator()
    {
        return $this->hasOne('App\Administrator', 'idAdministrator', 'idUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student()
    {
        return $this->hasOne('App\Student', 'idStudent', 'idUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teacher()
    {
        return $this->hasOne('App\Teacher', 'idTeacher', 'idUser');
    }
}
