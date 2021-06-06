<?php
/**
 *
 * Autor: autogenerisan kod (izuzev komenatara)
 * kod generisan pomoću biblioteke sa sledećeg linka:
 * https://tony-stark.medium.com/laravel-generate-model-from-database-table-d6ab72e852ce
 */
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

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['username', 'password', 'email', 'userType'];


}
