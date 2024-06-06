<?php

namespace App\Services\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    /**
     * @param Media $media
     * @return string
     * @throws \ReflectionException
     */
    public function getPath(Media $media): string
    {
        $model = $media->model;
        $modelName = (new \ReflectionClass($model))->getShortName();
        $modelNameSlug = Str::slug($modelName);
        $modelTitle = $model->title ? Str::slug($model->title) : Str::slug($model->body);

        return "{$modelNameSlug}/{$modelTitle}/{$media->getKey()}/";
    }

    /**
     * @param Media $media
     * @return string
     * @throws \ReflectionException
     */
    public function getPathForConversions(Media $media): string
    {
        $model = $media->model;
        $modelName = (new \ReflectionClass($model))->getShortName();
        $modelNameSlug = Str::slug($modelName);
        $modelTitle = $model->title ? Str::slug($model->title) : Str::slug($model->body);

        return "{$modelNameSlug}/{$modelTitle}/{$media->getKey()}/conversions/";
    }

    /**
     * @param Media $media
     * @return string
     * @throws \ReflectionException
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        $model = $media->model;
        $modelName = (new \ReflectionClass($model))->getShortName();
        $modelNameSlug = Str::slug($modelName);
        $modelTitle = $model->title ? Str::slug($model->title) : Str::slug($model->body);

        return "{$modelNameSlug}/{$modelTitle}/{$media->getKey()}/responsive/";
    }
}
