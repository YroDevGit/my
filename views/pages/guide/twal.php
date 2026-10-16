<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>TWal. CTRX Documentation</title>
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
            <a href="#">Frontend</a>
            <span>/</span>
            <a href="#">Libraries</a>
            <span>/</span>
            <span>TWal</span>
        </nav>

        <h1>TWal</h1>
        <p class="lead">
            TWal is CTRX's alert and modal system. a configurable
            alternative to SweetAlert. It handles success toasts, error
            dialogs, confirmation prompts, and fully custom modal
            content, all from a single API.
        </p>

        <h2 id="import">Import</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">import</span> Twal <span class="kw">from</span> <span class="str">"../../code/src/mods/twal.js"</span>;</code></pre>
        </div>

        <p>
            Adjust the relative path based on where your JS file lives.
            From <code>views/js/user/login.js</code>, the path above is
            correct. From <code>views/js/auth/notes.js</code>, the path
            is the same depth, so it works unchanged.
        </p>

        <h2 id="shorthands">Shorthand methods</h2>

        <p>
            TWal ships with four shorthand methods for common cases.
            Each one accepts <strong>either a string</strong> or a
            <strong>config object</strong>.
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Twal.ok()</code></td>
                    <td>Success notification</td>
                </tr>
                <tr>
                    <td><code>Twal.err()</code></td>
                    <td>Error notification</td>
                </tr>
                <tr>
                    <td><code>Twal.info()</code></td>
                    <td>Informational notification</td>
                </tr>
                <tr>
                    <td><code>Twal.warn()</code></td>
                    <td>Warning notification</td>
                </tr>
            </tbody>
        </table>

        <h3>Form 1. simple string</h3>

        <p>
            Pass a message and TWal shows it with the right icon and
            color for the method you called:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>(<span class="str">"Task saved successfully"</span>);
Twal.<span class="fn">err</span>(<span class="str">"Something went wrong"</span>);
Twal.<span class="fn">info</span>(<span class="str">"You have a new message"</span>);
Twal.<span class="fn">warn</span>(<span class="str">"This action cannot be undone"</span>);</code></pre>
        </div>

        <h3>Form 2. config object</h3>

        <p>
            For more control, pass an object with <code>title</code>,
            <code>text</code>, and <code>icon</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>({
    title: <span class="str">"Task saved"</span>,
    text: <span class="str">"Your changes are now live."</span>,
    icon: <span class="str">"success"</span>
});

Twal.<span class="fn">err</span>({
    title: <span class="str">"Save failed"</span>,
    text: <span class="str">"Please check your connection and try again."</span>,
    icon: <span class="str">"error"</span>
});

Twal.<span class="fn">info</span>({
    title: <span class="str">"Heads up"</span>,
    text: <span class="str">"Your session expires in 5 minutes."</span>
});

