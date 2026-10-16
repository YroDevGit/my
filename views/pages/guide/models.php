<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Models. CTRX Documentation</title>
<link rel="stylesheet" href="<?=pagedir('docs/style.css')?>" />
</head>
<body>

<header class="docs-header">
    <div class="docs-header-inner">
        <a href="../index.html" class="docs-logo">Code<span>tazer</span>-X</a>
        <nav class="docs-top-nav">
            <a href="../getting-started/index.html">Get Started</a>
            <a href="routing.html" class="active">Docs</a>
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

    <?= pagedir_include("_inc/aside") ?>

    <main class="docs-content">

        <nav class="breadcrumbs">
            <a href="../index.html">Docs</a>
            <span>/</span>
            <a href="#">Backend</a>
            <span>/</span>
            <span>Models</span>
        </nav>

        <h1>Models</h1>
        <p class="lead">
            CTRX models live in the <code>Tables\</code> namespace. Each
            model wraps one database table and gives you static methods
            for querying, inserting, updating, and deleting records.
            no ORM setup, no migrations to attributes.
        </p>

        <h2 id="generating">Generating a model</h2>

        <p>
            Models are created automatically from your database tables.
            After running migrations, CTRX syncs a base model for each
            table into <code>app/base/</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> db:migrate
<span class="comment"># or, if tables already exist:</span>
<span class="cmd">php cli</span> tables sync
<span class="cmd">php cli</span> db:sync</code></pre>
        </div>

        <p>
            This scans the database, and for every table (except CTRX's
            internal tables), generates a model file:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>app/base/Users.php
app/base/Task.php
app/base/Projects.php
app/base/Clients.php
<span class="comment">// ...one file per table</span></code></pre>
        </div>

        <h2 id="anatomy">What a model looks like</h2>

        <p>
            CTRX generates a minimal class extending <code>BaseTable</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span>
<span class="kw">namespace</span> Tables;

<span class="kw">use</span> Classes\BaseTable;

<span class="kw">class</span> Users <span class="kw">extends</span> BaseTable {

    <span class="kw">protected</span> $table      = <span class="str">"users"</span>;
    <span class="kw">protected</span> $primaryKey = <span class="str">"id"</span>;
    <span class="kw">protected</span> $fillable   = [];
    <span class="kw">protected</span> $guarded    = [];
    <span class="kw">protected</span> $hidden     = [];
    <span class="kw">protected</span> $timestamps = <span class="kw">false</span>;
}</code></pre>
        </div>

        <p>
            Every model is that short. All the query methods come from
            <code>BaseTable</code>. you only edit a model file if you
            need to add custom methods.
        </p>

        <h2 id="api-summary">Method summary</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Arguments</th>
                    <th>Returns</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>findOne()</code></td>
                    <td><code>[$filter]</code></td>
                    <td>array | <code>false</code></td>
                    <td>Fetch a single row</td>
                </tr>
                <tr>
                    <td><code>insert()</code></td>
                    <td><code>[$data]</code></td>
                    <td>object (<code>-&gt;_id()</code>)</td>
                    <td>Create a record</td>
                </tr>
                <tr>
                    <td><code>update()</code></td>
                    <td><code>$id, [$data]</code></td>
                    <td>bool</td>
                    <td>Modify a record by primary key</td>
                </tr>
                <tr>
                    <td><code>delete()</code></td>
                    <td><code>$id</code> <em>or</em> <code>[$filter]</code></td>
                    <td>bool</td>
                    <td>Remove one or more records</td>
                </tr>
            </tbody>
        </table>

        <h2 id="querying">Querying records</h2>

        <h3><code>findOne()</code>. fetch a single row</h3>

        <p>
            Pass a key-value filter. Returns the row as an associative
            array, or <code>false</code> if nothing matches.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Tables\Users;

$user = Users::<span class="fn">findOne</span>([<span class="str">"email"</span> =&gt; $email]);

<span class="kw">if</span> (! $user) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid Email"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// Access columns as array keys:</span>
$user[<span class="str">'id'</span>];
$user[<span class="str">'email'</span>];
$user[<span class="str">'type'</span>];</code></pre>
        </div>

        <p>Multiple filter conditions narrow the result:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>$user = Users::<span class="fn">findOne</span>([
    <span class="str">"email"</span>  =&gt; $email,
    <span class="str">"active"</span> =&gt; <span class="num">1</span>,
]);</code></pre>
        </div>

        <h3><code>insert()</code>. create a record</h3>

        <p>
            Pass an associative array of column values. Returns an object
            with an <code>_id()</code> method for the new row's ID.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Tables\Task;

$result = Task::<span class="fn">insert</span>([
    <span class="str">"project"</span>     =&gt; $project,
    <span class="str">"title"</span>       =&gt; $title,
    <span class="str">"description"</span> =&gt; $description,
    <span class="str">"prio"</span>        =&gt; $prio,
    <span class="str">"assign"</span>      =&gt; $assign,
    <span class="str">"deadline"</span>    =&gt; $deadline,
]);

$newTaskId = $result-&gt;<span class="fn">_id</span>();</code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Note:</strong> <code>insert()</code> returns an
                object, not the ID directly. Call <code>_id()</code> on
                it to get the inserted row's primary key.
            </p>
        </div>

        <h3><code>update()</code>. modify a record</h3>

        <p>
            Pass the record's ID first, then the values to change:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Tables\Users;

Users::<span class="fn">update</span>(<span class="num">5</span>, [
    <span class="str">"active"</span> =&gt; <span class="num">0</span>
]);</code></pre>
        </div>

        <p>
            The first argument is the primary key value. By default CTRX
            uses the <code>id</code> column, but the model's
            <code>$primaryKey</code> property can override it.
        </p>

        <h3><code>delete()</code>. remove a record</h3>

        <p>
            Pass a primary key value directly:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Tables\Task;

