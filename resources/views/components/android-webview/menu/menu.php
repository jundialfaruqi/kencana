<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Menu')] #[Layout('layouts::android-webview.app')] class extends Component
{
    public function render()
    {
        return view('components.android-webview.menu.menu');
    }
};