Twal.<span class="fn">warn</span>({
    title: <span class="str">"Careful"</span>,
    text: <span class="str">"This action cannot be undone."</span>
});</code></pre>
        </div>

        <h3>When to use which</h3>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Use</th>
                    <th>When</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>String form</td>
                    <td>Quick, one-line messages with no title</td>
                </tr>
                <tr>
                    <td>Object form</td>
                    <td>
                        When you need a separate title and body, or want
                        to control the icon explicitly
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="callout">
            <p>
                <strong>Icon is automatic.</strong>
                <code>Twal.ok()</code> uses the success icon,
                <code>Twal.err()</code> uses the error icon, and so on.
                You only need to set <code>icon</code> in the config
                object if you want to override the default.
            </p>
        </div>

        <h2 id="config-options">Config object options</h2>

        <p>
            Every shorthand method accepts the same set of options:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Option</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>title</code></td>
                    <td>string</td>
                    <td>Bold heading</td>
                </tr>
                <tr>
                    <td><code>text</code></td>
                    <td>string</td>
                    <td>Body message</td>
                </tr>
                <tr>
                    <td><code>icon</code></td>
                    <td>string</td>
                    <td>
                        <code>"success"</code>, <code>"error"</code>,
                        <code>"warning"</code>, <code>"info"</code>
                    </td>
                </tr>
                <tr>
                    <td><code>confirmText</code></td>
                    <td>string</td>
                    <td>Label for the confirm button</td>
                </tr>
                <tr>
                    <td><code>cancelText</code></td>
                    <td>string</td>
                    <td>Label for the cancel button</td>
                </tr>
                <tr>
                    <td><code>onConfirm</code></td>
                    <td>function</td>
                    <td>Callback when confirm is clicked</td>
                </tr>
                <tr>
                    <td><code>onCancel</code></td>
                    <td>function</td>
                    <td>Callback when cancel is clicked</td>
                </tr>
            </tbody>
        </table>

        <h2 id="ok-with-reload">Success with reload</h2>

        <p>
            Passing <code>true</code> as the second argument to
            <code>Twal.ok()</code> tells TWal to <strong>reload the page</strong>
            after the alert closes. This is the pattern used everywhere
            in CTRX after an insert or update:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>(<span class="str">"New task added"</span>, <span class="kw">true</span>);</code></pre>
        </div>

        <p>
            Why this matters: after inserting a record, you want the
            table or list on the page to reflect the new data. Instead
            of manually re-fetching, you just reload. TWal handles the
            timing. the reload happens <em>after</em> the user dismisses
            the success message.
        </p>

        <h3>With a callback</h3>

        <p>
            You can also pass a function instead of <code>true</code> for
            custom post-dismiss behavior:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>(<span class="str">"Task deleted"</span>, () <span class="kw">=&gt;</span> $$.<span class="fn">reload</span>());</code></pre>
        </div>

        <h2 id="confirm">Confirmation prompts</h2>

        <p>
            Use <code>Twal.ask()</code> to ask the user for confirmation
            before a destructive action:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ask</span>(<span class="str">"Are you sure you want to delete this task?"</span>, deleteTask);

<span class="kw">function</span> <span class="fn">deleteTask</span>() {
    <span class="comment">// runs only if the user confirms</span>
    Tyrax.<span class="fn">delete</span>({
        url: <span class="str">"task/delete"</span>,
        params: { task: id },
        res: (send, code, message) <span class="kw">=&gt;</span> {
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) {
                Twal.<span class="fn">ok</span>(<span class="str">"Task deleted"</span>, () <span class="kw">=&gt;</span> $$.<span class="fn">reload</span>());
            } <span class="kw">else</span> {
                Twal.<span class="fn">err</span>(message);
            }
        }
    });
}</code></pre>
        </div>

        <p>
            <code>Twal.ask()</code> takes two arguments:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Arg</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>message</code></td>
                    <td>string</td>
                    <td>The question to display</td>
                </tr>
                <tr>
                    <td><code>onConfirm</code></td>
                    <td>function</td>
                    <td>Runs only if the user clicks Yes</td>
                </tr>
            </tbody>
        </table>

        <h3>With a config object</h3>

        <p>
            The config form gives you full control over the prompt:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ask</span>({
    title: <span class="str">"Delete this task?"</span>,
    text: <span class="str">"This action can't be undone."</span>,
    icon: <span class="str">"warning"</span>,
    confirmText: <span class="str">"Delete"</span>,
    cancelText: <span class="str">"Cancel"</span>,
    onConfirm: () <span class="kw">=&gt;</span> deleteTask()
});</code></pre>
        </div>

        <h2 id="real-example">Real example. delete with confirmation</h2>

        <p>
            This is the exact pattern from CTRX's task management page:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">import</span> $$ <span class="kw">from</span> <span class="str">"../../code/src/mods/ctrx/ctrx.js"</span>;
<span class="kw">import</span> Twal <span class="kw">from</span> <span class="str">"../../code/src/mods/twal.js"</span>;
<span class="kw">import</span> Tyrax <span class="kw">from</span> <span class="str">"../../code/src/tyrux/main.js"</span>;

