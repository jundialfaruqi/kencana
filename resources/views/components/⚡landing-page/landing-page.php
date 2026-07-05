<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

new #[Layout('layouts::public.app')] class extends Component
{
    public function mount(): void
    {
        seo()->for(new SEOData(
            title: 'Kencana Arena – Booking Lapangan Olahraga Online Pekanbaru',
            description: 'Booking lapangan futsal, badminton, basket, dan olahraga lainnya di Pekanbaru secara online. Mudah, cepat, dan terpercaya bersama Kencana Arena.',
            image: 'assets/images/logo/og-image-kencana.jpg',
            url: url('/'),
        ));
    }
};
