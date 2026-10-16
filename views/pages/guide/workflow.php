<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Team Workflow. CTRX Documentation</title>
<link rel="stylesheet" href="<?=pagedir('docs/style.css')?>" />
</head>
<body>

<header class="docs-header">
    <div class="docs-header-inner">
        <a href="../index.html" class="docs-logo">Code<span>tazer</span>-X</a>
        <nav class="docs-top-nav">
            <a href="../getting-started/index.html">Get Started</a>
            <a href="team-workflow.html" class="active">Concepts</a>
            <a href="../tutorials/insert-to-table.html">Tutorials</a>
            <a href="../reference/helpers.html">Reference</a>
        </nav>
        <div class="docs-header-actions">
            <a href="https://github.com/YroDevGit/ctrx" target="_blank">GitHub</a>
            <a href="https://packagist.org/packages/yrodevgit/ctrx" target="_blank">Packagist</a>
        </div>
    </div>
</header>

<div class="docs-layout">

    <?=pagedir_include('_inc/aside')?>

    <main class="docs-content">

        <nav class="breadcrumbs">
            <a href="../index.html">Docs</a>
            <span>/</span>
            <a href="#">Concepts</a>
            <span>/</span>
            <span>Team Workflow</span>
        </nav>

        <h1>Team Workflow</h1>
        <p class="lead">
            CTRX is built around one idea: <strong>backend and frontend
            developers should never touch the same file.</strong> This
            page explains how that boundary works, why it matters, and
            what it means for your team.
        </p>

        <!-- ============================================================ -->
        <h2 id="the-problem">The problem CTRX solves</h2>

        <p>
            In most PHP frameworks, backend and frontend code live side
            by side. A controller decides what a page looks like. A
            Blade template calls a database query. A route file is
            edited by both teams. Every sprint, someone has to resolve
            a merge conflict in a file neither dev felt comfortable
            touching.
        </p>

        <p>
            The result: slow handoffs, unclear ownership, and friction
            that compounds the moment your team grows past one person.
        </p>

        <p>
            CTRX was built to eliminate this entirely.
        </p>

        <!-- ============================================================ -->
        <h2 id="the-boundary">The boundary</h2>

        <p>
            CTRX splits your project into two independent halves:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>app/        ← BACKEND only
views/      ← FRONTEND only</code></pre>
        </div>

        <p>
            That's it. Two folders. One boundary. And it's enforced by
            the framework. not by convention, not by discipline, not
            by code review. <strong>By structure.</strong>
        </p>

        <h3>Backend owns <code>app/</code></h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>app/
