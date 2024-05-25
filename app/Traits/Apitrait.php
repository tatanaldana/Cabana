<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait Apitrait{
    public function scopeIncluded(Builder $query){

        $allowincluded = $this->allowincluded;

        if(empty($allowincluded) || empty(request('included'))){
            return;

        }

        $relations=explode(',',request('included'));

        $allowincluded=collect($this->allowincluded);
        foreach($relations as $key=>$relationship){
            if (!$allowincluded->contains($relationship)){
                unset($relations[$key]);
            }
        }

        $query->with($relations);

        return $query;
    }

    public function scopeFilter(Builder $query){

        $allowfilter = $this->allowfilter;
        
        if(empty($allowfilter) || empty(request('filter'))){
            return;
        }

        $filters=request('filter');
        $allowfilter = collect($this->allowfilter);

        foreach($filters as $filter=>$value){
            if($allowfilter->contains($filter)){
                $query->where($filter,'LIKE','%'.$value.'%');
            }
        }

    }

    public function scopeSort(Builder $query){

        $allowsort = $this->allowsort;
        
        if(empty($allowsort) || empty(request('sort'))){
            return;
        }

        $sortfields=explode(',',request('sort'));
        $allowsort = collect($this->allowsort);

        foreach($sortfields as $sortfield){
            $direction='asc';
            if(substr($sortfield,0,1) == '-'){
                $direction='desc';
                $sortfield=substr($sortfield,1);
            }

            if($allowsort->contains($sortfield)){
                $query->orderBy($sortfield,$direction);
            }
        }

    }

    public function scopeGetOrPaginate(Builder $query){

        if(request('PerPage')){
            $perpage=intval(request('PerPage'));

            if($perpage){
                return $query->paginate($perpage);
            } 
        }

        return $query->get();
    }
}


