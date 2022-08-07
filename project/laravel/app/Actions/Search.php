<?php

namespace App\Actions;

use DB;

class Search
{
    /**
     * Invoke the search action.
     *
     * @param string $modelName
     * @param array $searchOptions
     * @param array $relationships
     * @param array $joinData
     * @param int $companyId
     *
     * @return object
     *
     * @SuppressWarnings(PHPMD)
     */
    public function __invoke(String $modelName, array $searchOptions, array $relationships = null, array $joinData = null, int $companyId = null)
    {
        $model = $modelName;
        $query = $model::query();

        if ($relationships) {
            foreach ($relationships as $item) {
                $query->with($item);
            }
        }

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        if ($searchOptions['keyword'] != '') {
            $keyword = $searchOptions['keyword'];
            $query->where(function ($query) use ($searchOptions, $keyword) {
                $keywordOptions = $searchOptions['keywordOptions'];
                $relation = null;
                $relationKeywordOptions = [];

                if (isset($searchOptions['relation'])) {
                    $relation = $searchOptions['relation'];
                    $relationKeywordOptions = $searchOptions['relationKeywordOptions'];
                }

                foreach ($keywordOptions as $column) {
                    $query->orWhere($column, 'like', '%'.$keyword.'%');
                }

                if ($relation) {
                    foreach ($relationKeywordOptions as $column) {
                        $query->orWhereHas($relation, function ($query) use ($keyword, $column) {
                            $query->where($column, 'like', '%'.$keyword.'%');
                        });
                    }
                }
            });
        }

        if (isset($searchOptions['filterOptions']) && $searchOptions['filterOptions']) {
            foreach ($searchOptions['filterOptions'] as $column => $value) {
                if ($value != '') {
                    $relation = false;
                    if ($joinData) {
                        foreach ($joinData as $key => $option) {
                            if (isset($option['filterFields'][$column])) {
                                $relation = true;
                                $relationshipName = $searchOptions['relation'];
                                $relationColumn = $option['filterFields'][$column];

                                $query->orWhereHas($relationshipName, function ($query) use ($value, $relationColumn) {
                                    $query->where($relationColumn, $value);
                                });
                            }
                        }
                    }

                    if (! $relation) {
                        if ($column == 'created_at') {
                            $query->where(DB::raw('DATE(created_at)'), $value);
                        }

                        if ($column != 'created_at') {
                            $query->where($column, $value);
                        }
                    }
                }
            }
        }

        if ($searchOptions['sortOption'] != '') {
            $relationSort = false;

            if ($joinData) {
                foreach ($joinData as $key => $option) {
                    if ($key == $searchOptions['sortOption']) {
                        $relationSort = true;
                        $relationModel = $option['relation'];
                        $sortOrder = $searchOptions['sortOrder'];

                        $query->orderBy($relationModel::select($option['field'])
                    ->whereColumn($option['table'].'.'.$option['tableField'], $option['relationTable'].'.'.$option['relationField']), $sortOrder);
                    }
                }
            }

            if (! $relationSort) {
                $query->orderBy($searchOptions['sortOption'], $searchOptions['sortOrder']);
            }
        }

        $records = $query->paginate($searchOptions['perPageCount']);

        return $records;
    }
}