Task::<span class="fn">delete</span>(<span class="num">4</span>);</code></pre>
        </div>

        <p>
            Or pass a filter array to delete multiple rows at once:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Task::<span class="fn">delete</span>([<span class="str">"active"</span> =&gt; <span class="num">0</span>]);
Task::<span class="fn">delete</span>([<span class="str">"project"</span> =&gt; $projectId]);
Notes::<span class="fn">delete</span>([<span class="str">"user_id"</span> =&gt; $userId, <span class="str">"active"</span> =&gt; <span class="num">0</span>]);</code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Scalar vs array:</strong> when you pass a number or
                string, CTRX treats it as the primary key. When you pass an
                array, CTRX treats it as a <code>WHERE</code> filter.
            </p>
        </div>

        <h2 id="model-properties">Model properties</h2>

        <p>
            Every generated model exposes a few <code>protected</code>
            properties you can override if you need to:
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>Property</th><th>Purpose</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>$table</code></td>
                    <td>Name of the database table (auto-set)</td>
                </tr>
                <tr>
                    <td><code>$primaryKey</code></td>
                    <td>Name of the primary key column (default <code>"id"</code>)</td>
                </tr>
                <tr>
                    <td><code>$fillable</code></td>
                    <td>Columns that can be mass-assigned</td>
                </tr>
                <tr>
                    <td><code>$guarded</code></td>
                    <td>Columns that can never be mass-assigned</td>
                </tr>
                <tr>
                    <td><code>$hidden</code></td>
                    <td>Columns excluded from output</td>
                </tr>
                <tr>
                    <td><code>$timestamps</code></td>
                    <td>
                        Whether the model manages
                        <code>created_at</code> / <code>updated_at</code>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 id="real-example">Real example. login flow</h2>

        <p>
            This is the exact pattern CTRX uses in <code>user/login.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: user/login</span>

<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Users;

$email    = Validator::<span class="fn">body</span>(<span class="str">"email"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">email</span>()-&gt;<span class="fn">run</span>();
$password = Validator::<span class="fn">body</span>(<span class="str">"password"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">run</span>();

<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">400</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

<span class="comment">// Fetch the user by email</span>
$findUser = Users::<span class="fn">findOne</span>([<span class="str">"email"</span> =&gt; $email]);

<span class="kw">if</span> (! $findUser) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid Email"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// Check active flag</span>
<span class="kw">if</span> ($findUser[<span class="str">'active'</span>] == <span class="num">0</span>) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"User doesn't have access to login"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// Verify password</span>
<span class="kw">if</span> ($password !== $findUser[<span class="str">'password'</span>]) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Incorrect password"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// ...</span></code></pre>
        </div>

        <h2 id="service-models">Service models</h2>

        <p>
            Not every model maps to a table. For business logic. like
            routing tasks through workflow steps. create a
            <strong>service model</strong> in the <code>Models\</code>
            namespace:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> +model Routetasking</code></pre>
        </div>

        <p>
            This creates <code>app/model/Routetasking.php</code> in the
            <code>Models\</code> namespace. Service models don't extend
            <code>BaseTable</code>. they hold methods that operate on
            one or more tables.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Models\Routetasking;

Routetasking::<span class="fn">route</span>($id, <span class="num">1</span>, <span class="fn">val</span>($assign), type: <span class="num">3</span>);</code></pre>
        </div>

        <table class="docs-table">
            <thead>
                <tr><th>Namespace</th><th>Location</th><th>Purpose</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Tables\</code></td>
                    <td><code>app/base/</code></td>
                    <td>Auto-generated, one per DB table</td>
                </tr>
                <tr>
                    <td><code>Models\</code></td>
                    <td><code>app/model/</code></td>
                    <td>Hand-written, business logic</td>
                </tr>
            </tbody>
        </table>

        <h2 id="workflow-pattern">Pattern: history + current state</h2>

        <p>
            The task system in CTRX's sample app uses a two-table pattern:
        </p>

        <ul>
            <li>
                <code>Tables\Task</code>. current state of each task
            </li>
            <li>
                <code>Tables\TaskRoute</code>. every change ever made
                (status transitions, comments, reassignments)
            </li>
        </ul>

        <p>
            When a task is updated, the controller inserts a row into
            <code>task</code> <em>and</em> a row into <code>TaskRoute</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>$res = Task::<span class="fn">insert</span>([...]);
$id  = $res-&gt;<span class="fn">_id</span>();

<span class="comment">// Log the workflow event</span>
Routetasking::<span class="fn">route</span>($id, <span class="num">1</span>, <span class="fn">val</span>($assign), type: <span class="num">3</span>);</code></pre>
        </div>

        <p>
            This gives you a full audit trail without complex event
            sourcing. perfect for project management, ticketing, and
            CRM apps.
        </p>

        <h2 id="cli">Related CLI commands</h2>

        <table class="docs-table">
            <thead>
                <tr><th>Command</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>php cli tables sync</code></td>
                    <td>Generate <code>app/base/*.php</code> for every DB table</td>
                </tr>
                <tr>
                    <td><code>php cli db:sync</code></td>
                    <td>Alias for <code>tables sync</code></td>
                </tr>
                <tr>
                    <td><code>php cli +model Task</code></td>
                    <td>Create a service model in <code>app/model/</code></td>
                </tr>
                <tr>
                    <td><code>php cli download:table users</code></td>
                    <td>Export a table's structure + data to JSON</td>
                </tr>
            </tbody>
        </table>

        <nav class="docs-pager">
            <a href="middleware.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← Middleware</span>
            </a>
            <a href="migrations.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Migrations →</span>
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