<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class inputField extends Component
{
    /**
     * Create a new component instance.
     */
    public string $name;
    public string $id;
    public string $label;
    public string $type;
    public string $placeholder;
    public string $value;
    public function __construct($name, $label, $type, $placeholder = '', $value = '', $id = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-field');
    }
}
