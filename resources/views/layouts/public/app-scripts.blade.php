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
        function initAmanAnimation() {
            if (window.__amanAnimated === true) return;
            gsap.registerPlugin(TextPlugin);
            const amanText = document.getElementById('aman-text');

            if (amanText) {
                window.__amanAnimated = true;
                amanText.classList.add('typing-cursor');
                gsap.set(amanText, {
                    text: ""
                });

                const tl = gsap.timeline({
                    repeat: 0,
                    delay: 0.5,
                    onComplete: () => {
                        // Hilangkan kursor setelah selesai
                        setTimeout(() => amanText.classList.remove('typing-cursor'), 1500);
                    }
                });

                // Ketik langsung AMAN
                tl.to(amanText, {
                    duration: 1.2,
                    text: {
                        value: "AMAN"
                    },
                    ease: "none"
                });
            }
        }

        document.addEventListener('livewire:navigated', () => {
            initAmanAnimation();

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
                    setTimeout(() => initAmanAnimation(), 0);
                });
            });
        });
    </script>
