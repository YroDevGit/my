<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Controllers. CTRX Documentation</title>
<link rel="stylesheet" href="<?=pagedir('docs/style.css')?>" />
</head>
<body>

<header class="docs-header">
    <div class="docs-header-inner">
        <a href="../index.html" class="docs-logo">Code<span>tazer</span>-X</a>
        <nav class="docs-top-nav">
            <a href="../getting-started/index.html">Get Started</a>
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

<div class="docs-layout">

    <?=pagedir_include('_inc/aside')?>

    <main class="docs-content">

        <nav class="breadcrumbs">
            <a href="../index.html">Docs</a>
            <span>/</span>
            <a href="#">Backend</a>
            <span>/</span>
            <span>Controllers</span>
        </nav>

        <h1>Controllers</h1>
        <p class="lead">
            A controller is a single PHP file that handles one endpoint.
            No classes, no inheritance, no base class to extend. just
            one file per action, mapped directly to a URL by its path.
        </p>

        <h2 id="convention">File-based controllers</h2>

        <p>
            Every controller lives under <code>app/_controller/</code>.
            The folder path and file name become the URL:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>app/_controller/&lt;folder&gt;/&lt;action&gt;.php   →   /api/&lt;folder&gt;/&lt;action&gt;</code></pre>
        </div>

        <h3>Examples</h3>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>File</th>
                    <th>URL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>_controller/user/login.php</code></td>
                    <td><code>/api/user/login</code></td>
                </tr>
                <tr>
                    <td><code>_controller/user/add.php</code></td>
                    <td><code>/api/user/add</code></td>
                </tr>
                <tr>
                    <td><code>_controller/task/getById.php</code></td>
                    <td><code>/api/task/getById</code></td>
                </tr>
                <tr>
                    <td><code>_controller/task/sendComment.php</code></td>
                    <td><code>/api/task/sendComment</code></td>
                </tr>
                <tr>
                    <td><code>_controller/email/send.php</code></td>
                    <td><code>/api/email/send</code></td>
                </tr>
                <tr>
                    <td><code>_controller/inquiry_type/get.php</code></td>
                    <td><code>/api/inquiry_type/get</code></td>
                </tr>
            </tbody>
        </table>

        <h2 id="generating">Generating a controller</h2>

        <p>
            Use the CLI to scaffold a new controller:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> +controller user/login
<span class="cmd">php cli</span> +ctrl user/login        <span class="comment"># alias</span>
<span class="cmd">php cli</span> +c user/login           <span class="comment"># alias</span></code></pre>
        </div>

        <p>
            This creates <code>app/_controller/user/login.php</code> with
            the correct header comment and directory structure. If the
            folder doesn't exist yet, CTRX creates it.
        </p>

        <p>
            Generate multiple controllers at once with comma separation:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> +controller admin/add,edit,delete</code></pre>
        </div>

        <h2 id="anatomy">Anatomy of a controller</h2>

        <p>
            A controller is a plain PHP file. It runs top to bottom when
            its URL is hit. There's no class, no method, no function
            wrapper. just executable code.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: user/login</span>

<span class="comment">// 1. Imports</span>
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Users;

