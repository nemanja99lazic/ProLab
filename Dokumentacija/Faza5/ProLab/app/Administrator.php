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
 * @property int $idAdministrator
 * @property User $user
 */
class Administrator extends Model
{
    /**
     * Primarni kljuc za administratora.
     *
     * @var string
     */
    protected $primaryKey = 'idAdministrator';

    /**
     * Govori da li je potrebno ubacivati u bazu vremenske odrednice pri ubacivanju podataka.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Polja koja je moguce izmeniti u datom modelu.
     *
     * @var array
     */
    protected $fillable = ['idAdministrator'];

    /**
     * Vraca objekat korisnika za datog administratora.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'idAdministrator', 'idUser');
    }
}
