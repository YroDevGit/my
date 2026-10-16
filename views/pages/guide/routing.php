<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Routing. CTRX Documentation</title>
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

    <!-- ============ SIDEBAR ============ -->
    <?=pagedir_include('_inc/aside')?>

    <!-- ============ CONTENT ============ -->
    <main class="docs-content">

        <nav class="breadcrumbs">
            <a href="../index.html">Docs</a>
            <span>/</span>
            <a href="#">Backend</a>
            <span>/</span>
            <span>Routing</span>
        </nav>

        <h1>Routing</h1>
        <p class="lead">
            CTRX uses <strong>file-based routing</strong>. Every endpoint maps to a
            file, and every file has a URL. No config files, no route registration.
        </p>

        <h2 id="url-to-file">URL → File mapping</h2>
        <p>
            Each controller file under <code>app/_controller/</code> becomes an API
            endpoint. The folder path and file name become the URL.
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>File</th>
                    <th>URL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>app/_controller/user/login.php</code></td>
                    <td><code>/api/user/login</code></td>
                </tr>
                <tr>
                    <td><code>app/_controller/task/getById.php</code></td>
                    <td><code>/api/task/getById</code></td>
                </tr>
                <tr>
                    <td><code>app/_controller/email/send.php</code></td>
                    <td><code>/api/email/send</code></td>
                </tr>
            </tbody>
        </table>

        <h2 id="declaring">Declaring routes</h2>
        <p>
            Routes are declared in <code>app/_routes/api.php</code>.
            Use <code>Router::group()</code> with one or more <code>makeRoute()</code> calls.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span>

<span class="kw">use</span> Classes\Router;

Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"get"</span>,  controller: <span class="str">"admin/add"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>, controller: <span class="str">"user/inquire"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"get"</span>,  controller: <span class="str">"inquiry_type/get"</span>)
);</code></pre>
        </div>

        <h3><code>makeRoute()</code> parameters</h3>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Param</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>method</code></td>
                    <td>string</td>
                    <td>HTTP verb: <code>get</code>, <code>post</code>, <code>put</code>, <code>delete</code></td>
                </tr>
                <tr>
                    <td><code>controller</code></td>
                    <td>string</td>
                    <td>Path under <code>_controller/</code> without <code>.php</code></td>
                </tr>
                <tr>
                    <td><code>as</code></td>
                    <td>string</td>
                    <td><em>Optional.</em> Named route. used by TYRAX on the frontend</td>
                </tr>
            </tbody>
        </table>

        <h2 id="named-routes">Named routes</h2>
        <p>
            Adding <code>as:</code> gives a route a name. Named routes let the frontend
            reference endpoints by name instead of by URL. so refactoring the backend
            doesn't break the frontend.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="fn">makeRoute</span>(method: <span class="str">"post"</span>, controller: <span class="str">"user/login"</span>, as: <span class="str">"login"</span>)</code></pre>
        </div>

        <p>The frontend can now call it by name:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">Tyrax</span>.<span class="fn">post</span>({
    url: <span class="str">"login"</span>,
    req: raw,
    res: (send, code, message) <span class="kw">=&gt;</span> { <span class="comment">/* ... */</span> }
});</code></pre>
        </div>

        <h2 id="middleware">Attaching middleware</h2>
        <p>
            Call <code>-&gt;middleware("name")</code> on a group. CTRX resolves the name
            to <code>app/middleware/&lt;name&gt;.php</code>.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>, controller: <span class="str">"note/add"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"get"</span>,  controller: <span class="str">"note/get"</span>)
)-&gt;<span class="fn">middleware</span>(<span class="str">"g1"</span>);</code></pre>
        </div>

        <h2 id="inline-handlers">Inline handlers with <code>run()</code></h2>
        <p>
            Attach logic that runs when the group matches. perfect for throttling,
            API key checks, or one-off guards.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>, controller: <span class="str">"user/login"</span>, as: <span class="str">"login"</span>)
)-&gt;<span class="fn">run</span>(<span class="kw">function</span> () {
    Ctrx::<span class="fn">throttle</span>(<span class="num">5</span>, <span class="num">180</span>);  <span class="comment">// 5 requests per 180 seconds</span>
});</code></pre>
        </div>

        <h2 id="full-example">Full example</h2>
        <p>
            A complete <code>api.php</code> showing public routes, throttled login,
            and an authenticated group.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span>

<span class="kw">use</span> Classes\Ctrx;
<span class="kw">use</span> Classes\Request;
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Router;

<span class="comment">// Public routes. no authentication</span>
Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"get"</span>,  controller: <span class="str">"inquiry_type/get"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"get"</span>,  controller: <span class="str">"task/get"</span>)
);

<span class="comment">// Login. throttled to 5 attempts per 3 minutes</span>
Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>, controller: <span class="str">"user/login"</span>, as: <span class="str">"login"</span>)
)-&gt;<span class="fn">run</span>(<span class="kw">function</span> () {
    Ctrx::<span class="fn">throttle</span>(<span class="num">5</span>, <span class="num">180</span>);
});

<span class="comment">// Authenticated group</span>
Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>,   controller: <span class="str">"note/add"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"get"</span>,    controller: <span class="str">"note/get"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"delete"</span>, controller: <span class="str">"note/delete"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>,   controller: <span class="str">"project/add"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"put"</span>,    controller: <span class="str">"project/update"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"delete"</span>, controller: <span class="str">"project/delete"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>,   controller: <span class="str">"task/add"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"put"</span>,    controller: <span class="str">"task/update"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"delete"</span>, controller: <span class="str">"task/delete"</span>)
)-&gt;<span class="fn">middleware</span>(<span class="str">"g1"</span>);</code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Tip:</strong> Named routes and middleware can be combined.
                A named route inside a middleware group still resolves by name
                on the frontend. the middleware just runs first.
            </p>
        </div>

        <!-- Prev / Next -->
        <nav class="docs-pager">
            <a href="controllers.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Controllers →</span>
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

<script src="docs/script.js"></script>
<script src="<?=pagedir('js/script.js')?>"></script>
</body>
</html>