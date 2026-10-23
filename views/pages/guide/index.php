<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Get Started - CTRX Framework</title>
  <link rel="stylesheet" href="<?= pagedir('css/style.css') ?>">
  <meta name="description" content="Install CTRX, PHP, MariaDB, Docker, and VS Code on Windows and macOS. Get started with the Codetazer-X PHP framework." />

</head>

<body>
  <header class="site-header">
    <div class="header-inner">
      <a href="#" class="logo"><img src="<?=assets('ctrx.png')?>" alt="ctrx" width="35" height="35">Code<span>tazer</span>-X</a>
      <nav class="header-nav">
        <a href="#what-is-ctrx">About</a>
        <a href="#requirements">Requirements</a>
        <a href="#install-ctrx">Install CTRX</a>
        <a href="#php">PHP</a>
        <a href="#mariadb">MariaDB</a>
        <a href="#docker">Docker</a>
        <a href="#vscode">VS Code</a>
      </nav>
    </div>
  </header>

  <main class="container">
    <!-- HERO -->
    <div class="hero">
      <span class="eyebrow">Documentation</span>
      <h1>Get Started with CTRX</h1>
      <p>Set up the Codetazer-X framework from scratch. This guide covers installing CTRX, PHP, MariaDB, PostgreSQL, Docker, and VS Code on both Windows and macOS.</p>
    </div>

    <!-- 0. WHAT IS CTRX -->
    <section class="step" id="what-is-ctrx">
      <div class="step-header">
        <span class="step-number">1</span>
        <h2>What is CTRX?</h2>
      </div>

      <p>
        CTRX (Codetazer-X) is a lightweight PHP framework for building web
        applications and APIs. It gives you an organized project
        structure and reusable tools for routing, controllers, middleware,
        database operations, validation, and other common tasks, so you do
        not have to build every component from scratch.
      </p>

      <p>
        CTRX is API-first. Every backend endpoint returns JSON, and every
        frontend page consumes those endpoints through TYRAX. The backend
        lives in <code>app/</code>, the frontend lives in
        <code>views/</code>, and the two halves never share a file. This
        means backend and frontend developers can work independently
        without merge conflicts. On the backend, CTRX ships with routing,
        controllers, middleware, models, migrations, and validation. On the
        frontend, it ships with TYRAX for requests, TModal for forms, TWal
        for alerts, and a validator that renders errors under the right
        inputs. It also supports traditional PHP-rendered pages, so the
        framework fits both JSON APIs and server-rendered sites.
      </p>

      <p>
        In short: CTRX is a PHP toolbox that makes building APIs, websites,
        and web applications faster and more organized. It provides the API
        layer, the UI layer, and the glue between them in one project,
        without requiring extra installs.
      </p>

      <h3>Why CTRX?</h3>

      <p>
        Most PHP frameworks mix backend and frontend code in the same
        files. Blade templates that call models, route files that both
        teams edit, view data that leaks business logic. This works for
        solo developers, but it becomes friction the moment a second
        person joins.
      </p>

      <p>
        CTRX makes the boundary <strong>structural instead of
          conventional</strong>. If a file lives in <code>app/</code>, only
        the backend team owns it. If it lives in <code>views/</code>,
        only the frontend team owns it. It's not a rule developers have
        to follow, it's the shape of the framework.
      </p>

      <table style="width:100%;border-collapse:collapse;font-size:0.92rem;margin-top:0.5rem;">
        <thead>
          <tr style="text-align:left;color:var(--text-muted);font-size:0.8rem;text-transform:uppercase;letter-spacing:0.05em;">
            <th style="padding:0.5rem 0.75rem;border-bottom:1px solid var(--border);">Concern</th>
            <th style="padding:0.5rem 0.75rem;border-bottom:1px solid var(--border);">Typical PHP framework</th>
            <th style="padding:0.5rem 0.75rem;border-bottom:1px solid var(--border);">CTRX</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Where routes live</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Both devs edit <code>routes/web.php</code></td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Backend-only <code>app/_routes/api.php</code></td>
          </tr>
          <tr>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Frontend knows URLs</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Hardcoded strings in JS</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Named routes via <code>Tyrax</code></td>
          </tr>
          <tr>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Backend renames a controller</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Frontend breaks</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Frontend keeps working</td>
          </tr>
          <tr>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Merge conflicts on routes</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Common</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);color:var(--green);">Impossible</td>
          </tr>
          <tr>
            <td style="padding:0.6rem 0.75rem;">Onboarding a new dev</td>
            <td style="padding:0.6rem 0.75rem;">"Learn the whole stack"</td>
            <td style="padding:0.6rem 0.75rem;">"Only <code>app/</code>" or "Only <code>views/</code>"</td>
          </tr>
        </tbody>
      </table>

      <h3>Built for solo developers too</h3>

      <p>
        If you're building alone, the same boundary keeps you focused.
        When you're in backend mode, you stay in <code>app/</code>. When
        you're in frontend mode, you stay in <code>views/</code>. The
        framework makes it hard to accidentally mix concerns. and it
        means you can hand off one half to a contractor without exposing
        the other.
      </p>

      <div class="callout">
        <p>
          <strong>Read the full story:</strong> the
          <a href="/guide/workflow">Team Workflow</a>
          page explains why CTRX is shaped this way and walks through a
          real handoff between backend and frontend developers.
        </p>
      </div>
    </section>

    <!-- 1. REQUIREMENTS -->
    <section class="step" id="requirements">
      <div class="step-header">
        <span class="step-number">2</span>
        <h2>Requirements</h2>
      </div>
      <p>Before installing CTRX, make sure you have the following installed on your system.</p>

      <table style="width:100%;border-collapse:collapse;font-size:0.92rem;margin-top:0.5rem;">
        <thead>
          <tr style="text-align:left;color:var(--text-muted);font-size:0.8rem;text-transform:uppercase;letter-spacing:0.05em;">
            <th style="padding:0.5rem 0.75rem;border-bottom:1px solid var(--border);">Software</th>
            <th style="padding:0.5rem 0.75rem;border-bottom:1px solid var(--border);">Version</th>
            <th style="padding:0.5rem 0.75rem;border-bottom:1px solid var(--border);">Required</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">PHP</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">8.2 or 8.5</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);color:var(--green);">Yes</td>
          </tr>
          <tr>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Composer</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Latest</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);color:var(--green);">Yes</td>
          </tr>
          <tr>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">MariaDB</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">10.6+</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);color:var(--green);">If preferred</td>
          </tr>
          <tr>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">PostgreSQL</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Latest</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);color:var(--green);">If preferred</td>
          </tr>
          <tr>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Docker</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);">Latest</td>
            <td style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--border);color:var(--text-muted);">Optional but better</td>
          </tr>
          <tr>
            <td style="padding:0.6rem 0.75rem;">VS Code</td>
            <td style="padding:0.6rem 0.75rem;">Latest</td>
            <td style="padding:0.6rem 0.75rem;color:var(--text-muted);">Recommended</td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- 2. INSTALL CTRX -->
    <section class="step" id="install-ctrx">
      <div class="step-header">
        <span class="step-number">3</span>
        <h2>Install CTRX</h2>
      </div>
      <p>Once PHP and Composer are installed, create a new CTRX project using Composer's <code>create-project</code> command.</p>

      <div class="code-block">
        <button class="copy-btn" data-copy>Copy</button>
        <pre><code><span class="cmd">composer</span> create-project <span class="str">yrodevgit/ctrx</span> projectname</code></pre>
      </div>

      <p>Replace <code>projectname</code> with the folder name for your new application. Composer will download CTRX and install all dependencies automatically.</p>

      <div class="callout">
        <p><strong>Note:</strong> Make sure Composer is available in your <code>PATH</code>. Run <code>composer --version</code> to verify.</p>
      </div>
    </section>

    <!-- 3. INSTALL COMPOSER -->
    <section class="step" id="composer">
      <div class="step-header">
        <span class="step-number">4</span>
        <h2>Install Composer</h2>
      </div>
      <p>Composer is the PHP dependency manager used to install CTRX.</p>

      <div class="tabs" data-tabs>
        <div class="tab-buttons">
          <button class="tab-btn active" data-tab="composer-win">Windows (winget)</button>
          <button class="tab-btn" data-tab="composer-mac">macOS (Homebrew)</button>
        </div>

        <div class="tab-panel active" id="composer-win">
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">winget</span> install Composer.Composer</code></pre>
          </div>
        </div>

        <div class="tab-panel" id="composer-mac">
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment"># Install Homebrew first if you don't have it</span>
<span class="cmd">/bin/bash</span> -c <span class="str">"$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"</span>

