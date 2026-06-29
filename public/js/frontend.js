(function () {
    'use strict';

    const html = document.documentElement;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ─── Theme (persisted) ─────────────────────────────────── */
    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('ps-theme');

    if (savedTheme === 'light') {
        html.classList.add('light');
    }

    function updateThemeLabel() {
        if (!themeToggle) return;
        const isLight = html.classList.contains('light');
        themeToggle.setAttribute('aria-pressed', isLight ? 'true' : 'false');
        themeToggle.innerHTML = isLight
            ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>'
            : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';
    }

    updateThemeLabel();

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            html.classList.toggle('light');
            localStorage.setItem('ps-theme', html.classList.contains('light') ? 'light' : 'dark');
            updateThemeLabel();
        });
    }

    /* ─── Mobile navigation ───────────────────────────────────── */
    const menuToggle = document.getElementById('menuToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileOverlay = document.getElementById('mobileOverlay');

    function closeMobileNav() {
        document.body.classList.remove('nav-open');
        if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
    }

    function openMobileNav() {
        document.body.classList.add('nav-open');
        if (menuToggle) menuToggle.setAttribute('aria-expanded', 'true');
    }

    if (menuToggle && mobileNav) {
        menuToggle.addEventListener('click', () => {
            document.body.classList.contains('nav-open') ? closeMobileNav() : openMobileNav();
        });

        mobileOverlay?.addEventListener('click', closeMobileNav);
        mobileNav.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', closeMobileNav);
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeMobileNav();
        });
    }

    /* ─── Topbar scroll ───────────────────────────────────────── */
    const topbar = document.querySelector('.topbar');
    if (topbar) {
        const onScroll = () => topbar.classList.toggle('scrolled', window.scrollY > 24);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    /* ─── Back to top ─────────────────────────────────────────── */
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('is-visible', window.scrollY > 600);
        }, { passive: true });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: reducedMotion ? 'auto' : 'smooth' });
        });
    }

    /* ─── Scroll reveal ───────────────────────────────────────── */
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const delay = el.dataset.delay || 0;
            setTimeout(() => el.classList.add('is-visible'), Number(delay));
            revealObserver.unobserve(el);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.animate-on-scroll, .reveal-left, .reveal-right, .reveal-scale').forEach((el) => {
        revealObserver.observe(el);
    });

    /* ─── Stagger children ────────────────────────────────────── */
    document.querySelectorAll('[data-stagger]').forEach((parent) => {
        const step = Number(parent.dataset.stagger) || 80;
        [...parent.children].forEach((child, i) => {
            child.classList.add('animate-on-scroll');
            child.dataset.delay = i * step;
            revealObserver.observe(child);
        });
    });

    /* ─── Counter animation ───────────────────────────────────── */
    function animateCounter(el) {
        const target = parseFloat(el.dataset.count);
        const suffix = el.dataset.suffix || '';
        const decimals = (el.dataset.count || '').includes('.') ? 1 : 0;
        const duration = 1800;
        const start = performance.now();

        function tick(now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 4);
            const value = target * eased;
            el.textContent = (decimals ? value.toFixed(1) : Math.floor(value).toLocaleString()) + suffix;
            if (progress < 1) requestAnimationFrame(tick);
        }

        requestAnimationFrame(tick);
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            animateCounter(entry.target);
            counterObserver.unobserve(entry.target);
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-count]').forEach((el) => counterObserver.observe(el));

    /* ─── 3D tilt on cards ────────────────────────────────────── */
    if (!reducedMotion) {
        document.querySelectorAll('[data-tilt]').forEach((card) => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;
                card.style.transform = `perspective(800px) rotateY(${x * 8}deg) rotateX(${-y * 8}deg) translateY(-6px)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });
    }

    /* ─── Button ripple ───────────────────────────────────────── */
    document.querySelectorAll('.button, .btn-submit').forEach((btn) => {
        btn.addEventListener('click', function (e) {
            if (reducedMotion) return;
            const ripple = document.createElement('span');
            ripple.className = 'btn-ripple';
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = e.clientX - rect.left - size / 2 + 'px';
            ripple.style.top = e.clientY - rect.top - size / 2 + 'px';
            this.appendChild(ripple);
            ripple.addEventListener('animationend', () => ripple.remove());
        });
    });

    /* ─── FAQ accordion ───────────────────────────────────────── */
    document.querySelectorAll('.faq-accordion .faq-trigger').forEach((trigger) => {
        const item = trigger.closest('.faq-accordion-item');
        const panel = item.querySelector('.faq-panel');

        if (item.classList.contains('is-open') && panel) {
            panel.style.maxHeight = panel.scrollHeight + 'px';
        }

        trigger.addEventListener('click', () => {
            const isOpen = item.classList.contains('is-open');
            item.closest('.faq-accordion')?.querySelectorAll('.faq-accordion-item').forEach((i) => {
                i.classList.remove('is-open');
                i.querySelector('.faq-trigger')?.setAttribute('aria-expanded', 'false');
                const p = i.querySelector('.faq-panel');
                if (p) p.style.maxHeight = '0';
            });
            if (!isOpen) {
                item.classList.add('is-open');
                trigger.setAttribute('aria-expanded', 'true');
                if (panel) panel.style.maxHeight = panel.scrollHeight + 'px';
            }
        });
    });

    /* ─── Parallax orbs ───────────────────────────────────────── */
    if (!reducedMotion) {
        const orbs = document.querySelectorAll('.bg-orb');
        window.addEventListener('scroll', () => {
            const y = window.scrollY * 0.15;
            orbs.forEach((orb, i) => {
                orb.style.transform = `translateY(${y * (i % 2 === 0 ? 1 : -0.6)}px)`;
            });
        }, { passive: true });
    }

    /* ─── Active nav highlight ────────────────────────────────── */
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-links a, .mobile-nav a').forEach((link) => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('is-active');
        }
    });

    /* ─── Queue item live pulse ───────────────────────────────── */
    document.querySelectorAll('.queue-item').forEach((item, i) => {
        item.style.animationDelay = i * 0.4 + 's';
        item.classList.add('queue-animate');
    });
})();
