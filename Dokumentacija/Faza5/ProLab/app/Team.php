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
 * @property int $idTeam
 * @property string $name
 * @property boolean $locked
 * @property int $idProject
 * @property int $idLeader
 * @property Student $student
 * @property Project $project
 * @property Student[] $students
 */
class Team extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTeam';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['name', 'locked', 'idProject', 'idLeader'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Student', 'idLeader', 'idStudent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'idProject', 'idProject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany('App\Student', 'team_members', 'idTeam', 'idStudent');
    }
}
