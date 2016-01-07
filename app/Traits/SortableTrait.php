<?php

namespace App\Traits;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;

trait SortableTrait {
    public function scopeSortable($query)
    {
        if(Input::has('s') && Input::has('o') && (!Input::has('sp') || Input::get('sp') == false))
        {
            return $query->orderBy(Input::get('s'), Input::get('o'));
        }
        else
        {
            return $query;
        }
    }

    /**
     * Sort dynamic properties
     *
     * @param $collection
     */
    public static function specialSort($collection)
    {
        if(Input::has('sp') && Input::get('sp') == true && Input::has('s'))
        {
            if(Input::get('o') === 'asc')
            {
                return $collection->sortBy(Input::get('s'));
            }
            else
            {
                return $collection->sortByDesc(Input::get('s'));
            }
        }
    }

    public static function link_to_sorting_action($col, $title = null, $special = false)
    {
        if(is_null($title))
        {
            $title = str_replace('_', ' ', $col);
            $title = ucfirst($title);
        }

        $indicator = (Input::get('s') == $col ? (Input::get('o') === 'asc' ? '&uarr;' : '&darr;') : null);
        $parameters = array_merge(Input::get(), [
            's' => $col,
            'o' => (Input::get('o') === 'asc' ? 'desc' : 'asc')
        ]);

        if($special)
        {
            $parameters = array_merge($parameters, [
                'sp' => true
            ]);
        }

        return link_to_route(Route::currentRouteName(), "$title $indicator", $parameters);
    }
}