├─ _routes/api.php        <span class="comment">← endpoint definitions</span>
├─ _controller/*          <span class="comment">← business logic</span>
├─ base/*                 <span class="comment">← models (auto-generated)</span>
├─ model/*                <span class="comment">← service classes</span>
├─ middleware/*           <span class="comment">← auth, throttling, guards</span>
├─ config/*               <span class="comment">← migration, autoload</span>
└─ php/core/*             <span class="comment">← framework internals</span></code></pre>
        </div>

        <h3>Frontend owns <code>views/</code></h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>views/
├─ pages/*.php            <span class="comment">← HTML pages</span>
├─ js/*.js                <span class="comment">← page scripts (auto-paired)</span>
├─ assets/*               <span class="comment">← CSS, images, fonts</span>
├─ code/src/mods/*        <span class="comment">← UI library (TWal, TModal...)</span>
└─ code/src/tyrux/*       <span class="comment">← request layer (Tyrax)</span></code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Read that again:</strong> the frontend developer
                never opens a file inside <code>app/</code>. The backend
                developer never opens a file inside <code>views/</code>.
                This isn't a rule they have to follow. it's the shape
                of the framework.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="the-contract">The contract between them</h2>

        <p>
            If the two sides never share files, how do they connect?
        </p>

        <p>
            Through a single, stable contract:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>A route name     +     a response shape</code></pre>
        </div>

        <h3>1. The route name</h3>

        <p>
            The backend defines an endpoint with a name:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// app/_routes/api.php</span>
Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>, controller: <span class="str">"task/add"</span>, as: <span class="str">"task/create"</span>)
)-&gt;<span class="fn">middleware</span>(<span class="str">"g1"</span>);</code></pre>
        </div>

        <p>
            The frontend calls that name. <strong>never the URL, never
            the controller path</strong>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// views/js/auth/manageProject.js</span>
Tyrax.<span class="fn">post</span>({
    url: <span class="str">"task/create"</span>,     <span class="comment">// ← the name</span>
    req: raw,
    res: (send, code, message) <span class="kw">=&gt;</span> { ... }
});</code></pre>
        </div>

        <p>
            The backend can rename <code>task/add.php</code> to
            <code>task/create.php</code>, move it to a different folder,
            or refactor the entire controller. <strong>the frontend
            keeps working</strong>. The contract is the name.
        </p>

        <h3>2. The response shape</h3>

        <p>
            Both sides agree on one JSON shape, and it never changes:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"code"</span>:    <span class="num">200</span>,
    <span class="str">"message"</span>: <span class="str">"OK"</span>,
    <span class="str">"data"</span>:    <span class="kw">null</span>,
    <span class="str">"errors"</span>:  <span class="kw">null</span>
}</code></pre>
        </div>

        <p>
            The frontend knows exactly what to check:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
    <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) { <span class="comment">/* success */</span> }
    <span class="kw">if</span> (code <span class="op">===</span> <span class="num">401</span>) { <span class="comment">/* unauthorized */</span> }
    <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) { <span class="comment">/* validation */</span> }
}</code></pre>
        </div>

        <p>
            The response shape is the same for every endpoint in CTRX.
            Once the frontend dev has handled one, they've handled them
            all.
        </p>

        <!-- ============================================================ -->
        <h2 id="the-handoff">The handoff</h2>

        <p>
            Here's what a real feature handoff looks like in CTRX:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>┌─────────────────────────────────────────────────────┐