<span class="comment"># Then install Composer</span>
<span class="cmd">brew</span> install composer</code></pre>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. INSTALL PHP -->
    <section class="step" id="php">
      <div class="step-header">
        <span class="step-number">5</span>
        <h2>Install PHP</h2>
      </div>
      <p>CTRX supports two PHP versions. Choose the one that fits your project.</p>

      <p>
        <strong>PHP 8.2</strong><span class="version-badge old">Legacy</span> - for older projects and maximum compatibility.<br />
        <strong>PHP 8.5</strong><span class="version-badge std">Standard</span> - the recommended version for new CTRX projects.
      </p>

      <div class="tabs" data-tabs>
        <div class="tab-buttons">
          <button class="tab-btn active" data-tab="php-win">Windows (winget)</button>
          <button class="tab-btn" data-tab="php-mac">macOS (Homebrew)</button>
        </div>

        <div class="tab-panel active" id="php-win">
          <h3>PHP 8.2 (Legacy)</h3>
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">winget</span> install PHP.PHP.8.2</code></pre>
          </div>

          <h3>PHP 8.5 (Standard)</h3>
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">winget</span> install PHP.PHP.8.5</code></pre>
          </div>
        </div>

        <div class="tab-panel" id="php-mac">
          <h3>PHP 8.2 (Legacy)</h3>
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">brew</span> install php@8.2
<span class="cmd">brew</span> link --overwrite --force php@8.2</code></pre>
          </div>

          <h3>PHP 8.5 (Standard)</h3>
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">brew</span> install php@8.5
<span class="cmd">brew</span> link --overwrite --force php@8.5</code></pre>
          </div>
        </div>
      </div>

      <div class="callout warn">
        <p><strong>Windows tip:</strong> After installing PHP, add the PHP install directory to your system <code>PATH</code>, then restart your terminal.<br>Verify with: <b><code>php -v</code></b>.</p>
      </div>
    </section>

    <!-- 5. INSTALL MARIADB -->
    <section class="step" id="mariadb">
      <div class="step-header">
        <span class="step-number">6</span>
        <h2>Install MariaDB</h2>
      </div>
      <p>MariaDB is the recommended database for CTRX applications.</p>

      <div class="tabs" data-tabs>
        <div class="tab-buttons">
          <button class="tab-btn active" data-tab="maria-win">Windows (winget)</button>
          <button class="tab-btn" data-tab="maria-mac">macOS (Homebrew)</button>
        </div>

        <div class="tab-panel active" id="maria-win">
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">winget</span> install MariaDB.Server</code></pre>
          </div>
          <p>During installation, you'll be prompted to set a root password. Remember it - you'll need it for your CTRX <code>.env</code> file.</p>
        </div>

        <div class="tab-panel" id="maria-mac">
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">brew</span> install mariadb

