<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeYro · custom web apps & hosting</title>
  <?= _bootstrap_css() ?>
  <!-- Font Awesome 6 (free icons) -->
  <?= assets_css('landing') ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

  <!-- ========== NAVBAR ========== -->
  <nav class="navbar navbar-expand-lg navbar-dark brand-gradient py-3">
    <div class="container">
      <a class="navbar-brand fw-bold fs-3" href="#">
        <i class="fas fa-code me-2"></i>CodeYro
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
        aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
          <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="#process">Process</a></li>
          <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
          <li class="nav-item ms-lg-2">
            <a href="#contact" class="btn btn-outline-light btn-sm rounded-pill px-4 py-2 fw-semibold">Let’s talk</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ========== HERO ========== -->
  <section class="brand-gradient text-white pt-5 pb-5" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
    <div class="container py-3 py-md-5">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <span class="pill-badge text-dark bg-white bg-opacity-15 mb-3 d-inline-block">
            <i class="fas fa-rocket me-2"></i>Launch your next web app
          </span>
          <h1 class="display-3 fw-bold hero-headline mb-3">
            Custom web apps <br>that <span style="border-bottom: 4px solid #68a0ff;">scale</span> your business
          </h1>
          <p class="lead hero-sub opacity-90 mb-4 pe-lg-5">
            From custom dashboards to full‑stack platforms — we build, host, and maintain
            web applications tailored to your workflow.
          </p>
          <div class="d-flex flex-wrap gap-3">
            <a href="#contact" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold text-dark">
              <i class="fas fa-paper-plane me-2"></i>Start a project
            </a>
            <a href="#services" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3">
              <i class="fas fa-arrow-right me-2"></i>Explore services
            </a>
          </div>
          <div class="mt-4 d-flex flex-wrap gap-4 text-white-50 small">
            <span><i class="fas fa-check-circle text-success me-1"></i> 12+ apps delivered</span>
            <span><i class="fas fa-check-circle text-success me-1"></i> 24/7 hosting support</span>
            <span><i class="fas fa-check-circle text-success me-1"></i> free 30‑day maintenance</span>
          </div>
        </div>
        <div class="col-lg-5 text-center d-none d-lg-block">
          <div class="bg-white bg-opacity-10 p-4 rounded-5 shadow-lg" style="backdrop-filter: blur(2px);">
            <i class="fas fa-cubes" style="font-size: 5rem; color: #aac7ff;"></i>
            <p class="mt-3 text-white-50 fw-light">web apps · hosting · APIs</p>
            <div class="d-flex justify-content-center gap-4 mt-2">
              <span class="badge bg-white bg-opacity-15 text-dark p-2 px-3 rounded-pill">Node</span>
              <span class="badge bg-white bg-opacity-15 text-dark p-2 px-3 rounded-pill">PHP</span>
              <span class="badge bg-white bg-opacity-15 text-dark p-2 px-3 rounded-pill">Python</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== SERVICES ========== -->
  <section id="services" class="py-5 py-md-6">
    <div class="container py-4">
      <div class="text-center mb-5">
        <span class="pill-badge bg-soft-blue text-primary mb-2 d-inline-block"><i class="fas fa-cog me-1"></i> what we do</span>
        <h2 class="section-title display-5">Web solutions, <span style="color: #1b3a6b;">fully managed</span></h2>
        <p class="section-sub lead mx-auto" style="max-width: 640px;">End‑to‑end development and hosting, so you can focus on your business.</p>
      </div>

      <div class="row g-4">
        <!-- card 1: custom web app -->
        <div class="col-md-6 col-lg-4">
          <div class="service-card p-4 h-100">
            <div class="service-icon mb-3"><i class="fas fa-laptop-code"></i></div>
            <h4 class="fw-bold">Custom web applications</h4>
            <p class="text-secondary">Tailor‑made dashboards, internal tools, client portals, and SaaS platforms.
              Built with modern stacks and clean UX.</p>
            <ul class="list-unstyled small text-secondary">
              <li><i class="fas fa-check text-primary me-2"></i>User authentication & roles</li>
              <li><i class="fas fa-check text-primary me-2"></i>API integrations (CRM, payment, etc.)</li>
              <li><i class="fas fa-check text-primary me-2"></i>Responsive & accessible</li>
            </ul>
          </div>
        </div>
        <!-- card 2: web hosting -->
        <div class="col-md-6 col-lg-4">
          <div class="service-card p-4 h-100">
            <div class="service-icon mb-3"><i class="fas fa-server"></i></div>
            <h4 class="fw-bold">Web hosting & DevOps</h4>
            <p class="text-secondary">Reliable cloud hosting, deployment pipelines, and 24/7 monitoring.
              We handle the infrastructure so your app stays fast.</p>
            <ul class="list-unstyled small text-secondary">
              <li><i class="fas fa-check text-primary me-2"></i>AWS / DigitalOcean / VPS</li>
              <li><i class="fas fa-check text-primary me-2"></i>Automatic SSL & backups</li>
              <li><i class="fas fa-check text-primary me-2"></i>Scalable and secure</li>
            </ul>
          </div>
        </div>
        <!-- card 3: more services -->
        <div class="col-md-6 col-lg-4">
          <div class="service-card p-4 h-100">
            <div class="service-icon mb-3"><i class="fas fa-arrows-spin"></i></div>
            <h4 class="fw-bold">Maintenance & evolution</h4>
            <p class="text-secondary">Post‑launch support, feature updates, performance tuning, and bug fixes.
              Keep your app healthy and growing.</p>
            <ul class="list-unstyled small text-secondary">
              <li><i class="fas fa-check text-primary me-2"></i>Monthly retainer plans</li>
              <li><i class="fas fa-check text-primary me-2"></i>Security patches & updates</li>
              <li><i class="fas fa-check text-primary me-2"></i>Analytics & health reports</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- extra relevant: "more" row -->
      <div class="row mt-4 g-3">
        <div class="col-12 col-md-6">
          <div class="p-3 bg-white rounded-4 border border-light d-flex align-items-center">
            <i class="fas fa-database fs-3 text-primary me-3"></i>
            <div><strong>Database design & optimization</strong> — SQL, NoSQL, and data modeling.</div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="p-3 bg-white rounded-4 border border-light d-flex align-items-center">
            <i class="fas fa-cloud-upload-alt fs-3 text-primary me-3"></i>
            <div><strong>Migration & replatforming</strong> — move legacy apps to modern cloud.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== PROCESS (quick overview) ========== -->
  <section id="process" class="py-5 bg-soft-blue">
    <div class="container py-3">
      <div class="text-center mb-5">
        <span class="pill-badge bg-white text-primary mb-2 d-inline-block"><i class="far fa-clock me-1"></i> how we work</span>
        <h2 class="section-title display-5">From idea to launch <span style="color: #1b3a6b;">in weeks</span></h2>
      </div>
      <div class="row g-4">
        <div class="col-md-3">
          <div class="process-step">
            <div class="d-flex align-items-center mb-2">
              <span class="step-number">01</span>
              <span class="fw-bold">Discovery</span>
            </div>
            <p class="text-secondary small">We map your workflows, user stories, and tech requirements.</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="process-step">
            <div class="d-flex align-items-center mb-2">
              <span class="step-number">02</span>
              <span class="fw-bold">Design & prototype</span>
            </div>
            <p class="text-secondary small">Wireframes, clickable prototypes, and UI/UX refinement.</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="process-step">
            <div class="d-flex align-items-center mb-2">
              <span class="step-number">03</span>
              <span class="fw-bold">Agile development</span>
            </div>
            <p class="text-secondary small">Weekly sprints, demo videos, and full transparency.</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="process-step">
            <div class="d-flex align-items-center mb-2">
              <span class="step-number">04</span>
              <span class="fw-bold">Launch & host</span>
            </div>
            <p class="text-secondary small">Deployment, testing, training, and ongoing support.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== TESTIMONIALS ========== -->
  <section id="testimonials" class="py-5">
    <div class="container py-3">
      <div class="text-center mb-5">
        <span class="pill-badge bg-soft-blue text-primary mb-2 d-inline-block"><i class="fas fa-quote-left me-1"></i> client stories</span>
        <h2 class="section-title display-5">Trusted by <span style="color: #1b3a6b;">growing teams</span></h2>
      </div>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="bg-white p-4 rounded-4 shadow-sm h-100">
            <div class="testimonial-quote">“CodeYro built our internal CRM in just 6 weeks. The hosting is rock solid — we’ve had zero downtime.”</div>
            <div class="mt-3 d-flex align-items-center">
              <div><i class="fas fa-user-circle fs-1 text-secondary opacity-50"></i></div>
              <div class="ms-2"><strong>Sarah K.</strong><br><span class="text-secondary small">Operations Lead, Finlytics</span></div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="bg-white p-4 rounded-4 shadow-sm h-100">
            <div class="testimonial-quote">“They took our outdated spreadsheet system and turned it into a fast web dashboard. Hosting and maintenance are a breeze.”</div>
            <div class="mt-3 d-flex align-items-center">
              <div><i class="fas fa-user-circle fs-1 text-secondary opacity-50"></i></div>
              <div class="ms-2"><strong>Marcus R.</strong><br><span class="text-secondary small">Director, GreenSpace Co.</span></div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="bg-white p-4 rounded-4 shadow-sm h-100">
            <div class="testimonial-quote">“The custom portal for our real estate clients saved us 10+ hours of admin work per week. Highly recommend.”</div>
            <div class="mt-3 d-flex align-items-center">
              <div><i class="fas fa-user-circle fs-1 text-secondary opacity-50"></i></div>
              <div class="ms-2"><strong>Elena V.</strong><br><span class="text-secondary small">CEO, PropView</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== CTA / CONTACT ========== -->
  <section id="contact" class="py-5">
    <div class="container">
      <div class="cta-section p-4 p-md-5 text-white">
        <div class="row align-items-center g-4">
          <div class="col-lg-7">
            <h2 class="display-5 fw-semibold">Ready to build your <span style="color: #9fc9ff;">web app</span>?</h2>
            <p class="opacity-80 lead">Book a free 45‑min workflow audit. Let’s see how we can save you time and money.</p>
            <div class="d-flex flex-wrap gap-3 mt-3">
              <a href="#" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold text-dark">
                <i class="fas fa-calendar-check me-2"></i> Book a call
              </a>
              <span class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 email-modal">
                <i class="fas fa-envelope me-2"></i> <?= variable('email') ?>
              </span>
            </div>
          </div>
          <div class="col-lg-5 text-lg-end">
            <div class="bg-white bg-opacity-10 p-4 rounded-4">
              <i class="fas fa-message" style="font-size: 3rem;"></i>
              <p class="mb-0 mt-2 small">We’ll reply within 24h</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== FOOTER ========== -->
  <footer class="brand-gradient text-white pt-5 pb-4">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <h4 class="fw-bold"><i class="fas fa-code me-2"></i>CodeYro</h4>
          <p class="opacity-75 small">Custom web apps · hosting · DevOps. Built for scale, backed by support.</p>
          <div class="mt-3">
            <a href="#" class="footer-link me-3"><i class="fab fa-github"></i></a>
            <a href="#" class="footer-link me-3"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="footer-link"><i class="fab fa-x-twitter"></i></a>
          </div>
        </div>
        <div class="col-md-2">
          <h6 class="fw-semibold">Services</h6>
          <ul class="list-unstyled small opacity-75">
            <li>Web apps</li>
            <li>Hosting</li>
            <li>Maintenance</li>
            <li>API development</li>
          </ul>
        </div>
        <div class="col-md-2">
          <h6 class="fw-semibold">Company</h6>
          <ul class="list-unstyled small opacity-75">
            <li>About</li>
            <li>Portfolio</li>
            <li>Blog</li>
            <li>Careers</li>
          </ul>
        </div>
        <div class="col-md-4">
          <h6 class="fw-semibold">Let’s connect</h6>
          <p class="small opacity-75 email-modal"><i class="fas fa-envelope me-2"></i><?= variable('email') ?></p>
          <p class="small opacity-75"><i class="fas fa-phone me-2"></i><?= variable('phone') ?></p>
          <p class="small opacity-75"><i class="fas fa-map-pin me-2"></i>Remote · available worldwide</p>
        </div>
      </div>
      <hr class="border-light opacity-25 my-4">
      <div class="text-center small opacity-50">
        &copy; 2026 CodeYro. Freelance web app studio.
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS (for toggling, etc.) -->
  <?= _bootstrap_js() ?>
  <?= js() ?>
</body>

</html>