<span class="comment">// 2. Read input</span>
$email    = Validator::<span class="fn">body</span>(<span class="str">"email"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">email</span>()-&gt;<span class="fn">run</span>();
$password = Validator::<span class="fn">body</span>(<span class="str">"password"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">run</span>();

<span class="comment">// 3. Validate</span>
<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">400</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

<span class="comment">// 4. Business logic</span>
$findUser = Users::<span class="fn">findOne</span>([<span class="str">"email"</span> =&gt; $email]);

<span class="kw">if</span> (! $findUser) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid Email"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// 5. Respond</span>
Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"OK"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <p>
            That's the whole pattern. Every controller follows the same
            five steps.
        </p>

        <h2 id="five-steps">The five-step pattern</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Step</th>
                    <th>What you write</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1. Imports</td>
                    <td><code>use Classes\...</code> for framework classes, <code>use Tables\...</code> for models</td>
                </tr>
                <tr>
                    <td>2. Read input</td>
                    <td>
                        <code>Validator::body()</code> /
                        <code>Validator::post()</code> /
                        <code>Request::get_decrypt()</code>
                    </td>
                </tr>
                <tr>
                    <td>3. Validate</td>
                    <td>
                        <code>if ($errors = Validator::errors()) {
                        Response::code(422)-&gt;errors($errors)-&gt;send(); }</code>
                    </td>
                </tr>
                <tr>
                    <td>4. Business logic</td>
                    <td>
                        Query models, insert records, call services
                    </td>
                </tr>
                <tr>
                    <td>5. Respond</td>
                    <td>
                        <code>Response::code(...)-&gt;message(...)-&gt;send()</code>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 id="reading-input">Reading input</h2>

        <p>
            CTRX gives you several ways to read request data. Pick the
            one that matches where the data lives:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Source</th>
                    <th>Use</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>JSON body / form body</td>
                    <td><code>Validator::body("field")</code></td>
                </tr>
                <tr>
                    <td>POST fields</td>
                    <td><code>Validator::post("field")</code></td>
                </tr>
                <tr>
                    <td>Encrypted GET params</td>
                    <td><code>Request::get_decrypt("id")</code></td>
                </tr>
                <tr>
                    <td>Raw POST value</td>
                    <td><code>post("field")</code></td>
                </tr>
                <tr>
                    <td>Headers</td>
                    <td><code>Request::headers("apikey")</code></td>
                </tr>
            </tbody>
        </table>

        <h3>Reading with a validator chain</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>$email = Validator::<span class="fn">body</span>(<span class="str">"email"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"Email"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">maxChars</span>(<span class="num">60</span>)
    -&gt;<span class="fn">email</span>()
    -&gt;<span class="fn">run</span>();

$password = Validator::<span class="fn">body</span>(<span class="str">"password"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"Password"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">run</span>();</code></pre>
        </div>

        <p>
            Validator chains handle both reading <em>and</em> validating in
            one step. The terminal <code>run()</code> (or
            <code>exec()</code>) executes the chain and returns the
            value.
        </p>

        <h3>Reading encrypted params</h3>

        <p>
            When the frontend sends data through <code>params</code> in
            TYRAX, it's encrypted. Read it on the backend with
            <code>get_decrypt()</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>$project = Request::<span class="fn">get_decrypt</span>(<span class="str">"id"</span>);

<span class="kw">if</span> (! $project) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Project error"</span>)-&gt;<span class="fn">send</span>();
}</code></pre>
        </div>

        <p>
            This protects IDs in URLs from enumeration. clients can't
            just try <code>?id=1</code>, <code>?id=2</code>, etc.
        </p>

        <h2 id="validation">Validation</h2>

        <p>
            After reading all fields, check for errors. If any exist,
            respond with a validation status code:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}</code></pre>
        </div>

        <p>
            The <code>errors</code> object maps field names to messages:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"code"</span>: <span class="num">422</span>,
    <span class="str">"message"</span>: <span class="str">"Validation failed"</span>,
    <span class="str">"errors"</span>: {
        <span class="str">"email"</span>: <span class="str">"Email is required"</span>,
        <span class="str">"password"</span>: <span class="str">"Password is required"</span>
    }
}</code></pre>
        </div>

        <p>
            The frontend passes this to
            <code>FormValidator.displayErrors()</code> or
            <code>modal_x.displayErrors()</code>. the messages appear
            under the matching input fields automatically.
        </p>

        <h2 id="business-logic">Business logic</h2>

        <p>
            The middle of a controller does the actual work: querying
            models, inserting records, calling services.
        </p>

        <h3>Query a record</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Tables\Users;

$user = Users::<span class="fn">findOne</span>([<span class="str">"email"</span> =&gt; $email]);

<span class="kw">if</span> (! $user) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid Email"</span>)-&gt;<span class="fn">send</span>();
}</code></pre>
        </div>

        <h3>Insert a record</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Tables\Task;

