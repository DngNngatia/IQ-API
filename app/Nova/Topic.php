<?php

namespace App\Nova;

use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Topic extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Topic';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name', 'topic_name')
                ->rules('required'),
            File::make('Topic', 'topic_avatar_url')
                ->store(function (Request $request, $model) {
                    if ($request->hasFile("topic_avatar_url")) {
                        $extension = $request["topic_avatar_url"]->getClientOriginalExtension();
                        $fileName = md5(uniqid()) . '.' . $extension;
                        $path = $request["topic_avatar_url"]->storeAs('/topic', $fileName, [
                            'disk' => 'public',
                            'visibility' => 'public'
                        ]);
                        $model->topic_avatar_url = Storage::url($path);
                        return $model->topic_avatar_url;
                    }
                })->rules('required')->onlyOnForms(),
            Textarea::make('description')
            ->rules('required'),
            HasMany::make('subject')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
