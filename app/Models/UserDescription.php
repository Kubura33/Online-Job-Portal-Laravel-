<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDescription extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function imagePath(): Attribute{
        return new Attribute(
            get: fn() => \Storage::disk('profile')->url($this->profile_image)
        );
    }
    protected function cvPath() : Attribute {
        return new Attribute(
          get: fn() => \Storage::disk('profile')->url($this->CV)
        );
    }
    protected function coverLetterPath() : Attribute {
        return new Attribute(
            get: fn() => \Storage::disk('profile')->url($this->cover_letter)
        );
    }
    public function user() : BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
}
