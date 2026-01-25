import './bootstrap';

import { gsap } from 'gsap';
import { TextPlugin } from 'gsap/TextPlugin';

gsap.registerPlugin(TextPlugin);

window.gsap = gsap;
window.TextPlugin = TextPlugin;
