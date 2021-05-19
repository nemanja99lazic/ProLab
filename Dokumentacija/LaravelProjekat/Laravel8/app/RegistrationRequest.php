<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idRegistrationRequest
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $userType
 */
class RegistrationRequest extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idRegistrationRequest';

    /**
     * @var array
     */
    protected $fillable = ['username', 'password', 'email', 'userType'];

}
