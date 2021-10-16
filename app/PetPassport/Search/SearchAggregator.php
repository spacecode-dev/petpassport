<?php


namespace App\PetPassport\Search;


class SearchAggregator
{
    /**
     * @var array
     */
    private $models;

    /**
     * SearchAggregator constructor.
     * @param array $models
     */
    function __construct(array $models = [])
    {
        $this->models = $models;
    }

    /**
     * @param string $query
     * @param int|null $categoryId
     * @param int|null $countryId
     * @param int|null $cityId
     * @return array
     */
    public function search(string $query = '', int $categoryId = null, int $countryId = null, int $cityId = null)
    {
        $result = [];
        $query = preg_replace("/\s+/", ':* | ', trim($query));
        $query .= ':*';

        foreach ($this->models as $model) {
            $model = new $model;
            $result[$model->table] = $model->search($query)->usingTsQuery()
                ->when(isset($countryId), function ($query) use ($countryId, $model) {
                    if (!empty($model->fillable) && in_array('country_id', $model->fillable)) {
                        $query->where('country_id', $countryId);
                    }
                })
                ->when(isset($cityId), function ($query) use ($cityId, $model) {
                    if (!empty($model->fillable) && in_array('city_id', $model->fillable)) {
                        $query->where('city_id', $cityId);
                    }
                })
                ->when(isset($categoryId), function ($query) use ($categoryId, $model) {
                    if (!empty($model->fillable) && in_array('category_id', $model->fillable)) {
                        $query->where('category_id', $categoryId);
                    }
                })
                ->get()
                ->take(50)
                ->toArray();
        }
        return $result;
    }
}
