<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class BaseFilter
{
    protected $builder;
    protected $request;
    protected $form;

    public function __construct(Request $request, Builder $builder)
    {
        $this->request = $request;
        $this->builder = $builder;
    }

    public function apply()
    {
        foreach ($this->filters() as $method => $value) {
            if ($method == 'apply' || $method == 'getFiltersForm') continue;

            if ((method_exists($this, $method)) && $value) {
                $this->$method($value);
            }
        }

        return $this->builder;
    }

    private function filters()
    {
        return $this->request->all();
    }

}
