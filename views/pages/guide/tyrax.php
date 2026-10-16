<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>TYRAX. CTRX Documentation</title>
<link rel="stylesheet" href="<?=pagedir('docs/style.css')?>" />
</head>
<body>

<header class="docs-header">
    <div class="docs-header-inner">
        <a href="../../index.html" class="docs-logo">Code<span>tazer</span>-X</a>
        <nav class="docs-top-nav">
            <a href="../../getting-started/index.html">Get Started</a>
            <a href="../../concepts/team-workflow.html">Concepts</a>
            <a href="../../tutorials/insert-to-table.html">Tutorials</a>
            <a href="../../reference/helpers.html">Reference</a>
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
            <a href="../../index.html">Docs</a>
            <span>/</span>
            <a href="#">Frontend</a>
            <span>/</span>
            <a href="#">Libraries</a>
            <span>/</span>
            <span>TYRAX</span>
        </nav>

        <h1>TYRAX</h1>
        <p class="lead">
            TYRAX is CTRX's request layer. a declarative alternative to
            <code>fetch()</code> and <code>axios</code>. It handles named
            routes, loading states, and response callbacks in one call.
        </p>

        <h2 id="import">Import</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">import</span> Tyrax <span class="kw">from</span> <span class="str">"../../code/src/tyrux/main.js"</span>;</code></pre>
        </div>

        <p>Adjust the relative path based on where your JS file lives.</p>

        <h2 id="methods">Methods</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Method</th>
                    <th>HTTP verb</th>
                    <th>Use for</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Tyrax.get()</code></td>
                    <td>GET</td>
                    <td>Reading data</td>
                </tr>
                <tr>
                    <td><code>Tyrax.post()</code></td>
                    <td>POST</td>
                    <td>Creating records</td>
                </tr>
                <tr>
                    <td><code>Tyrax.put()</code></td>
                    <td>PUT</td>
                    <td>Full updates</td>
                </tr>
                <tr>
                    <td><code>Tyrax.delete()</code></td>
                    <td>DELETE</td>
                    <td>Removing records</td>
                </tr>
            </tbody>
        </table>

        <p>
            All four methods take the same options object. The examples below
            use <code>post()</code>, but every method works identically.
        </p>

        <h2 id="options">Options</h2>

        <h3><code>url</code> <span class="req">required</span></h3>
        <p>
            Either a named route (matching an <code>as:</code> value in
            <code>api.php</code>) or a controller path.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// By named route</span>
<span class="kw">Tyrax</span>.<span class="fn">post</span>({ url: <span class="str">"login"</span>, ... });

<span class="comment">// By controller path</span>
<span class="kw">Tyrax</span>.<span class="fn">delete</span>({ url: <span class="str">"task/delete"</span>, ... });</code></pre>
        </div>

        <h3><code>req</code> / <code>data</code></h3>
        <p>
            The request body. Both keys are accepted. use whichever reads better.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">Tyrax</span>.<span class="fn">post</span>({
    url: <span class="str">"user/update"</span>,
    req: { name: <span class="str">"Tyrone"</span>, email: <span class="str">"t@x.com"</span> },
    ...
});</code></pre>
        </div>

        <h3><code>params</code></h3>
        <p>
            Query-string parameters. Use for IDs or filters.
            Params are encrypted by CTRX before being sent. the backend
            reads them via <code>Request::get_decrypt()</code>.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">Tyrax</span>.<span class="fn">delete</span>({
    url: <span class="str">"task/delete"</span>,
    params: { task: id },
    ...
});</code></pre>
        </div>

        <h3><code>loading</code></h3>
        <p>
            Show a loading indicator while the request is in flight.
            Pass <code>true</code> for the default, or configure it:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>loading: { id: <span class="str">"loginForm"</span>, size: <span class="num">35</span> }
<span class="comment">// Or, for defaults:</span>
loading: <span class="kw">true</span></code></pre>
        </div>

        <table class="docs-table">
            <thead>
                <tr><th>Key</th><th>Type</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>id</code></td>
                    <td>string</td>
                    <td>Element ID to attach the spinner to</td>
                </tr>
                <tr>
                    <td><code>size</code></td>
                    <td>number</td>
                    <td>Spinner size in pixels</td>
                </tr>
            </tbody>
        </table>

        <h3><code>res</code> <span class="req">required</span></h3>
        <p>
            Response callback. Receives the full response object plus four
            pre-extracted shortcuts:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
    <span class="comment">// send    → full response object</span>
    <span class="comment">// code    → send.code</span>
    <span class="comment">// message → send.message</span>
    <span class="comment">// data    → send.data</span>
    <span class="comment">// errors  → send.errors</span>

    <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) Twal.<span class="fn">ok</span>(message);
    <span class="kw">if</span> (code <span class="op">===</span> <span class="num">401</span>) Twal.<span class="fn">err</span>(message);
    <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) FormValidator.<span class="fn">displayErrors</span>(errors, <span class="str">"#form"</span>);
}</code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Why <code>send</code> matters:</strong> since
                <code>send</code> is the full response object, you can access
                any custom fields the server attached. not just the four
                common ones.
            </p>
        </div>

        <h2 id="full-example">Full example. Login</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">import</span> Ctr <span class="kw">from</span> <span class="str">"../../code/src/mods/ctr.js"</span>;
<span class="kw">import</span> Tyrax <span class="kw">from</span> <span class="str">"../../code/src/tyrux/main.js"</span>;
<span class="kw">import</span> Twal <span class="kw">from</span> <span class="str">"../../code/src/mods/twal.js"</span>;
<span class="kw">import</span> FormValidator <span class="kw">from</span> <span class="str">"../../code/src/mods/formValidator.js"</span>;

Ctr.<span class="fn">submit</span>(<span class="str">"#loginForm"</span>, (data, raw) <span class="kw">=&gt;</span> {
    Tyrax.<span class="fn">post</span>({
        url: <span class="str">"login"</span>,
        req: raw,
        loading: { id: <span class="str">"loginForm"</span>, size: <span class="num">35</span> },
        res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">400</span>) FormValidator.<span class="fn">displayErrors</span>(errors, <span class="str">"#loginForm"</span>);
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">401</span>) Twal.<span class="fn">err</span>(message);
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) Twal.<span class="fn">ok</span>(<span class="str">"You are now logged in"</span>, <span class="kw">true</span>);
        }
    });
});</code></pre>
        </div>

        <nav class="docs-pager">
            <a href="twal.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← TWal</span>
            </a>
            <a href="tmodal.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">TModal →</span>
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