$$.<span class="fn">click</span>(<span class="str">".deletetask"</span>, (btn) <span class="kw">=&gt;</span> {

    Twal.<span class="fn">ask</span>(<span class="str">"Are you sure to delete"</span>, deleteTask);

    <span class="kw">function</span> <span class="fn">deleteTask</span>() {
        <span class="kw">let</span> id = $$.<span class="fn">get_attribute</span>(btn, <span class="str">"task-id"</span>);
        Tyrax.<span class="fn">delete</span>({
            url: <span class="str">"task/delete"</span>,
            params: { task: id },
            res: (send, code, message) <span class="kw">=&gt;</span> {
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) {
                    Twal.<span class="fn">ok</span>(<span class="str">"Task deleted"</span>, () <span class="kw">=&gt;</span> $$.<span class="fn">reload</span>());
                } <span class="kw">else</span> {
                    Twal.<span class="fn">err</span>(message);
                }
            }
        });
    }
});</code></pre>
        </div>

        <p>
            Notice how the three libraries work together:
        </p>

        <ul>
            <li>
                <code>$$.click()</code> binds the click handler
                and gives you the clicked element
            </li>
            <li>
                <code>Twal.ask()</code> confirms before proceeding
            </li>
            <li>
                <code>Tyrax.delete()</code> makes the API call
            </li>
            <li>
                <code>Twal.ok()</code> / <code>Twal.err()</code> report the result
            </li>
        </ul>

        <h2 id="response-integration">Integration with TYRAX responses</h2>

        <p>
            TWal fits naturally into the <code>res</code> callback from
            TYRAX. Here's a standard three-code handler:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Tyrax.<span class="fn">post</span>({
    url: <span class="str">"task/add"</span>,
    req: raw,
    res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
        <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) {
            modal_x.<span class="fn">displayErrors</span>(errors);   <span class="comment">// validation</span>
            <span class="kw">return</span>;
        }
        <span class="kw">if</span> (code <span class="op">===</span> <span class="num">401</span>) {
            Twal.<span class="fn">err</span>(message);                  <span class="comment">// auth error</span>
            <span class="kw">return</span>;
        }
        <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) {
            Twal.<span class="fn">ok</span>(<span class="str">"New task added"</span>, <span class="kw">true</span>);  <span class="comment">// success + reload</span>
        }
    }
});</code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Pattern:</strong> every controller returns the
                same response shape (<code>code</code>,
                <code>message</code>, <code>data</code>,
                <code>errors</code>). TWal and FormValidator handle the
                user-facing side. The result is a consistent UX across
                every feature with almost no frontend code.
            </p>
        </div>

        <h2 id="real-world">Real-world patterns</h2>

        <p>
            TWal appears in every controller-driven flow in a CTRX app.
            These are the patterns you'll write most often:
        </p>

        <h3>Success after create</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>(<span class="str">"Note created"</span>, <span class="kw">true</span>);</code></pre>
        </div>

        <h3>Success after update, no reload</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>(<span class="str">"Changes saved"</span>);</code></pre>
        </div>

        <h3>Error from the server</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">err</span>(message);</code></pre>
        </div>

        <h3>Confirm before destructive action</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ask</span>(<span class="str">"Delete this item?"</span>, () <span class="kw">=&gt;</span> {
    <span class="comment">// proceed with delete</span>
});</code></pre>
        </div>

        <h3>Success with custom callback</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>(<span class="str">"Task deleted"</span>, () <span class="kw">=&gt;</span> $$.<span class="fn">reload</span>());</code></pre>
        </div>

        <h2 id="quick-reference">Quick reference</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Call</th>
                    <th>What it shows</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Twal.ok(msg)</code></td>
                    <td>Success notification</td>
                </tr>
                <tr>
                    <td><code>Twal.ok(msg, true)</code></td>
                    <td>Success + reload</td>
                </tr>
                <tr>
                    <td><code>Twal.ok(msg, fn)</code></td>
                    <td>Success + custom callback</td>
                </tr>
                <tr>
                    <td><code>Twal.ok({...})</code></td>
                    <td>Success with title, text, icon</td>
                </tr>
                <tr>
                    <td><code>Twal.err(msg)</code></td>
                    <td>Error notification</td>
                </tr>
                <tr>
                    <td><code>Twal.err({...})</code></td>
                    <td>Error with config object</td>
                </tr>
                <tr>
                    <td><code>Twal.info(msg)</code></td>
                    <td>Info notification</td>
                </tr>
                <tr>
                    <td><code>Twal.warn(msg)</code></td>
                    <td>Warning notification</td>
                </tr>
                <tr>
                    <td><code>Twal.ask(msg, fn)</code></td>
                    <td>Yes/No confirmation</td>
                </tr>
                <tr>
                    <td><code>Twal.ask({...})</code></td>
                    <td>Confirmation with full config</td>
                </tr>
            </tbody>
        </table>

        <nav class="docs-pager">
            <a href="tyrax" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← TYRAX</span>
            </a>
            <a href="tmodal" class="next">
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