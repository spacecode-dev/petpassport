<?php

namespace App\PetPassport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'messages';

    /**
     * @return array
     */
    public function searchableOptions()
    {
        return [
            'column' => 'searchable',
            'external' => true,
            'maintain_index' => true,
            'rank' => [
                'fields' => [
                    'body' => 'A',
                ],
                'weights' => [1.0],
                'function' => 'ts_rank',
                'normalization' => 32,
            ],
        ];
    }

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'body' => $this->body
        ];
    }

    /**
     * @var array
     */
    protected $hidden = [
        'searchable'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'recipient_id',
        'recipient_type',
        'body'
    ];

    /**
     * @return MorphTo
     */
    public function sender()
    {
        return $this->morphTo();
    }

    /**
     * @return MorphTo
     */
    public function recipient()
    {
        return $this->morphTo();
    }

    /**
     * @param $childType
     * @param $value
     * @param $field
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
