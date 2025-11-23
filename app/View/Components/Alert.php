<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;

    /**
     * Create a new component instance.
     */
    public function __construct($type = null, $message = null)
    {
        $this->type = $type ?? (session('success') ? 'success' : (session('error') ? 'danger' : null));
        $this->message = $message ?? session('success') ?? session('error') ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
