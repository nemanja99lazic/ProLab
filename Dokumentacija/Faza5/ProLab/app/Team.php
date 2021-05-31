<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idTeam
 * @property string $name
 * @property boolean $locked
 * @property int $idProject
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

    /**
     * @var array
     */
    protected $fillable = ['name', 'locked', 'idProject'];

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
