<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Email extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable=['emailable_id','emailable_type	','	admin_user_id','sender','receiver','cc','content','created_at','updated_at'];
    
    public function emailable():MorphTo{
        return $this->morphTo();
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('emailAttachments')
            ->useDisk('emailAttachment');
    }        

}
