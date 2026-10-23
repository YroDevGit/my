<?php // page: /getting-started/docker ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Docker Guide — CTRX Documentation</title>
<link rel="stylesheet" href="<?=pagedir('docs/style.css')?>" />
</head>
<body>

<header class="docs-header">
    <div class="docs-header-inner">
        <button class="docs-burger" id="docsBurger" aria-label="Toggle menu" aria-expanded="false">
            <span class="docs-burger-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span class="docs-burger-label">Menu</span>
        </button>
        <a href="../index.html" class="docs-logo">Code<span>tazer</span>-X</a>
        <nav class="docs-top-nav">
            <a href="index.html" class="active">Get Started</a>
            <a href="../concepts/team-workflow.html">Concepts</a>
            <a href="../tutorials/insert-to-table.html">Tutorials</a>
            <a href="../reference/helpers.html">Reference</a>
        </nav>
        <div class="docs-header-actions">
            <a href="https://github.com/YroDevGit/ctrx" target="_blank">GitHub</a>
            <a href="https://packagist.org/packages/yrodevgit/ctrx" target="_blank">Packagist</a>
        </div>
    </div>
</header>

<div class="docs-overlay" id="docsOverlay"></div>

<div class="docs-layout">

    <?=pagedir_include('_inc/aside')?>

    <main class="docs-content">

        <nav class="breadcrumbs">
            <a href="../index.html">Docs</a>
            <span>/</span>
            <a href="index.html">Get Started</a>
            <span>/</span>
            <span>Docker</span>
        </nav>

        <h1>Docker Guide</h1>
        <p class="lead">
            CTRX ships with a ready-to-run Docker setup. One command
            builds the app, starts the database, and serves it on
            localhost. This page explains what the default
            <code>compose.yml</code> and <code>Dockerfile</code> do, what
            you may need to change, and the full lifecycle of commands.
        </p>

        <div class="callout">
            <p>
                <strong>Prerequisites:</strong> Docker Desktop installed
                and running. If you do not have it yet, see the
                <a href="index.html#docker">Get Started</a> page.
            </p>
        </div>

        <h2 id="generate">1. Generate the Docker files</h2>

        <p>
            If your project does not already have the Docker files,
            generate them first:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> generate:docker</code></pre>
        </div>

        <p>This creates four files in the project root:</p>

        <table class="docs-table">
            <thead>
                <tr><th>File</th><th>Purpose</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Dockerfile</code></td>
                    <td>Builds the PHP 8.5 + Apache image for the CTRX app</td>
                </tr>
                <tr>
                    <td><code>compose.yml</code></td>
                    <td>Defines the three services: <code>app</code>, <code>docker_db</code>, and <code>docker_redis</code></td>
                </tr>
                <tr>
                    <td><code>.htaccess</code></td>
                    <td>Apache rewrite and security rules</td>
                </tr>
                <tr>
                    <td><code>.gitignore</code></td>
                    <td>Excludes generated files from git</td>
                </tr>
            </tbody>
        </table>

        <h2 id="compose">2. Understanding the default compose.yml</h2>

        <p>
            The generated <code>compose.yml</code> defines three
            services. Each one has a specific job, and most of the
            configuration is already correct for local development.
            Here is the full file, annotated:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">services</span>:
  <span class="fn">app</span>:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: ctrx_app              <span class="comment"># change this (optional)</span>
    ports:
      - "8081:80"                         <span class="comment"># change this (optional)</span>
    volumes:
      - .:/var/www/html                   <span class="comment"># live code mount</span>
    depends_on:
      - docker_db
      - docker_redis
    environment:
      - REDIS_HOST=ctrx_redis             <span class="comment"># must match redis container_name</span>
      - REDIS_PORT=6379
      - REDIS_PASSWORD=ctrx               <span class="comment"># change this (optional)</span>
      - REDIS_DATABASE=0
      - REDIS_TIMEOUT=0.2

  <span class="fn">docker_db</span>:
    image: mariadb:10.11
    container_name: ctrx_db               <span class="comment"># change this — this is your DB hostname</span>
    restart: unless-stopped
    environment:
      TZ: Asia/Manila                     <span class="comment"># change this (optional)</span>
      MARIADB_ROOT_PASSWORD: password     <span class="comment"># change this — your DB root password</span>
    ports:
      - "3309:3306"                       <span class="comment"># change this (optional) — host:container</span>
    volumes:
      - ctrx_db_data:/var/lib/mysql       <span class="comment"># named volume, survives down</span>

  <span class="fn">docker_redis</span>:
    image: redis:7.2-alpine
    container_name: ctrx_redis            <span class="comment"># change this — must match REDIS_HOST above</span>
    restart: unless-stopped
    ports:
      - "6379:6379"                       <span class="comment"># change this (optional)</span>
    volumes:
      - ctrx_redis_data:/data
    command: redis-server --appendonly yes
    healthcheck:
      test: ["CMD", "redis-cli", "ping"]
      interval: 10s
      timeout: 5s
      retries: 5

