<?php

use Livewire\Component;

new class extends Component
{
    public bool $readyToLoad = false;

    public function load()
    {
        $this->readyToLoad = true;
        $this->dispatch('banner-carousel-loaded');
    }
};
