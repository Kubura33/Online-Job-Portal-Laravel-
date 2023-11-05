<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employer extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function imagePath() : Attribute{
        return new Attribute(
            get: fn() => \Storage::disk('employer')->url($this->image)
        );
    }
    public function recruiter() : HasMany{
        return $this->hasMany(Recruiter::class, 'employer_id');
    }
    public function job() : HasMany{
        return $this->hasMany(JobAd::class, 'employer_id');
    }

}