<span class="kw">volumes</span>:
  ctrx_db_data:
  ctrx_redis_data:</code></pre>
        </div>

        <h3>What each service does</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Service</th><th>What it is</th><th>Why it is there</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>app</code></td>
                    <td>PHP 8.5 + Apache, built from your <code>Dockerfile</code></td>
                    <td>Runs the CTRX application</td>
                </tr>
                <tr>
                    <td><code>docker_db</code></td>
                    <td>MariaDB 10.11</td>
                    <td>Your database. The <code>container_name</code> is your DB hostname</td>
                </tr>
                <tr>
                    <td><code>docker_redis</code></td>
                    <td>Redis 7.2 Alpine</td>
                    <td>Rate limit storage and optional caching</td>
                </tr>
            </tbody>
        </table>

        <h3>What you must change</h3>

        <p>
            Three values are effectively required, because they appear in
            two places at once. If you change one without the other, the
            services cannot reach each other.
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>Value</th><th>Change here</th><th>And here</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>Database hostname</td>
                    <td><code>docker_db.container_name</code> (default: <code>ctrx_db</code>)</td>
                    <td>Your <code>.env</code> file: <code>db_host=ctrx_db</code></td>
                </tr>
                <tr>
                    <td>Database password</td>
                    <td><code>docker_db.MARIADB_ROOT_PASSWORD</code> (default: <code>password</code>)</td>
                    <td>Your <code>.env</code> file: <code>db_password=password</code></td>
                </tr>
                <tr>
                    <td>Redis hostname</td>
                    <td><code>docker_redis.container_name</code> (default: <code>ctrx_redis</code>)</td>
                    <td><code>app.environment.REDIS_HOST</code> (default: <code>ctrx_redis</code>)</td>
                </tr>
            </tbody>
        </table>

        <div class="callout warn">
            <p>
                <strong>Common mistake:</strong> changing
                <code>container_name</code> for the database but forgetting
                to update <code>db_host</code> in <code>.env</code>. The
                app starts, then fails to connect with "host not found."
                Always change both together.
            </p>
        </div>

        <h3>What you can leave alone</h3>

        <p>
            These values work for local development. Change them only if
            they clash with something already running on your machine.
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>Value</th><th>Default</th><th>When to change</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>App port</td>
                    <td><code>8081:80</code></td>
                    <td>Port 8081 is already in use on your host</td>
                </tr>
                <tr>
                    <td>DB port</td>
                    <td><code>3309:3306</code></td>
                    <td>You want a DB client (DBeaver, TablePlus) on the host to connect</td>
                </tr>
                <tr>
                    <td>Redis port</td>
                    <td><code>6379:6379</code></td>
                    <td>Port 6379 is already in use on your host</td>
                </tr>
                <tr>
                    <td>Timezone</td>
                    <td><code>Asia/Manila</code></td>
                    <td>Your local timezone differs</td>
                </tr>
            </tbody>
        </table>

        <h3>How volumes work here</h3>

        <p>
            There are three volumes in the setup, and each one behaves
            differently:
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>Volume</th><th>What it holds</th><th>Survives <code>down</code></th><th>Survives <code>down -v</code></th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>.:/var/www/html</code></td>
                    <td>Your local project folder</td>
                    <td>Yes (it is your host files)</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td><code>ctrx_db_data</code></td>
                    <td>MariaDB data files</td>
                    <td>Yes</td>
                    <td>No</td>
                </tr>
                <tr>
                    <td><code>ctrx_redis_data</code></td>
                    <td>Redis append-only log</td>
                    <td>Yes</td>
                    <td>No</td>
                </tr>
            </tbody>
        </table>

        <p>
            The <code>.:/var/www/html</code> line is what makes local
            development work. Instead of copying your code into the
            container at build time, Docker mounts your host folder into
            the container. Edit a PHP file on your host, refresh the
            browser, and the change is live. No rebuild needed.
        </p>

        <h2 id="dockerfile">3. Understanding the default Dockerfile</h2>

        <p>
            The <code>Dockerfile</code> builds the image for the
            <code>app</code> service. It is small, but every line has a
            purpose:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">FROM</span> php:8.5.12-apache

