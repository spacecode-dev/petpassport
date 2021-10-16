<?php


namespace App\PetPassport\Traits;


trait QueryElasticSearchTrait
{
    public function buildQuery(array $data) : array
    {
        $query = [];

        if (! empty($data['searchText'])) {
            $query['bool']['must']['wildcard']['_all_custom'] = '*' . $data['searchText'] . '*';
        }

        if (! empty($data['filter']) && is_array($data['filter'])) {
            foreach ($data['filter'] as $key => $value) {
                if (! empty($value)) {
                    $query['bool']['filter'][] = ['term' => [$key => $value]];
                }
            }
        }

        return $query;
    }
}
