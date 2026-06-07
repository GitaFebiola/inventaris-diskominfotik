<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchBar extends Component
{
    public $action;
    public $placeholder;

    public function __construct(
        $action,
        $placeholder = 'Cari data...'
    ) {
        $this->action = $action;
        $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
        return view(
            'components.search-bar'
        );
    }
}