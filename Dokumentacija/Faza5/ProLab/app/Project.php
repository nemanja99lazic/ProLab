<?php
/**
 *
 * Autor: autogenerisan kod (izuzev komenatara)
 * kod generisan pomoću biblioteke sa sledećeg linka:
 * https://tony-stark.medium.com/laravel-generate-model-from-database-table-d6ab72e852ce
 */
namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idProject
 * @property string $name
 * @property string $minMemberNumber
 * @property string $maxMemberNumber
 * @property string $expirationDate
 * @property int $idSubject
 * @property Subject $subject
 * @property Team[] $teams
 */
class Project extends Model
{
    public $timestamps = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idProject';

    /**
     * @var array
     */
    protected $fillable = ['idProject', 'name', 'minMemberNumber', 'maxMemberNumber', 'expirationDate', 'idSubject'];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'idSubject', 'idSubject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany('App\Team', 'idProject', 'idProject');
    }

    /**
     * @note da li je vreme za prijavu projekta isteklo
     * @return bool
     * @author zvk17
     */
    public function hasExpired():bool {
        $date = Carbon::parse($this->expirationDate);
        return $date->isPast();
    }

}
