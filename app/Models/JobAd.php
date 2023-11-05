<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobAd extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function employer():BelongsTo{
        return $this->belongsTo(Employer::class, 'employer_id');
    }
    public function applications() : HasMany{
        return $this->hasMany(Application::class, 'job_ad_id');
    }

}