<span class="kw">RUN</span> a2enmod rewrite

<span class="kw">RUN</span> pecl install redis &amp;&amp; docker-php-ext-enable redis

<span class="kw">RUN</span> docker-php-ext-install \
    pdo \
    pdo_mysql

<span class="kw">RUN</span> sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
<span class="kw">RUN</span> echo "ServerName localhost" &gt;&gt; /etc/apache2/apache2.conf

<span class="kw">WORKDIR</span> /var/www/html

<span class="kw">COPY</span> . /var/www/html

<span class="kw">RUN</span> chown -R www-data:www-data /var/www/html

<span class="kw">EXPOSE</span> 80</code></pre>
        </div>

        <h3>Line by line</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Line</th><th>What it does</th><th>Why CTRX needs it</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>FROM php:8.5.12-apache</code></td>
                    <td>Base image: PHP 8.5 with Apache preinstalled</td>
                    <td>CTRX requires PHP 8.5 for new projects</td>
                </tr>
                <tr>
                    <td><code>RUN a2enmod rewrite</code></td>
                    <td>Enables Apache's rewrite module</td>
                    <td>CTRX's <code>.htaccess</code> uses <code>RewriteRule</code> for every route</td>
                </tr>
                <tr>
                    <td><code>pecl install redis</code></td>
                    <td>Installs the PHP Redis extension</td>
                    <td>CTRX uses Redis for rate limiting when <code>REDIS_HOST</code> is set</td>
                </tr>
                <tr>
                    <td><code>docker-php-ext-install pdo pdo_mysql</code></td>
                    <td>Installs PDO and the MySQL driver</td>
                    <td>All database access goes through PDO. Without these, no model queries work</td>
                </tr>
                <tr>
                    <td><code>sed -i ... AllowOverride All</code></td>
                    <td>Tells Apache to read <code>.htaccess</code> files</td>
                    <td>Without this, CTRX's routing rules in <code>.htaccess</code> are ignored</td>
                </tr>
                <tr>
                    <td><code>echo "ServerName localhost"</code></td>
                    <td>Sets Apache's default server name</td>
                    <td>Suppresses the "Could not reliably determine the server's fully qualified domain name" warning</td>
                </tr>
                <tr>
                    <td><code>WORKDIR /var/www/html</code></td>
                    <td>Sets the working directory</td>
                    <td>Matches the volume mount in <code>compose.yml</code></td>
                </tr>
                <tr>
                    <td><code>COPY . /var/www/html</code></td>
                    <td>Copies the project into the image</td>
                    <td>Used at build time. At runtime, the volume mount replaces it with your live files</td>
                </tr>
                <tr>
                    <td><code>chown -R www-data:www-data</code></td>
                    <td>Gives Apache permission to read and write project files</td>
                    <td>Without this, <code>Response::send()</code> cannot write uploads or logs</td>
                </tr>
                <tr>
                    <td><code>EXPOSE 80</code></td>
                    <td>Documents that the container listens on port 80</td>
                    <td>Maps to <code>8081:80</code> in <code>compose.yml</code></td>
                </tr>
            </tbody>
        </table>

        <h3>What you may need to change</h3>

        <p>
            Most projects can use this file unchanged. You may need to
            edit it in three cases:
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>If you need</th><th>Change</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>A different PHP version</td>
                    <td>
                        Change <code>FROM php:8.5.12-apache</code> to
                        <code>FROM php:8.2-apache</code> (or whatever version)
                    </td>
                </tr>
                <tr>
                    <td>Additional PHP extensions</td>
                    <td>
                        Add them to <code>docker-php-ext-install</code>,
                        for example <code>gd mbstring zip</code>
                    </td>
                </tr>
                <tr>
                    <td>Node.js for frontend build</td>
                    <td>
                        Add a <code>FROM node:20 AS assets</code> stage,
                        build the assets, then <code>COPY --from=assets</code>
                        into the final image
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="callout">
            <p>
                <strong>The volume mount overrides the COPY.</strong>
                In development, the <code>.:/var/www/html</code> line
                in <code>compose.yml</code> replaces whatever was
                copied at build time with your live files. For
                production, remove that volume so the image's own copy
                is used.
            </p>
        </div>

        <h2 id="start">4. Start the app</h2>

        <h3>Build and start</h3>

        <p>
            First time, or after changing <code>Dockerfile</code>,
            <code>compose.yml</code>, or <code>composer.json</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> up <span class="flag">--build</span></code></pre>
        </div>

        <p>
            This builds the image, starts all three services, and
            attaches your terminal to the logs. Press
            <code>Ctrl+C</code> to stop watching. Containers keep
            running in the background.
        </p>

        <h3>Start in the background</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> up <span class="flag">-d</span></code></pre>
        </div>

        <p>
            Your terminal returns immediately. The app is served at
            <code>http://localhost:8081</code> by default.
        </p>

        <h2 id="stop">5. Stop the app</h2>

        <h3>Stop containers, keep data</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> down</code></pre>
        </div>

        <h3>Stop containers and delete volumes</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> down <span class="flag">-v</span></code></pre>
        </div>

        <div class="callout warn">
            <p>
                <strong>The <code>-v</code> flag deletes
                <code>ctrx_db_data</code> and
                <code>ctrx_redis_data</code>.</strong> All database
                tables and rows are gone. Use it for a clean slate, not
                for routine shutdown.
            </p>
        </div>

        <h2 id="restart">6. Restart services</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> restart app
