import './bootstrap';

import { gsap } from 'gsap';
import { TextPlugin } from 'gsap/TextPlugin';

gsap.registerPlugin(TextPlugin);

window.gsap = gsap;
window.TextPlugin = TextPlugin;

import '../views/components/admin/⚡lapangan-detail/lapangan-detail.js';
import '../views/components/admin/⚡lapangan-create/lapangan-create.js';
import '../views/components/admin/⚡lapangan-update/lapangan-update.js';
import '../views/components/public/⚡hero-carousel/hero-carousel.js';
import '../views/components/public/⚡booking/booking.js';
