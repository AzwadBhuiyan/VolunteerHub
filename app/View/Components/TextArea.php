<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextArea extends Component
{
    public $name;
    public $id;
    public $required;
    public $class;

    public function __construct($name, $id = null, $required = false, $class = '')
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->required = $required;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.text-area');
    }
}