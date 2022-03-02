<?php

namespace App\Presenters\Presses;


use App\Models\Press;
use Illuminate\Support\Str;

class UrlPresenter {

    protected $database;

    public function __construct(Press $press)
    {
        $this->press = $press;
    }

    public function __get($key)
    {
        if(method_exists($this, $key))
        {
            return $this->$key();
        }
        return $this->$key;
    }

    public function show()
    {
        return route('media.'.Str::of($this->press->type)->lower(), $this->press->slug);
    }
}
