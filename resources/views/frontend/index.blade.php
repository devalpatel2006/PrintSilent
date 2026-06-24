<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Print Silently — Seamless eCommerce. Effortless Shipping.</title>
  <meta name="description" content="Print Silently connects cloud apps to local printers with secure silent background printing for ERP, POS, logistics, healthcare, and manufacturing." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" />
</head>
<body>
  <div class="bg-orb orb-1"></div>
  <div class="bg-orb orb-2"></div>
  <div class="page-shell">
    <header class="topbar">
      <div class="brand">
        <img src="{{ asset('images/logo.jpg') }}" alt="Print Silently Logo" style="height: 48px; border-radius: 8px;">
        <div>
          <p class="brand-label">Print Silently</p>
          <span class="brand-tag">Seamless eCommerce</span>
        </div>
      </div>
      <nav class="nav-links">
      
        <a href="#download">DOWNLOAD</a>
        <a href="#pricing">PRICING</a>
        <a href="#about">ABOUT US</a>
        <a href="#faq">FAQ</a>
      </nav>
      <div class="nav-actions">
     
        <a href="{{ route('login') }}" style="color: var(--text); text-decoration: none; font-weight: 500; margin-right: 12px;">Sign in</a>
        <a class="button primary" href="{{ route('register') }}">Get Started</a>
        <button class="ghost-btn" id="themeToggle">Dark</button>
      </div>
    </header>

    <main>
      <section class="hero" id="start">
        <div class="hero-copy animate-on-scroll">
          <span class="eyebrow">Enterprise printing reimagined</span>
          <h1>Silent printing for modern businesses.</h1>
          <p>Connect your web applications directly to local printers using our secure desktop bridge technology — instant, silent, and fully automated.</p>
          <div class="hero-actions">
            <a class="button primary" href="{{ route('register') }}">Get Started</a>
            <a class="button secondary" href="{{ route('register') }}">Get API key</a>
          </div>
       
        </div>

        <div class="hero-panel animate-on-scroll delay-200">
          <div class="panel-card glass-card">
            <div class="panel-header">
              <span class="status-pill">Live queue</span>
              <span class="status-chip">99.98% success</span>
            </div>
            <div class="panel-body">
              <div class="panel-row">
                <div>
                  <p class="panel-number">14.8k</p>
                  <span>Jobs processed</span>
                </div>
                <div>
                  <p class="panel-number">23</p>
                  <span>Connected printers</span>
                </div>
              </div>
              <div class="queue-list">
                <div class="queue-item success">
                  <span>Invoice #A234</span>
                  <span>Thermal label • Zebra ZD421</span>
                </div>
                <div class="queue-item warning">
                  <span>Batch 03</span>
                  <span>Retrying • Warehouse A</span>
                </div>
                <div class="queue-item success">
                  <span>Prescription slip</span>
                  <span>Silent print • Pharmacy</span>
                </div>
              </div>
            </div>
          </div>
          <div class="floating-card">
            <p class="floating-title">Cloud app</p>
            <div class="floating-detail">Secure communication tunnel</div>
          </div>
        </div>
      </section>
      <section id="download" class="download-section animate-on-scroll delay-100" style="padding: 80px 40px; margin: 40px 0; position: relative; border-radius: 32px; background: linear-gradient(135deg, rgba(124, 92, 255, 0.05), rgba(0, 211, 255, 0.05)); border: 1px solid var(--border); overflow: hidden;">
        <div style="position: absolute; top: -50%; left: -10%; width: 50%; height: 200%; background: radial-gradient(circle, rgba(124, 92, 255, 0.15), transparent 70%); filter: blur(60px); z-index: 0; pointer-events: none;"></div>
        <div style="position: absolute; bottom: -50%; right: -10%; width: 50%; height: 200%; background: radial-gradient(circle, rgba(0, 211, 255, 0.15), transparent 70%); filter: blur(60px); z-index: 0; pointer-events: none;"></div>
        
        <div style="position: relative; z-index: 1; text-align: center; max-width: 740px; margin: 0 auto;">
          <span class="eyebrow" style="margin-bottom: 24px;">Get Started</span>
          <h2 style="font-size: clamp(2.2rem, 3vw, 2.8rem); margin: 0 0 20px; font-weight: 800; letter-spacing: -0.03em;">Download our App</h2>
          <p style="color: var(--text-muted); font-size: 1.15rem; line-height: 1.8; margin-bottom: 44px;">Install the secure desktop client to instantly connect your local printers to your cloud web applications.</p>
          
          <div style="display: flex; justify-content: center; gap: 24px; flex-wrap: wrap;">
            <a class="button primary" href="{{ asset('mac/PrintSilently.dmg') }}" download style="display: flex; align-items: center; gap: 12px; padding: 18px 36px; font-size: 1.1rem; box-shadow: 0 20px 40px rgba(124, 92, 255, 0.3);">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
              Download for Mac OS
            </a>
            <a class="button secondary" href="{{ asset('windows/PrintSilently.exe') }}" download style="display: flex; align-items: center; gap: 12px; padding: 18px 36px; font-size: 1.1rem;">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
              Download for Windows
            </a>
          </div>
        </div>
      </section>
      <section class="feature-grid" id="why">
        <div class="feature-card animate-on-scroll delay-100">
          <h3>Silent background printing</h3>
          <p>Print documents instantly without modal dialogs, keyboard interaction, or browser prompts.</p>
        </div>
        <div class="feature-card animate-on-scroll delay-200">
          <h3>Secure local bridge</h3>
          <p>Encrypted device pairing, token-based authorization, and zero-trust print delivery.</p>
        </div>
        <div class="feature-card animate-on-scroll delay-300">
          <h3>Universal integrations</h3>
          <p>Embed into ERP, POS, logistics, healthcare, warehouse, and SaaS systems with a single API.</p>
        </div>
        <div class="feature-card animate-on-scroll delay-400">
          <h3>Enterprise-ready</h3>
          <p>Role controls, audit logs, SLA monitoring, regional deployments and priority failover.</p>
        </div>
      </section>
      <section class="story-block" id="about">
        <div class="story-copy animate-on-scroll">
          <span class="eyebrow">Platform vision</span>
          <h2>From cloud event to local printer in milliseconds.</h2>
          <p>Print Silently is the infrastructure layer for background printing — a secure bridge between SaaS applications and local print hardware with intelligent routing, retry orchestration, and full enterprise control.</p>
          <div class="story-list">
            <div><strong>One-Click E-commerce Integration</strong><p>Connect Shopify, WooCommerce, Amazon, Flipkart, and other platforms to automatically receive and process orders.</p></div>
            <div><strong>Silent Background Printing</strong><p>Print invoices, shipping labels, packing slips, and receipts instantly without any print dialog or user intervention.</p></div>
            <div><strong>Truly Silent Printing</strong><p>Automatically print invoices, labels, and packing slips without popups, dialogs, or manual clicks.</p></div>
          </div>
        </div>
        <div class="story-visual glass-card animate-on-scroll delay-200">
          <div class="visual-header"><span>Device pairing</span><span>Secure tunnel</span></div>
          <div class="visual-stack">
            <div class="stack-chip">ERP / CRM / POS</div>
            <div class="stack-chip">REST API</div>
            <div class="stack-chip">Desktop bridge</div>
            <div class="stack-chip">Local printers</div>
          </div>
        </div>
      </section>
   <section class="pricing" id="pricing">
  <div class="section-heading">
    <span class="eyebrow">Pricing</span>
    <h2>Choose the plan that fits your business, from startups to enterprise-scale operations.</h2>
  </div>

  <div class="pricing-grid">
    <article class="price-card animate-on-scroll delay-100">
      <h3>Free</h3>
      <p>Full access to Silent Print features for individuals and small businesses.</p>
      <p class="price">$0<span>/mo</span></p>
      <ul>
        <li>Unlimited print jobs</li>
        <li>Connect multiple stores</li>
        <li>Silent background printing</li>
        <li>Shipping labels & invoices</li>
        <li>Offline queue support</li>
        <li>Email support</li>
      </ul>
      <a class="button ghost" href="{{ route('register') }}">Get Started</a>
    </article>
        <article class="price-card recommended animate-on-scroll delay-200">
          <h3>White Label</h3>
          <p>Your own branded printing solution with custom software and identity.</p>
          <p class="price">Custom Pricing</p>
          <ul>
            <li>Custom logo & branding</li>
            <li>Custom desktop application</li>
            <li>Custom domain & portal</li>
            <li>Dedicated API integration</li>
            <li>Priority support</li>
            <li>Deployment assistance</li>
          </ul>
          <a class="button primary" href="{{ route('register') }}">Contact Sales</a>
        </article>

        <article class="price-card animate-on-scroll delay-300">
          <h3>Enterprise</h3>
          <p>Advanced infrastructure, security, and dedicated support for large organizations.</p>
          <p class="price">Contact Sales</p>
          <ul>
            <li>Unlimited organizations</li>
            <li>SSO & role management</li>
            <li>Dedicated infrastructure</li>
            <li>Advanced analytics</li>
            <li>Custom SLA</li>
            <li>Dedicated account manager</li>
          </ul>
          <a class="button ghost" href="{{ route('register') }}">Request Quote</a>
        </article>
          </div>
      </section>

      <section class="testimonial-section">
        <div class="section-heading">
          <span class="eyebrow">Built for customers</span>
          <h2>Operational teams trust Print Silently for mission-critical printing.</h2>
        </div>
        <div class="testimonial-grid">
          <article class="testimonial-card animate-on-scroll delay-100">
            <p>“Print Silently replaced our manual label printing flow and eliminated every browser dialog. The integration was seamless and instantly reliable.”</p>
            <footer>— Sarah Jain, CTO at LogisticsOne</footer>
          </article>
          <article class="testimonial-card animate-on-scroll delay-200">
            <p>“Our hospitals now print prescriptions and wristbands silently across 18 clinics with full auditing and device policies.”</p>
            <footer>— Marco Lee, IT Director at MediChain</footer>
          </article>
          <article class="testimonial-card animate-on-scroll delay-300">
            <p>“The API-first developer experience and device heartbeat monitoring give us confidence to scale globally.”</p>
            <footer>— Elena Ruiz, Head of Operations at SmartPOS</footer>
          </article>
        </div>
      </section>

      <section class="faq" id="faq">
        <div class="section-heading">
          <span class="eyebrow">FAQ</span>
          <h2>Everything you need to know before you build.</h2>
        </div>
        <div class="faq-grid">
          <div class="faq-item animate-on-scroll delay-100">
            <h4>How does Print Silently stay silent?</h4>
            <p>Our desktop bridge runs locally and delivers print jobs directly to the OS print spooler. The browser never opens a print dialog.</p>
          </div>
          <div class="faq-item animate-on-scroll delay-200">
            <h4>Which printers are supported?</h4>
            <p>PDF, thermal, label, ESC/POS, raw, network, and USB printers are supported via the local device agent.</p>
          </div>
          <div class="faq-item animate-on-scroll delay-300">
            <h4>Can I use it with ERP, POS, and warehouse systems?</h4>
            <p>Yes. The platform is designed for integrations with ERP, POS, logistics, hospital systems, and custom SaaS workflows.</p>
          </div>
          <div class="faq-item animate-on-scroll delay-400">
            <h4>Is it secure for enterprise environments?</h4>
            <p>Yes. We offer end-to-end encrypted print payloads, signed print jobs, device authentication, audit logs, IP whitelisting, and SSO support.</p>
          </div>
        </div>
      </section>

      <footer class="footer">
        <div>
          <p class="footer-title">Print Silently</p>
          <p>Seamless eCommerce. Effortless Shipping. Background printing for Cloud, ERP, POS, and logistics.</p>
        </div>
        <div class="footer-links">
           <a href="#download">DOWNLOAD</a>
        <a href="#pricing">PRICING</a>
        <a href="#about">ABOUT US</a>
        <a href="#faq">FAQ</a>
        </div>
      </footer>
    </main>
  </div>

  <script>
    const toggle = document.getElementById('themeToggle');
    toggle.addEventListener('click', () => {
      document.documentElement.classList.toggle('light');
      toggle.textContent = document.documentElement.classList.contains('light') ? 'Dark' : 'Light';
    });

    // Topbar scroll effect
    const topbar = document.querySelector('.topbar');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 20) {
        topbar.classList.add('scrolled');
      } else {
        topbar.classList.remove('scrolled');
      }
    });

    // Intersection Observer for scroll animations
    const observerOptions = {
      root: null,
      rootMargin: '0px',
      threshold: 0.15
    };

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
      observer.observe(el);
    });
  </script>
</body>
</html>