│ BACKEND DEV                                          │
│                                                      │
│ 1. Adds route:                                       │
│    makeRoute(method:"post",                          │
│               controller:"task/add",                 │
│               as:"task/create")                      │
│                                                      │
│ 2. Builds controller:                                │
│    app/_controller/task/add.php                      │
│                                                      │
│ 3. Tests with curl/Postman:                          │
│    POST /api/task/add                                │
│    → 200 { code:200, message:"OK" }                  │
│    → 422 { code:422, errors:{...} }                  │
│                                                      │
│ 4. Sends frontend dev a message:                     │
│    ┌─────────────────────────────────────────────┐   │
│    │  Endpoint: task/create                      │   │
│    │  Method:   POST                             │   │
│    │  Payload:  { title, description, prio,      │   │
│    │              deadline, remarks }            │   │
│    │  Returns:                                   │   │
│    │    200 → success                            │   │
│    │    401 → unauthorized                       │   │
│    │    422 → validation errors                  │   │
│    └─────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────┐
│ FRONTEND DEV                                         │
│                                                      │
│ 1. Builds page:                                      │
│    views/pages/auth/manageProject.php                │
│                                                      │
│ 2. Builds JS:                                        │
│    views/js/auth/manageProject.js                    │
│                                                      │
│ 3. Wires the call:                                   │
│    Tyrax.post({                                      │
│      url: "task/create",                             │
│      req: raw,                                       │
│      res: (send, code, message, data, errors) => {   │
│        if (code === 200) Twal.ok("Done");            │
│        if (code === 422) showErrors(errors);         │
│      }                                               │
│    });                                               │
│                                                      │
│ 4. Done. No coordination needed.                     │
└─────────────────────────────────────────────────────┘</code></pre>
        </div>

        <p>
            The two developers never opened the same file. They never
            had to coordinate a merge. They never had to ask "is this
            yours or mine?"
        </p>

        <!-- ============================================================ -->
        <h2 id="why-it-works">Why this works</h2>

        <h3>No file collisions, ever</h3>

        <p>
            When two people edit the same file in git, you get a merge
            conflict. When they edit different files, you don't.
            CTRX makes collisions <strong>structurally impossible</strong>
            by ensuring the two teams work in different folders.
        </p>

        <h3>No cross-language coupling</h3>

        <p>
            In Laravel, a Blade template can call a PHP model. In CTRX,
            a frontend page can only call a named route via
            <code>Tyrax.post()</code>. The boundary is enforced by the
            language itself. PHP lives in <code>app/</code>, JS lives
            in <code>views/</code>, and they only talk over HTTP.
        </p>

        <h3>Independent testability</h3>

        <p>
            The backend dev can test the endpoint with curl or Postman
            without ever touching the UI. The frontend dev can build the
            UI with mock data before the endpoint even exists. Both
            sides move in parallel.
        </p>

        <h3>Independent deployability</h3>

        <p>
            If you ever split the app into separate repos, or serve the
            frontend as a static site talking to a remote API. the
            boundary is already there. Nothing needs refactoring.
        </p>

        <!-- ============================================================ -->
        <h2 id="the-two-exceptions">The only two shared spots</h2>

        <p>
            Every rule has exceptions. CTRX has exactly two:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Who touches it</th>
                    <th>Frequency</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>.env</code></td>
                    <td>Both (rarely)</td>
                    <td>Once at setup, sometimes for API keys</td>
                </tr>
                <tr>
                    <td><code>vendor/</code></td>
                    <td>Both (indirectly)</td>
                    <td>When someone runs <code>composer require</code></td>
                </tr>
            </tbody>
        </table>

        <p>
            <code>.env</code> holds environment variables. database
            credentials, API keys, the site URL. Both devs see it, but
            rarely edit it, and never simultaneously.
        </p>

        <p>
            <code>vendor/</code> is Composer's dependency folder. It's
            committed (or not) as a whole. No one edits it by hand.
        </p>

        <p>
            That's it. Every other file in the project belongs to
            exactly one side.
        </p>

        <!-- ============================================================ -->
        <h2 id="solo-dev">What about solo developers?</h2>

        <p>
            If you're building alone, the same boundary still helps.
            because it forces <strong>discipline you'd otherwise have to
            impose on yourself</strong>.
        </p>

        <p>
            When you're in "backend mode," you stay in
            <code>app/</code>. When you're in "frontend mode," you stay
            in <code>views/</code>. Switching contexts becomes a
            physical act. open a different folder. The framework makes
            it hard to accidentally mix concerns.
        </p>

        <p>
            It also means you can hand off one half of the project to a
            contractor without exposing the other half. "Here's the
            frontend, here's the API documentation. go."
        </p>

        <!-- ============================================================ -->
        <h2 id="comparison">How CTRX compares</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Concern</th>
                    <th>Typical PHP framework</th>
                    <th>CTRX</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Where routes live</td>
                    <td>Both devs edit <code>routes/web.php</code></td>
                    <td>Backend-only <code>app/_routes/api.php</code></td>
                </tr>
                <tr>
                    <td>Frontend knows URLs</td>
                    <td>Hardcoded strings in JS</td>
                    <td>Named routes via <code>Tyrax</code></td>
                </tr>
                <tr>
                    <td>Backend renames a controller</td>
                    <td>Frontend breaks</td>
                    <td>Frontend keeps working</td>
                </tr>
                <tr>
                    <td>Merge conflicts on routes</td>
                    <td>Common</td>
                    <td>Impossible</td>
                </tr>
                <tr>
                    <td>Frontend touches backend files</td>
                    <td>Frequently (Blade templates)</td>
                    <td>Never</td>
                </tr>
                <tr>
                    <td>Backend touches frontend files</td>
                    <td>Frequently (view data)</td>
                    <td>Never</td>
                </tr>
                <tr>
                    <td>Onboarding a new team member</td>
                    <td>"Learn the whole stack"</td>
                    <td>"You only need <code>app/</code>" or "you only need <code>views/</code>"</td>
                </tr>
            </tbody>
        </table>

        <p>
            Every row is a real friction point that CTRX removes.
        </p>

        <!-- ============================================================ -->
        <h2 id="boundaries">Where the boundary lives in code</h2>

        <p>
            A quick reference for what belongs where:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Folder</th>
                    <th>Owner</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Define a new API endpoint</td>
                    <td><code>app/_routes/api.php</code></td>
                    <td>Backend</td>
                </tr>
                <tr>
                    <td>Write the endpoint logic</td>
                    <td><code>app/_controller/*</code></td>
                    <td>Backend</td>
                </tr>
                <tr>
                    <td>Add a validation rule</td>
                    <td><code>app/_controller/*</code></td>
                    <td>Backend</td>
                </tr>
                <tr>
                    <td>Query a table</td>
                    <td><code>app/base/*</code></td>
                    <td>Backend</td>
                </tr>
                <tr>
                    <td>Add a database table</td>
                    <td><code>app/config/migration.php</code></td>
                    <td>Backend</td>
                </tr>
                <tr>
                    <td>Protect an endpoint with auth</td>
                    <td><code>app/middleware/*</code></td>
                    <td>Backend</td>
                </tr>
                <tr>
                    <td>Create a page</td>
                    <td><code>views/pages/*</code></td>
                    <td>Frontend</td>
                </tr>
                <tr>
                    <td>Add page-specific JS</td>
                    <td><code>views/js/*</code></td>
                    <td>Frontend</td>
                </tr>
                <tr>
                    <td>Style a component</td>
                    <td><code>views/assets/*</code></td>
                    <td>Frontend</td>
                </tr>
                <tr>
                    <td>Open a modal</td>
                    <td><code>views/js/*</code></td>
                    <td>Frontend</td>
                </tr>
                <tr>
                    <td>Call an endpoint</td>
                    <td><code>views/js/*</code></td>
                    <td>Frontend</td>
                </tr>
                <tr>
                    <td>Show a toast</td>
                    <td><code>views/js/*</code></td>
                    <td>Frontend</td>
                </tr>
            </tbody>
        </table>

        <!-- ============================================================ -->
        <h2 id="in-practice">In practice</h2>

        <p>
            Consider a real feature: <em>"Let users create notes."</em>
        </p>

        <p>
            <strong>Week 1. Backend dev:</strong>
        </p>

        <ul>
            <li>
                Add <code>notes</code> table in
                <code>app/config/migration.php</code>
            </li>
            <li>
                Add route <code>makeRoute(method:"post", controller:"note/add", as:"note/create")</code>
            </li>
            <li>
                Create <code>app/_controller/note/add.php</code>
            </li>
            <li>
                Test with curl: <code>POST /api/note/add → 200</code>
            </li>
            <li>
                Message frontend dev: <em>"note/create is live, payload is
                { title, description }, returns 200 / 422"</em>
            </li>
        </ul>

        <p>
            <strong>Week 1 (same week). Frontend dev:</strong>
        </p>

        <ul>
            <li>
                Create <code>views/pages/auth/notes.php</code>
            </li>
            <li>
                Create <code>views/js/auth/notes.js</code>
            </li>
            <li>
                Build the UI with <code>TModal.init()</code>
            </li>
            <li>
                Call <code>Tyrax.post({ url: "note/create", ... })</code>
            </li>
            <li>
                Handle 200 / 422 with <code>Twal.ok()</code> and
                <code>modal_x.displayErrors()</code>
            </li>
        </ul>

        <p>
            <strong>End of Week 1. Merge:</strong>
        </p>

        <ul>
            <li>Zero git conflicts</li>
            <li>Zero coordination needed after the initial handoff</li>
            <li>Two developers, one feature, half the time</li>
        </ul>

        <div class="callout">
            <p>
                <strong>This is the entire pitch for CTRX.</strong>
                Everything else in the framework exists to serve this
                workflow. the named routes, the response shape, the
                <code>app/</code> and <code>views/</code> split, the
                bundled JS libraries. All of it is here so teams can
                build faster together.
            </p>
        </div>

        <nav class="docs-pager">
            <a href="../getting-started/directory-structure.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← Directory Structure</span>
            </a>
            <a href="../backend/routing.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Backend Routing →</span>
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