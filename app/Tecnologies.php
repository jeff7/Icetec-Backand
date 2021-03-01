<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tecnologies extends Model
{
    protected $table = 'tecnologies';
    
    protected $fillable = [
        'candidate_id','description', 'id_tec'
    ];

    /**
     * Get the user that owns the Tecnologies
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
