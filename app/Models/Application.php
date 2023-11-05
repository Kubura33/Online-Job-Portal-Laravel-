<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'user_id');

    }
    public function job() : BelongsTo{
        return $this->belongsTo(JobAd::class, 'job_ad_id');
    }
    public function setStatus($number) : void{
        $this->update(['denied' => $number]);
    }
}
