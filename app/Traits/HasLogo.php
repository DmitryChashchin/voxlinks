<?php

declare(strict_types=1);

namespace App\Traits;

use Nette\Utils\Image;
use Illuminate\Support\Facades\Storage;

trait HasLogo
{
    /**
     * Get the URL for the model's image preview.
     */
    public function getImagePreviewUrl()
    {
        if ($this->image) {
            return Storage::url($this->image) . '?preview';
        }

        return null;
    }

    /**
     * Get the URL for the original model image.
     */
    public function getImageUrl()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }

        return null;
    }

    /**
     * Set the model's image attribute and generate a preview.
     */
    public function setImageAttribute($value)
    {
        if ($value) {
            $image = Image::make($value);
            $filename = uniqid() . '.' . $value->getClientOriginalExtension();
            Storage::put($filename, $image->fit(150)->stream());
            $this->attributes['image'] = $filename;
        } else {
            $this->attributes['image'] = null;
        }
    }

    /**
     * Delete the model's image and preview.
     */
    public function deleteImage()
    {
        if ($this->image) {
            Storage::delete([$this->image, $this->image . '?preview']);
            $this->image = null;
            $this->save();
        }
    }
}
