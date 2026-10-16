<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>CLI. CTRX Documentation</title>
<link rel="stylesheet" href="<?=pagedir('docs/style.css')?>" />
</head>
<body>

<header class="docs-header">
    <div class="docs-header-inner">
        <a href="../index.html" class="docs-logo">Code<span>tazer</span>-X</a>
        <nav class="docs-top-nav">
            <a href="../getting-started/index.html">Get Started</a>
            <a href="../backend/routing.html" class="active">Docs</a>
            <a href="../tutorials/login-flow.html">Tutorials</a>
            <a href="../reference/helpers.html">Reference</a>
        </nav>
        <div class="docs-header-actions">
            <a href="https://github.com/YroDevGit/ctrx" target="_blank">GitHub</a>
            <a href="https://packagist.org/packages/yrodevgit/ctrx" target="_blank">Packagist</a>
        </div>
    </div>
</header>

<div class="docs-layout">

    <?= pagedir_include("_inc/aside")?>

    <main class="docs-content">

        <nav class="breadcrumbs">
            <a href="../index.html">Docs</a>
            <span>/</span>
            <a href="#">Backend</a>
            <span>/</span>
            <span>CLI</span>
        </nav>

        <h1>CLI</h1>
        <p class="lead">
            CTRX ships with a CLI tool that handles scaffolding, database
            tasks, Docker generation, deployments, and self-updating.
            Run any command with <code>php cli &lt;command&gt;</code>.
        </p>

        <div class="callout">
            <p>
                <strong>First time?</strong> Run <code>php cli run</code> to
                start the development server. Your app will be available at
                the URL in your <code>.env</code>'s <code>rootpath</code>.
            </p>
        </div>

        <!-- ==================================================== -->
        <h2 id="server">Development server</h2>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php cli run</code></td>
                    <td>Start the PHP development server</td>
                </tr>
                <tr>
                    <td><code>php cli server</code></td>
                    <td>Alias for <code>run</code></td>
                </tr>
                <tr>
                    <td><code>php cli server mobile</code></td>
                    <td>Serve on <code>0.0.0.0</code> for LAN / mobile access</td>
                </tr>
                <tr>
                    <td><code>php cli server public</code></td>
                    <td>Alias for <code>mobile</code></td>
                </tr>
            </tbody>
        </table>

        <div class="callout">
            <p>
                The dev server reads its host and port from the
                <code>rootpath</code> variable in your <code>.env</code>.
                Example: <code>http://localhost:9999</code>.
            </p>
        </div>

        <!-- ==================================================== -->
        <h2 id="scaffolding">Scaffolding</h2>

        <p>
            Generate skeleton files with the <code>+</code> prefix. Every
            generator creates a file with the right namespace, class name,
            and boilerplate.
        </p>

        <h3>Controllers</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> +controller admin/add
<span class="cmd">php cli</span> +ctrl admin/add        <span class="comment"># alias</span>
<span class="cmd">php cli</span> +c admin/add           <span class="comment"># alias</span></code></pre>
        </div>

        <p>
            Multiple controllers at once, comma-separated:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> +controller admin/add,edit,delete</code></pre>
        </div>

        <h3>Frontend JS</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> +js user/login