<span class="cmd">docker compose</span> restart docker_db
<span class="cmd">docker compose</span> restart docker_redis</code></pre>
        </div>

        <p>
            Useful after editing <code>.env</code>, or after changing a
            file that does not hot-reload (rare in CTRX since PHP
            reloads on every request).
        </p>

        <h2 id="shell">7. Run commands inside containers</h2>

        <h3>Open a shell in the app container</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> exec app bash</code></pre>
        </div>

        <h3>Run a CTRX CLI command directly</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> exec app php cli db:load
<span class="cmd">docker compose</span> exec app php cli db:migrate
<span class="cmd">docker compose</span> exec app php cli db:seed</code></pre>
        </div>

        <h3>Shorter form via the CLI passthrough</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> - db:load
<span class="cmd">php cli</span> - db:migrate
<span class="cmd">php cli</span> - db:seed</code></pre>
        </div>

        <p>
            The <code>-</code> tells CTRX to run the command inside the
            <code>app</code> container. <code>php cli @d</code> and
            <code>php cli @docker</code> are aliases.
        </p>

        <h2 id="database">8. Manage the database</h2>

        <p>
            Database commands run inside the <code>docker_db</code>
            container. The examples use the default root password
            <code>password</code>. If you changed
            <code>MARIADB_ROOT_PASSWORD</code> in
            <code>compose.yml</code>, use your value instead.
        </p>

        <div class="callout">
            <p>
                <strong>Container name:</strong> the service is called
                <code>docker_db</code>, but the container is called
                <code>ctrx_db</code>. Both work with
                <code>docker compose exec</code>. Use whichever you
                remember.
            </p>
        </div>

        <h3>List databases</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> exec docker_db mariadb -u root -ppassword -e "SHOW DATABASES;"</code></pre>
        </div>

        <h3>Create a database</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> exec docker_db mariadb -u root -ppassword -e "CREATE DATABASE dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"</code></pre>
        </div>

        <h3>Delete a database</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> exec docker_db mariadb -u root -ppassword -e "DROP DATABASE IF EXISTS dbname;"</code></pre>
        </div>

        <h3>Load, migrate, seed</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> exec app php cli db:load
<span class="cmd">docker compose</span> exec app php cli db:migrate
<span class="cmd">docker compose</span> exec app php cli db:seed</code></pre>
        </div>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>What it does</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>db:load</code></td>
                    <td>Create the database defined in <code>.env</code></td>
                </tr>
                <tr>
                    <td><code>db:migrate</code></td>
                    <td>Run <code>app/config/migration.php</code> and generate models</td>
                </tr>
                <tr>
                    <td><code>db:seed</code></td>
                    <td>Run the seeder (if configured)</td>
                </tr>
            </tbody>
        </table>

        <h2 id="redis">9. Inspect Redis</h2>

        <p>
            CTRX uses Redis for rate limiting when
            <code>REDIS_HOST</code> is set. Every rate limit key starts
            with <code>ratelimit_</code>. To list them:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> exec docker_redis redis-cli keys "ratelimit_*"</code></pre>
        </div>

        <p>
            Each key holds a JSON payload with the count, window, and
            remaining requests. To clear all rate limits, run:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> reset:throttle</code></pre>
        </div>

        <p>
            This clears both Redis keys and file-based rate limits, so
            you do not have to clean each one manually.
        </p>

        <h2 id="logs">10. View logs</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> logs <span class="flag">-f</span> app
