import './bootstrap';

import { gsap } from 'gsap';
import { TextPlugin } from 'gsap/TextPlugin';

gsap.registerPlugin(TextPlugin);

window.gsap = gsap;
window.TextPlugin = TextPlugin;

// Admin Components
import '../views/components/admin/⚡lapangan-create/lapangan-create.js';
import '../views/components/admin/⚡lapangan-update/lapangan-update.js';
import '../views/components/admin/⚡booking-master/booking-master.js';
import '../views/components/admin/⚡dashboard/dashboard.js';
import '../views/components/admin/⚡banner-carousel-create/banner-carousel-create.js';
import '../views/components/admin/⚡banner-carousel-update/banner-carousel-update.js';

// Public Components
import '../views/components/public/⚡booking/booking.js';
import '../views/components/public/⚡auth-status-popup/auth-status-popup.js';
import '../views/components/public/⚡hero-carousel/hero-carousel.js';
import '../views/components/public/⚡banner-carousel/banner-carousel.js';
import '../views/components/public/⚡booking-detail/booking-detail.js';
import '../views/components/public/⚡location-card/location-card.js';
import '../views/components/public/⚡detail-lapangan/detail-lapangan.js';

// Auth Components
import '../views/components/auth/⚡login/login.js';
import '../views/components/auth/⚡register/register.js';