<span class="comment"># Creates views/js/user/login.js paired to views/pages/user/login.php</span></code></pre>
        </div>

        <h3>Other generators</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Creates</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>+model Task</code></td>
                    <td><code>app/model/Task.php</code> (namespace <code>Models\</code>)</td>
                </tr>
                <tr>
                    <td><code>+class Task</code></td>
                    <td><code>app/php/core/classes/Task.php</code> (namespace <code>Classes\</code>)</td>
                </tr>
                <tr>
                    <td><code>+middleware g1</code></td>
                    <td><code>app/middleware/g1.php</code></td>
                </tr>
                <tr>
                    <td><code>+helper strings</code></td>
                    <td><code>app/helper/strings.php</code></td>
                </tr>
                <tr>
                    <td><code>+library MyLib</code></td>
                    <td><code>app/library/MyLib.php</code></td>
                </tr>
                <tr>
                    <td><code>+test MyTest</code></td>
                    <td><code>test/MyTest.php</code></td>
                </tr>
            </tbody>
        </table>

        <!-- ==================================================== -->
        <h2 id="database">Database</h2>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php cli db:load</code></td>
                    <td>Create the database defined in <code>.env</code></td>
                </tr>
                <tr>
                    <td><code>php cli db:migrate</code></td>
                    <td>Run migrations from <code>app/config/migration.php</code></td>
                </tr>
                <tr>
                    <td><code>php cli db:sync</code></td>
                    <td>Regenerate <code>app/base/*.php</code> from DB tables</td>
                </tr>
                <tr>
                    <td><code>php cli download:table users</code></td>
                    <td>Export a table to <code>users_ctrx.json</code></td>
                </tr>
                <tr>
                    <td><code>php cli db:timezone</code></td>
                    <td>Print the database's current timezone offset</td>
                </tr>
                <tr>
                    <td><code>php cli db:sync:timezone</code></td>
                    <td>Sync DB timezone to match PHP's <code>time_zone</code></td>
                </tr>
                <tr>
                    <td><code>php cli db:set:timezone +08:00</code></td>
                    <td>Set DB timezone explicitly</td>
                </tr>
            </tbody>
        </table>

        <!-- ==================================================== -->
        <h2 id="tables">Tables &amp; models</h2>

        <p>
            Generate a base model file for every table in the database.
            CTRX skips internal tables like <code>ctrx_roles</code>.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> tables sync</code></pre>
        </div>

        <p>
            List every registered route:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> routes</code></pre>
        </div>

        <!-- ==================================================== -->
        <h2 id="js">JavaScript build</h2>

        <p>
            Minify all JavaScript in <code>views/js/</code> and output the
            result to <code>views/build/</code>. Uses <strong>Terser</strong>
            under the hood.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> js:build</code></pre>
        </div>

        <ul>
            <li>Reads all <code>.js</code> files in <code>views/js/</code></li>
            <li>Skips files ending in <code>.min.js</code></li>
            <li>Preserves folder structure (e.g. <code>user/login.js</code> → <code>build/user/login.js</code>)</li>
            <li>Requires <code>npm install -g terser</code></li>
        </ul>

        <div class="callout warn">
            <p>
                <strong>Before deploying</strong>, run <code>php cli js:build</code>.
                In production, CTRX serves the minified files from
                <code>views/build/</code> instead of <code>views/js/</code>.
            </p>
        </div>

        <!-- ==================================================== -->
        <h2 id="docker">Docker</h2>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php cli generate:docker</code></td>
                    <td>Generate <code>Dockerfile</code>, <code>compose.yml</code>, <code>.htaccess</code>, <code>.gitignore</code></td>
                </tr>
                <tr>
                    <td><code>php cli reset:docker</code></td>
                    <td>Delete <code>Dockerfile</code> and <code>compose.yml</code></td>
                </tr>
                <tr>
                    <td><code>php cli - &lt;command&gt;</code></td>
                    <td>Run a CLI command inside the Docker container</td>
                </tr>
                <tr>
                    <td><code>php cli @d &lt;command&gt;</code></td>
                    <td>Alias for <code>-</code></td>
                </tr>
                <tr>
                    <td><code>php cli @docker &lt;command&gt;</code></td>
                    <td>Alias</td>
                </tr>
            </tbody>
        </table>

        <p>
            Example. run <code>db:sync</code> inside the container:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> - db:sync</code></pre>
        </div>

        <!-- ==================================================== -->
        <h2 id="accounts">Accounts &amp; roles</h2>

        <p>
            CTRX stores admin accounts in a local SQLite database.
            Manage them from the CLI:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> account:add tyrone:mypassword
<span class="cmd">php cli</span> account:update tyrone:newpassword
<span class="cmd">php cli</span> account:delete tyrone</code></pre>
        </div>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php cli grant:public &lt;route&gt;</code></td>
                    <td>Grant public access to a route in the roles system</td>
                </tr>
                <tr>
                    <td><code>php cli reset:role</code></td>
                    <td>Drop role tables and rebuild them</td>
                </tr>
            </tbody>
        </table>

        <!-- ==================================================== -->
        <h2 id="secrets">Config &amp; secrets</h2>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php cli --secret</code></td>
                    <td>Generate <code>env.json</code> with the default secret</td>
                </tr>
                <tr>
                    <td><code>php cli --secret myvalue</code></td>
                    <td>Generate with a custom secret</td>
                </tr>
                <tr>
                    <td><code>php cli export:configs</code></td>
                    <td>Export the local SQLite config to <code>ctrx.db</code></td>
                </tr>
                <tr>
                    <td><code>php cli import:configs</code></td>
                    <td>Import config from <code>ctrx.db</code></td>
                </tr>
                <tr>
                    <td><code>php cli generate:hash</code></td>
                    <td>Print a random hash</td>
                </tr>
            </tbody>
        </table>

        <!-- ==================================================== -->
        <h2 id="cron">Cron jobs</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> run:cron</code></pre>
        </div>

        <p>
            Runs every cron job whose scheduled time has passed.
            Typically called from a system crontab every minute.
        </p>

        <!-- ==================================================== -->
        <h2 id="updating">Updating CTRX</h2>

        <p>
            CTRX can update itself from GitHub. Protected files
            (your <code>.env</code>, controllers, routes, config, database)
            are never overwritten.
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php cli ctrx:version</code></td>
                    <td>Print the current version</td>
                </tr>
                <tr>
                    <td><code>php cli update:ctrx</code></td>
                    <td>Fetch and apply updates from GitHub</td>
                </tr>
                <tr>
                    <td><code>php cli update:file &lt;path&gt;</code></td>
                    <td>Update a single file</td>
                </tr>
                <tr>
                    <td><code>php cli generate:classes</code></td>
                    <td>Re-download all core classes</td>
                </tr>
                <tr>
                    <td><code>php cli generate:file new</code></td>
                    <td>Fetch every file listed in <code>composer.json</code></td>
                </tr>
            </tbody>
        </table>

        <!-- ==================================================== -->
        <h2 id="editor">Editor setup</h2>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php cli generate:clean</code></td>
                    <td>Create <code>.vscode/settings.json</code> to hide framework internals from the file tree</td>
                </tr>
                <tr>
                    <td><code>php cli php:shortcuts</code></td>
                    <td>Print the URL to CTRX's PHP VS Code snippets</td>
                </tr>
            </tbody>
        </table>

        <!-- ==================================================== -->
        <h2 id="testing">Testing tools</h2>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php cli generate:testdb</code></td>
                    <td>Install a test DB viewer at <code>/test/db</code></td>
                </tr>
                <tr>
                    <td><code>php cli dl:testmemory</code></td>
                    <td>Download the memory test tool</td>
                </tr>
                <tr>
                    <td><code>php cli dl:bootstrap</code></td>
                    <td>Download Bootstrap CSS + JS</td>
                </tr>
                <tr>
                    <td><code>php cli reset:memory</code></td>
                    <td>Drop all SQLite tables</td>
                </tr>
                <tr>
                    <td><code>php cli reset:throttle</code></td>
                    <td>Clear all rate-limit files</td>
                </tr>
            </tbody>
        </table>

        <!-- ==================================================== -->
        <h2 id="windows">Windows / Docker fixes</h2>

        <p>
            Docker on Windows sometimes fails to bind ports due to the
            Windows NAT reservation. If you see port errors:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> stop:winnat
<span class="comment"># ...then restart Docker Desktop...</span>
<span class="cmd">php cli</span> start:winnat</code></pre>
        </div>

        <!-- ==================================================== -->
        <h2 id="all">All commands</h2>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Purpose</th></tr>
            </thead>
            <tbody>
                <tr><td colspan="2" class="group-label"><strong>Server</strong></td></tr>
                <tr><td><code>run</code>, <code>server</code></td><td>Start dev server</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Scaffolding</strong></td></tr>
                <tr><td><code>+controller</code>, <code>+ctrl</code>, <code>+c</code></td><td>Create controller</td></tr>
                <tr><td><code>+js</code></td><td>Create paired JS</td></tr>
                <tr><td><code>+model</code></td><td>Create model</td></tr>
                <tr><td><code>+class</code></td><td>Create core class</td></tr>
                <tr><td><code>+middleware</code></td><td>Create middleware</td></tr>
                <tr><td><code>+helper</code></td><td>Create helper</td></tr>
                <tr><td><code>+library</code></td><td>Create library</td></tr>
                <tr><td><code>+test</code></td><td>Create test</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Database</strong></td></tr>
                <tr><td><code>db:load</code></td><td>Create DB</td></tr>
                <tr><td><code>db:migrate</code></td><td>Run migrations</td></tr>
                <tr><td><code>db:sync</code>, <code>tables sync</code></td><td>Sync base tables</td></tr>
                <tr><td><code>db:timezone</code></td><td>Read DB timezone</td></tr>
                <tr><td><code>db:set:timezone</code></td><td>Set DB timezone</td></tr>
                <tr><td><code>db:sync:timezone</code></td><td>Sync DB ↔ PHP timezone</td></tr>
                <tr><td><code>download:table</code></td><td>Export table to JSON</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Routes</strong></td></tr>
                <tr><td><code>routes</code>, <code>get_routes</code></td><td>List routes</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Build</strong></td></tr>
                <tr><td><code>js:build</code></td><td>Minify JS with Terser</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Docker</strong></td></tr>
                <tr><td><code>generate:docker</code></td><td>Generate Docker files</td></tr>
                <tr><td><code>reset:docker</code></td><td>Remove Docker files</td></tr>
                <tr><td><code>-</code>, <code>@d</code>, <code>@docker</code></td><td>Run inside container</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Config</strong></td></tr>
                <tr><td><code>--secret</code></td><td>Generate secret</td></tr>
                <tr><td><code>export:configs</code></td><td>Export config DB</td></tr>
                <tr><td><code>import:configs</code></td><td>Import config DB</td></tr>
                <tr><td><code>generate:hash</code></td><td>Random hash</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Accounts</strong></td></tr>
                <tr><td><code>account:add</code></td><td>Add account</td></tr>
                <tr><td><code>account:update</code></td><td>Update password</td></tr>
                <tr><td><code>account:delete</code></td><td>Delete account</td></tr>
                <tr><td><code>grant:public</code></td><td>Grant public access</td></tr>
                <tr><td><code>reset:role</code></td><td>Reset roles</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Cron</strong></td></tr>
                <tr><td><code>run:cron</code></td><td>Run due cron jobs</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Update</strong></td></tr>
                <tr><td><code>ctrx:version</code></td><td>Show version</td></tr>
                <tr><td><code>update:ctrx</code></td><td>Update framework</td></tr>
                <tr><td><code>update:file</code></td><td>Update one file</td></tr>
                <tr><td><code>generate:classes</code></td><td>Re-download classes</td></tr>
                <tr><td><code>generate:file new</code></td><td>Fetch composer.json list</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Editor</strong></td></tr>
                <tr><td><code>generate:clean</code></td><td>VSCode clean setup</td></tr>
                <tr><td><code>php:shortcuts</code></td><td>Snippet URL</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Testing</strong></td></tr>
                <tr><td><code>generate:testdb</code></td><td>Install test DB viewer</td></tr>
                <tr><td><code>dl:testmemory</code></td><td>Download memory tool</td></tr>
                <tr><td><code>dl:bootstrap</code></td><td>Download Bootstrap</td></tr>
                <tr><td><code>reset:memory</code></td><td>Drop SQLite tables</td></tr>
                <tr><td><code>reset:throttle</code></td><td>Clear rate limits</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Windows</strong></td></tr>
                <tr><td><code>stop:winnat</code></td><td>Stop Windows NAT</td></tr>
                <tr><td><code>start:winnat</code></td><td>Start Windows NAT</td></tr>
                <tr><td colspan="2" class="group-label"><strong>Info</strong></td></tr>
                <tr><td><code>author</code></td><td>Author info</td></tr>
            </tbody>
        </table>

        <nav class="docs-pager">
            <a href="session-and-auth.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← Session &amp; Auth</span>
            </a>
            <a href="../frontend/routing.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Frontend Routing →</span>
            </a>
        </nav>

    </main>

</div>

<footer class="docs-footer">
    <p>
        CTRX. Codetazer-X Framework by <a href="#">Tyrone Malocon</a>
        · <a href="https://github.com/YroDevGit/ctrx">GitHub</a>
        · <a href="https://packagist.org/packages/yrodevgit/ctrx">Packagist</a>
    </p>
</footer>

<script src="<?=pagedir('docs/script.js')?>"></script>
<script src="<?=pagedir('js/script.js')?>"></script>
</body>
</html>