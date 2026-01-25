    <!-- Leaflet Resources -->
    <link rel="stylesheet" href="{{ asset('assets/leaflet/dist/leaflet.css') }}" />
    <script src="{{ asset('assets/leaflet/dist/leaflet-global.js') }}"></script>

    <style>
        .typing-cursor::after {
            content: "|";
            animation: blink 0.8s infinite;
            margin-left: 2px;
            color: currentColor;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }
    </style>
    <script>
        function initKencanaAnimation() {
            gsap.registerPlugin(TextPlugin);
            const kencanaText = document.getElementById('kencana-text');

            if (kencanaText) {
                kencanaText.classList.add('typing-cursor');
                gsap.set(kencanaText, {
                    text: ""
                });

                const tl = gsap.timeline({
                    repeat: 0,
                    delay: 0.5,
                    onComplete: () => {
                        // Hilangkan kursor setelah selesai
                        setTimeout(() => kencanaText.classList.remove('typing-cursor'), 2000);
                    }
                });

                // Ketik langsung KENCANA
                tl.to(kencanaText, {
                    duration: 1.5,
                    text: {
                        value: "KENCANA"
                    },
                    ease: "none"
                });
            }
        }

        document.addEventListener('livewire:navigated', () => {
            initKencanaAnimation();

            let lastScrollTop = 0;
            const navbar = document.getElementById('navbar');
            const threshold = 50;

            if (!navbar) return;

            window.addEventListener('scroll', () => {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop < 0) scrollTop = 0;

                if (scrollTop > lastScrollTop && scrollTop > threshold) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }

                lastScrollTop = scrollTop;
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.hook('commit', ({
                succeed
            }) => {
                succeed(() => {
                    setTimeout(() => initKencanaAnimation(), 0);
                });
            });
        });
    </script>
