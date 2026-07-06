<?php

namespace App\Support\Csp\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Presets\Basic;

class KencanaPolicy extends Policy
{
    public function configure()
    {
        $this->add(Directive::BASE, Keyword::NONE)
             ->add(Directive::CONNECT, Keyword::SELF)
             ->add(Directive::DEFAULT, Keyword::SELF)
             ->add(Directive::FORM_ACTION, Keyword::SELF)
             ->add(Directive::IMG, Keyword::SELF)
             ->add(Directive::MEDIA, Keyword::SELF)
             ->add(Directive::OBJECT, Keyword::NONE)
             ->add(Directive::SCRIPT, Keyword::SELF)
             ->add(Directive::STYLE, Keyword::SELF);

        // 1. Script Sources
        $this->add(Directive::SCRIPT, 'https://cdn.jsdelivr.net')
             ->add(Directive::SCRIPT, 'https://unpkg.com')
             ->add(Directive::SCRIPT, 'https://www.google-analytics.com')
             ->add(Directive::SCRIPT, Keyword::UNSAFE_EVAL) // Needed for Alpine.js/Livewire 3/4
             ->add(Directive::SCRIPT, Keyword::UNSAFE_INLINE); // Force inline fallback if nonce disabled

        // 2. Style Sources
        $this->add(Directive::STYLE, 'https://fonts.googleapis.com')
             ->add(Directive::STYLE, 'https://fonts.bunny.net')
             ->add(Directive::STYLE, Keyword::UNSAFE_INLINE); // Needed for Livewire injected styles & inline styling

        // 3. Font Sources
        $this->add(Directive::FONT, 'https://fonts.gstatic.com')
             ->add(Directive::FONT, 'https://fonts.bunny.net');

        // 4. Image Sources (Map Tiles & API images)
        $this->add(Directive::IMG, [
            'https://a.basemaps.cartocdn.com',
            'https://b.basemaps.cartocdn.com',
            'https://c.basemaps.cartocdn.com',
            'https://d.basemaps.cartocdn.com',
            'https://a.tile.openstreetmap.org',
            'https://b.tile.openstreetmap.org',
            'https://c.tile.openstreetmap.org',
            'https://kencana-api.pekanbaru.go.id',
            'https://www.google-analytics.com',
            config('services.api.base_url'), // Sometimes images share the same origin as API
            config('services.api.image_base_url', config('services.api.base_url')),
            'data:' // For inline images like base64 logo/SVG
        ]);

        // 5. Connect Sources (AJAX, Vite HMR, API)
        $this->add(Directive::CONNECT, config('services.api.base_url'));
        $this->add(Directive::CONNECT, 'https://kencana-api.pekanbaru.go.id');
        $this->add(Directive::CONNECT, 'https://www.google-analytics.com');
        
        // Hanya izinkan koneksi Vite port 5173 saat mode lokal/development
        if (app()->isLocal()) {
            $this->add(Directive::CONNECT, 'ws://127.0.0.1:5173');
            $this->add(Directive::CONNECT, 'ws://localhost:5173');
            $this->add(Directive::CONNECT, 'http://127.0.0.1:5173');
            $this->add(Directive::CONNECT, 'http://localhost:5173');
        }
    }
}
