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
 * @property int $idStudent
 * @property int $idTeam
 * @property Student $student
 * @property Team $team
 */
class TeamMember extends Model
{
    /**
     * @var array
     */
    public $timestamps = false;
    protected $fillable = [];

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
    public function team()
    {
        return $this->belongsTo('App\Team', 'idTeam', 'idTeam');
    }
}
