<?php



declare(strict_types=1);



namespace BrianFaust\Friendable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Friend extends Model
{
    /**
     * @var string
     */
    public $table = 'friendships';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function sender(): MorphTo
    {
        return $this->morphTo('sender');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function recipient(): MorphTo
    {
        return $this->morphTo('recipient');
    }
}
