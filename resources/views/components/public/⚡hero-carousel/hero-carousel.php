<?php

use Livewire\Component;

new class extends Component {
    public $ready = false;

    public function load()
    {
        sleep(1);
        $this->ready = true;
    }
};
