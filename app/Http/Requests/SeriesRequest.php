<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesRequest extends FormRequest
{
    /**
     * Process uploaded image
     *
     * @return this
     */
    public function uploadSeriesImage()
    {
        if($this->image) {
            $uploadedImage = $this->image;
            $this->fileName = str_slug($this->title) . '.' . $uploadedImage->getClientOriginalExtension();

            $uploadedImage->storePubliclyAs('public/series', $this->fileName);
        }
        
        return $this;
    }

}
