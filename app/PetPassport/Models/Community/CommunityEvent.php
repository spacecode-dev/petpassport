<?php

namespace App\PetPassport\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityEvent extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'community_events';

    /**
     * @var array
     */
    protected $fillable = [
        'community_id',
        'name',
        'description',
        'start_at',
        'end_at'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'searchable'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'start_at',
        'end_at'
    ];

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
                    'name' => 'A',
                    'description' => 'D'
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
            'description' => $this->description,
            'name' => $this->name,
        ];
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