<span class="cmd">docker compose</span> logs <span class="flag">-f</span> docker_db
<span class="cmd">docker compose</span> logs <span class="flag">-f</span> docker_redis</code></pre>
        </div>

        <p>
            <code>-f</code> follows the log output. Press
            <code>Ctrl+C</code> to stop watching.
        </p>

        <h2 id="inspect">11. Inspect running containers</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> ps</code></pre>
        </div>

        <p>
            Shows every container, its state, ports, and uptime.
        </p>

        <h2 id="rebuild">12. Rebuild from scratch</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> build <span class="flag">--no-cache</span> app
<span class="cmd">docker builder</span> prune <span class="flag">-af</span></code></pre>
        </div>

        <p>
            Use <code>--no-cache</code> when something seems stuck or
            after major changes to <code>Dockerfile</code> or
            <code>composer.json</code>. Use
            <code>docker builder prune -af</code> to free disk space by
            removing unused build layers. Neither touches running
            containers or your data.
        </p>

        <h2 id="quick-reference">Quick reference</h2>

        <table class="docs-table">
            <thead>
                <tr><th>Task</th><th>Command</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>Build and start</td>
                    <td><code>docker compose up --build</code></td>
                </tr>
                <tr>
                    <td>Start in background</td>
                    <td><code>docker compose up -d</code></td>
                </tr>
                <tr>
                    <td>Stop</td>
                    <td><code>docker compose down</code></td>
                </tr>
                <tr>
                    <td>Stop and delete volumes</td>
                    <td><code>docker compose down -v</code></td>
                </tr>
                <tr>
                    <td>Restart app</td>
                    <td><code>docker compose restart app</code></td>
                </tr>
                <tr>
                    <td>Open shell</td>
                    <td><code>docker compose exec app bash</code></td>
                </tr>
                <tr>
                    <td>Run CTRX CLI in container</td>
                    <td><code>docker compose exec app php cli &lt;command&gt;</code></td>
                </tr>
                <tr>
                    <td>Run CTRX CLI via passthrough</td>
                    <td><code>php cli - &lt;command&gt;</code></td>
                </tr>
                <tr>
                    <td>Load database</td>
                    <td><code>docker compose exec app php cli db:load</code></td>
                </tr>
                <tr>
                    <td>Run migrations</td>
                    <td><code>docker compose exec app php cli db:migrate</code></td>
                </tr>
                <tr>
                    <td>Seed database</td>
                    <td><code>docker compose exec app php cli db:seed</code></td>
                </tr>
                <tr>
                    <td>List databases</td>
                    <td><code>docker compose exec docker_db mariadb -u root -ppassword -e "SHOW DATABASES;"</code></td>
                </tr>
                <tr>
                    <td>Create database</td>
                    <td><code>docker compose exec docker_db mariadb -u root -ppassword -e "CREATE DATABASE..."</code></td>
                </tr>
                <tr>
                    <td>Delete database</td>
                    <td><code>docker compose exec docker_db mariadb -u root -ppassword -e "DROP DATABASE..."</code></td>
                </tr>
                <tr>
                    <td>List rate limit keys</td>
                    <td><code>docker compose exec docker_redis redis-cli keys "ratelimit_*"</code></td>
                </tr>
                <tr>
                    <td>Clear all rate limits</td>
                    <td><code>php cli reset:throttle</code></td>
                </tr>
                <tr>
                    <td>View app logs</td>
                    <td><code>docker compose logs -f app</code></td>
                </tr>
                <tr>
                    <td>View database logs</td>
                    <td><code>docker compose logs -f docker_db</code></td>
                </tr>
                <tr>
                    <td>View Redis logs</td>
                    <td><code>docker compose logs -f docker_redis</code></td>
                </tr>
                <tr>
                    <td>List containers</td>
                    <td><code>docker compose ps</code></td>
                </tr>
                <tr>
                    <td>Rebuild without cache</td>
                    <td><code>docker compose build --no-cache app</code></td>
                </tr>
                <tr>
                    <td>Clear build cache</td>
                    <td><code>docker builder prune -af</code></td>
                </tr>
            </tbody>
        </table>

        <nav class="docs-pager">
            <a href="index.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">Get Started</span>
            </a>
            <a href="directory-structure.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Directory Structure</span>
            </a>
        </nav>

    </main>

</div>

<footer class="docs-footer">
    <p>
        CTRX by <a href="#">Tyrone Malocon</a>
        · <a href="https://github.com/YroDevGit/ctrx">GitHub</a>
        · <a href="https://packagist.org/packages/yrodevgit/ctrx">Packagist</a>
    </p>
</footer>

<script src="<?=pagedir('js/script.js')?>"></script>
</body>
</html>