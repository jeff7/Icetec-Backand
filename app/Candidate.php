<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    //
    protected $table = 'candidate';
    
    protected $fillable = [
        'name', 'email', 'age', 'linkdin_url', 'id_tec'
    ];

    /**
     * Get all of the comments for the Candidate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tecnologies()
    {
        return $this->hasMany(Tecnologies::class);
    }
}
