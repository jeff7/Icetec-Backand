<?php

namespace App\Repository;

class CandidateRepository extends AbstractRepository
{
    private $location;

    public function setlocation(array $data) : self
    {
        $this->location = $data;
        return $this;
    }

    public function getResult()
    {
        $location =$this->location;
        return $this->model->whereHas('tecnologies', function($q) use ($location){
                                        $q->where('id_tec',$location['id_tec']);
                                    });  
    }
}