<span class="comment"># Start the service</span>
<span class="cmd">brew</span> services start mariadb

<span class="comment"># Secure the installation</span>
<span class="cmd">mariadb-secure-installation</span></code></pre>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. INSTALL DOCKER -->
    <section class="step" id="docker">
      <div class="step-header">
        <span class="step-number">7</span>
        <h2>Install Docker <span class="version-badge" style="font-size:0.7rem;">Optional</span></h2>
      </div>
      <p>Docker is optional, but recommended for containerized local development and deployment.</p>

      <div class="tabs" data-tabs>
        <div class="tab-buttons">
          <button class="tab-btn active" data-tab="docker-win">Windows (winget)</button>
          <button class="tab-btn" data-tab="docker-mac">macOS (Homebrew)</button>
        </div>

        <div class="tab-panel active" id="docker-win">
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">winget</span> install Docker.DockerDesktop</code></pre>
          </div>
          <p>Restart your machine after installation, then launch Docker Desktop to complete setup.</p>
        </div>

        <div class="tab-panel" id="docker-mac">
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">brew</span> install --cask docker</code></pre>
          </div>
          <p>Open Docker from your Applications folder after installation to start the daemon.</p>
        </div>
      </div>
    </section>

    <!-- 7. INSTALL VS CODE -->
    <section class="step" id="vscode">
      <div class="step-header">
        <span class="step-number">8</span>
        <h2>Install VS Code <span class="version-badge" style="font-size:0.7rem;">Recommended</span></h2>
      </div>
      <p>Visual Studio Code is the recommended editor for CTRX development.</p>

      <div class="tabs" data-tabs>
        <div class="tab-buttons">
          <button class="tab-btn active" data-tab="vscode-win">Windows (winget)</button>
          <button class="tab-btn" data-tab="vscode-mac">macOS (Homebrew)</button>
        </div>

        <div class="tab-panel active" id="vscode-win">
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">winget</span> install Microsoft.VisualStudioCode</code></pre>
          </div>
        </div>

        <div class="tab-panel" id="vscode-mac">
          <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">brew</span> install --cask visual-studio-code</code></pre>
          </div>
        </div>
      </div>

      <!-- ============ EXTENSIONS ============ -->
      <h3>Best VS Code Extensions for CTRX</h3>
      <p>Install these to get the best CTRX development experience. All of them work with PHP, HTML, CSS, and JavaScript out of the box.</p>

      <div class="ext-list">

        <!-- PHP Intelephense -->
        <div class="ext-card">
          <div class="ext-head">
            <span class="ext-name">PHP Intelephense</span>
            <span class="ext-tag best">Best</span>
          </div>
          <p class="ext-desc">Fast, feature-rich PHP language server. Autocomplete, go-to-definition, refactoring, and inline docs. the essential PHP extension for CTRX.</p>
          <code>bmewburn.vscode-intelephense-client</code>
        </div>

        <!-- PHP IntelliSense -->
        <div class="ext-card">
          <div class="ext-head">
            <span class="ext-name">PHP IntelliSense</span>
            <span class="ext-tag best">Best</span>
          </div>
          <p class="ext-desc">Adds PHP smart completion, signature help, and formatting. Pairs well with Intelephense for a complete PHP editing setup.</p>
          <code>felixfbecker.php-intellisense</code>
        </div>

        <!-- HTML CSS Support -->
        <div class="ext-card">
          <div class="ext-head">
            <span class="ext-name">HTML CSS Support</span>
            <span class="ext-tag best">Best</span>
          </div>
          <p class="ext-desc">Class and ID attribute completion in HTML files, based on your CSS. Great for styling CTRX views and templates.</p>
          <code>ecmel.vscode-html-css</code>
        </div>

        <!-- Material Icon Theme -->
        <div class="ext-card">
          <div class="ext-head">
            <span class="ext-name">Material Icon Theme</span>
            <span class="ext-tag best">Best</span>
          </div>
          <p class="ext-desc">Replaces VS Code's default file icons with a clean Material Design set. Makes PHP, JSON, and config files instantly recognizable.</p>
          <code>PKief.material-icon-theme</code>
        </div>

        <!-- JavaScript ES6 snippets -->
        <div class="ext-card">
          <div class="ext-head">
            <span class="ext-name">JavaScript (ES6) Code Snippets</span>
            <span class="ext-tag best">Best</span>
          </div>
          <p class="ext-desc">Handy ES6 syntax snippets. imports, exports, arrow functions, promises, and more. Best paired with JavaScript work in CTRX frontends.</p>
          <code>xabikos.JavaScriptSnippets</code>
        </div>

        <!-- Docker -->
        <div class="ext-card">
          <div class="ext-head">
            <span class="ext-name">Docker</span>
            <span class="ext-tag conditional">If using Docker</span>
          </div>
          <p class="ext-desc">Manage containers, images, and registries from inside VS Code. Only needed if your CTRX project runs in Docker.</p>
          <code>ms-azuretools.vscode-docker</code>
        </div>

        <!-- CSS Peak -->
        <div class="ext-card">
          <div class="ext-head">
            <span class="ext-name">CSS Peak</span>
            <span class="ext-tag optional">Optional</span>
          </div>
          <p class="ext-desc">Jump to CSS class definitions straight from your HTML. A nice quality-of-life add-on for larger stylesheets.</p>
          <code>pranaygp.vscode-css-peek</code>
        </div>

      </div>

      <!-- One-shot install -->
      <h3>Install all at once (terminal)</h3>
      <p>You can install every extension in a single command. Open VS Code's terminal (<code>Ctrl</code>+<code>`</code> on Windows, <code>Cmd</code>+<code>`</code> on macOS) and run:</p>

      <div class="code-block">
        <button class="copy-btn" data-copy>Copy</button>
        <pre><code><span class="cmd">code</span> --install-extension bmewburn.vscode-intelephense-client