$result = Task::<span class="fn">insert</span>([
    <span class="str">"project"</span>     =&gt; $project,
    <span class="str">"title"</span>       =&gt; $title,
    <span class="str">"description"</span> =&gt; $description,
    <span class="str">"assign"</span>      =&gt; $assign,
    <span class="str">"deadline"</span>    =&gt; $deadline,
]);

$newId = $result-&gt;<span class="fn">_id</span>();</code></pre>
        </div>

        <h3>Update a record</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Users::<span class="fn">update</span>(<span class="num">5</span>, [<span class="str">"active"</span> =&gt; <span class="num">0</span>]);</code></pre>
        </div>

        <h3>Delete a record</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Task::<span class="fn">delete</span>(<span class="num">4</span>);
Task::<span class="fn">delete</span>([<span class="str">"active"</span> =&gt; <span class="num">0</span>]);   <span class="comment">// bulk delete</span></code></pre>
        </div>

        <h3>Call a service model</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Models\Routetasking;

Routetasking::<span class="fn">route</span>($id, <span class="num">1</span>, <span class="fn">val</span>($assign), type: <span class="num">3</span>);</code></pre>
        </div>

        <h2 id="responding">Responding</h2>

        <p>
            Every controller ends with a <code>Response</code> call.
            Chain the pieces you need, then call <code>send()</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Success</span>
Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"OK"</span>)-&gt;<span class="fn">send</span>();

<span class="comment">// Error</span>
Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid Email"</span>)-&gt;<span class="fn">send</span>();

<span class="comment">// Validation errors</span>
Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();

<span class="comment">// With data</span>
Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">data</span>($rows)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <p>
            <code>send()</code> outputs the JSON response and stops
            execution. Nothing after it runs, so you can chain
            <code>send()</code> at the end of an <code>if</code> branch
            without worrying about fallthrough.
        </p>

        <h2 id="full-example">Full example. user/login</h2>

        <p>
            Here's the complete login controller, annotated:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">//route: user/login</span>

<span class="comment">// ── Imports ─────────────────────────────</span>
<span class="kw">use</span> Classes\Ctrx;
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\TCookie;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Users;

