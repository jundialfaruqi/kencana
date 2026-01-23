<?php

use Livewire\Component;

new class extends Component
{
    public $ready = false;

    public function load()
    {
        $this->ready = true;
    }
};