<span class="cmd">code</span> --install-extension felixfbecker.php-intellisense
<span class="cmd">code</span> --install-extension ecmel.vscode-html-css
<span class="cmd">code</span> --install-extension PKief.material-icon-theme
<span class="cmd">code</span> --install-extension xabikos.JavaScriptSnippets
<span class="cmd">code</span> --install-extension ms-azuretools.vscode-docker
<span class="cmd">code</span> --install-extension pranaygp.vscode-css-peek</code></pre>
      </div>

      <div class="callout">
        <p><strong>Tip:</strong> If <code>code</code> isn't recognized, open VS Code → <em>Command Palette</em> (<code>Ctrl/Cmd</code>+<code>Shift</code>+<code>P</code>) → run <strong>Shell Command: Install 'code' command in PATH</strong>.</p>
      </div>

    </section>

    <div class="success-box">
      <span class="check">✓</span>
      <h3>You're ready to build with CTRX</h3>
      <p>Navigate into your new project folder and start your server. Full usage docs coming soon.</p>
      <p>Next topic is: <a href="/guide/workflow">Workflows</a></p>
    </div>

  </main>

  <footer class="site-footer">
    <p>CTRX. Codetazer-X Framework by <a href="#">Tyrone Malocon</a> · <a href="#">GitHub</a> · <a href="#">Packagist</a></p>
  </footer>
  <script src="<?= pagedir('js/script.js') ?>"></script>
</body>

</html>
<?= js(false) ?>