<span class="comment">// ── Read input ──────────────────────────</span>
$email = Validator::<span class="fn">body</span>(<span class="str">"email"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"Email"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">maxChars</span>(<span class="num">60</span>)
    -&gt;<span class="fn">email</span>()
    -&gt;<span class="fn">run</span>();

$password = Validator::<span class="fn">body</span>(<span class="str">"password"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"Password"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">run</span>();

<span class="comment">// ── Validate ────────────────────────────</span>
<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">400</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

<span class="comment">// ── Find user ───────────────────────────</span>
$findUser = Users::<span class="fn">findOne</span>([<span class="str">"email"</span> =&gt; $email]);

<span class="kw">if</span> (! $findUser) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid Email"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// ── Check active flag ───────────────────</span>
<span class="kw">if</span> ($findUser[<span class="str">'active'</span>] == <span class="num">0</span>) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"User doesn't have access to login"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// ── Verify password ─────────────────────</span>
<span class="kw">if</span> ($password !== $findUser[<span class="str">'password'</span>]) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Incorrect password"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// ── Remember me ─────────────────────────</span>
$remember = <span class="fn">post</span>(<span class="str">"remember"</span>);
<span class="kw">if</span> ($remember) {
    TCookie::<span class="fn">add</span>(key: <span class="str">"remember"</span>, value: [<span class="str">"email"</span> =&gt; $email, <span class="str">"password"</span> =&gt; $password]);
} <span class="kw">else</span> {
    TCookie::<span class="fn">delete</span>(<span class="str">"remember"</span>);
}

<span class="comment">// ── Set session by role ─────────────────</span>
<span class="kw">if</span> ($findUser[<span class="str">'type'</span>] == <span class="num">1</span>) {
    Ctrx::<span class="fn">set_user_data</span>([<span class="str">"id"</span> =&gt; $findUser[<span class="str">'id'</span>], <span class="str">"email"</span> =&gt; $findUser[<span class="str">'email'</span>]]);
    Ctrx::<span class="fn">set_user_role</span>(<span class="str">"SA"</span>);
    Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"OK"</span>)-&gt;<span class="fn">send</span>();
}
<span class="comment">// ... type 2 → AD, type 3 → MG, etc.</span>

Response::<span class="fn">code</span>(<span class="num">400</span>)-&gt;<span class="fn">message</span>(<span class="str">"Login error, please contact admin"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <h2 id="naming-conventions">Naming conventions</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Element</th>
                    <th>Convention</th>
                    <th>Example</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Folder</td>
                    <td>lowercase, underscore if needed</td>
                    <td><code>user/</code>, <code>inquiry_type/</code></td>
                </tr>
                <tr>
                    <td>File</td>
                    <td>camelCase for multi-word actions</td>
                    <td><code>getById.php</code>, <code>sendComment.php</code></td>
                </tr>
                <tr>
                    <td>Simple actions</td>
                    <td>single lowercase word</td>
                    <td><code>add.php</code>, <code>get.php</code>, <code>update.php</code></td>
                </tr>
            </tbody>
        </table>

        <div class="callout">
            <p>
                <strong>URLs are case-sensitive.</strong>
                <code>/api/task/getById</code> and
                <code>/api/task/getbyid</code> are different routes.
                Match the filename exactly when calling from the frontend.
            </p>
        </div>

        <h2 id="directory-tree">Typical controller tree</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>app/_controller/
├─ user/
│  ├─ login.php
│  ├─ add.php
│  ├─ update.php
│  ├─ getById.php
│  └─ inquire.php
├─ task/
│  ├─ add.php
│  ├─ getById.php
│  ├─ sendComment.php
│  └─ updateStatus.php
├─ project/
│  ├─ add.php
│  ├─ update.php
│  ├─ delete.php
│  └─ getById.php
├─ note/
│  ├─ add.php
│  ├─ get.php
│  └─ delete.php
└─ email/
   └─ send.php</code></pre>
        </div>

        <h2 id="one-file-one-endpoint">One file, one endpoint</h2>

        <p>
            There's no "controller class" with multiple methods. If you
            need five actions for tasks, you create five files:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>app/_controller/task/add.php
app/_controller/task/update.php
app/_controller/task/delete.php
app/_controller/task/get.php
app/_controller/task/getById.php</code></pre>
        </div>

        <p>
            Each one is completely independent. This is what makes the
            file-based routing work. a URL maps to exactly one file,
            and that file has exactly one job.
        </p>

        <h2 id="quick-reference">Quick reference</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Code</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Read JSON body</td>
                    <td><code>Validator::body("field")</code></td>
                </tr>
                <tr>
                    <td>Read POST</td>
                    <td><code>Validator::post("field")</code></td>
                </tr>
                <tr>
                    <td>Read encrypted param</td>
                    <td><code>Request::get_decrypt("id")</code></td>
                </tr>
                <tr>
                    <td>Read header</td>
                    <td><code>Request::headers("apikey")</code></td>
                </tr>
                <tr>
                    <td>Check for errors</td>
                    <td><code>if ($errors = Validator::errors()) {...}</code></td>
                </tr>
                <tr>
                    <td>Find one record</td>
                    <td><code>Users::findOne(["email" =&gt; $email])</code></td>
                </tr>
                <tr>
                    <td>Insert a record</td>
                    <td><code>Task::insert([...])-&gt;_id()</code></td>
                </tr>
                <tr>
                    <td>Update a record</td>
                    <td><code>Users::update($id, [...])</code></td>
                </tr>
                <tr>
                    <td>Delete a record</td>
                    <td><code>Task::delete($id)</code></td>
                </tr>
                <tr>
                    <td>Respond success</td>
                    <td><code>Response::code(200)-&gt;message("OK")-&gt;send()</code></td>
                </tr>
                <tr>
                    <td>Respond error</td>
                    <td><code>Response::code(401)-&gt;message("...")-&gt;send()</code></td>
                </tr>
                <tr>
                    <td>Respond validation</td>
                    <td><code>Response::code(422)-&gt;errors($errors)-&gt;send()</code></td>
                </tr>
            </tbody>
        </table>

        <nav class="docs-pager">
            <a href="routing.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← Routing</span>
            </a>
            <a href="response.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Response →</span>
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