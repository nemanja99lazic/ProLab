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
 * @property int $idRequest
 * @property string $subjectName
 * @property int $idTeacher
 * @property Teacher $teacher
 * @property Teacher[] $teachers
 */
class NewSubjectRequest extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idRequest';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['idRequest', 'subjectName', 'idTeacher'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'idTeacher', 'idTeacher');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers()
    {
        return $this->belongsToMany('App\Teacher', 'new_subject_requests_teaches', 'idRequest', 'idTeacher');
    }
}
