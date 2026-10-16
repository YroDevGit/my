<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Validator. CTRX Documentation</title>
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
            <span>Validator</span>
        </nav>

        <h1>Validator</h1>
        <p class="lead">
            CTRX's Validator is a fluent, chainable input validation
            system inspired by Express Validator. It reads a field,
            validates it against a chain of rules, and collects errors
            for the frontend to display.
        </p>

        <h2 id="basic-usage">Basic usage</h2>

        <p>
            Every validation starts with a source method, chains rules,
            and ends with a terminal method:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Classes\Validator;

$email = Validator::<span class="fn">body</span>(<span class="str">"email"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"Email"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">maxChars</span>(<span class="num">60</span>)
    -&gt;<span class="fn">email</span>()
    -&gt;<span class="fn">run</span>();</code></pre>
        </div>

        <p>
            The chain returns the validated value (or <code>null</code>
            if the field is empty and not required). Any failures are
            collected internally.
        </p>

        <h2 id="sources">Sources</h2>

        <p>
            The first call picks where the field comes from:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Reads from</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Validator::body("field")</code></td>
                    <td>Request body (JSON or form-encoded)</td>
                </tr>
                <tr>
                    <td><code>Validator::post("field")</code></td>
                    <td>PHP's <code>$_POST</code></td>
                </tr>
                <tr>
                    <td><code>Validator::input("field")</code></td>
                    <td>Raw input stream</td>
                </tr>
            </tbody>
        </table>

        <p>
            All three behave identically from that point on. Use
            <code>body()</code> for JSON APIs (which is what TYRAX
            sends) and <code>post()</code> for classic form submissions.
        </p>

        <h2 id="label">Field labels</h2>

        <p>
            Labels replace the field name in error messages. Instead of
            <em>"email is required"</em>, the user sees
            <em>"Email is required"</em>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>$email = Validator::<span class="fn">body</span>(<span class="str">"email"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"Email"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">run</span>();</code></pre>
        </div>

        <p>
            Without <code>label()</code>, the error uses the field's raw
            key. It's a small touch, but it makes the frontend error
            display feel more polished.
        </p>

        <h2 id="rules">Validation rules</h2>

        <p>
            Here's the complete rule set. Chain any number of them
            before the terminal method.
        </p>

        <h3>Presence</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Rule</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>required()</code></td>
                    <td>Field must not be empty</td>
                </tr>
            </tbody>
        </table>

        <h3>Type</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Rule</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>string()</code></td>
                    <td>Value must be a string</td>
                </tr>
                <tr>
                    <td><code>number()</code></td>
                    <td>Value must be numeric</td>
                </tr>
                <tr>
                    <td><code>boolean()</code></td>
                    <td>Value must be <code>true</code>, <code>false</code>, <code>0</code>, or <code>1</code></td>
                </tr>
                <tr>
                    <td><code>date()</code></td>
                    <td>Value must be a valid date</td>
                </tr>
                <tr>
                    <td><code>url()</code></td>
                    <td>Value must be a valid URL</td>
                </tr>
                <tr>
                    <td><code>ip()</code></td>
                    <td>Value must be a valid IP address</td>
                </tr>
                <tr>
                    <td><code>email()</code></td>
                    <td>Value must be a valid email</td>
                </tr>
            </tbody>
        </table>

        <h3>Length</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Rule</th><th>Arg</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>minChars(n)</code></td>
                    <td>int</td>
                    <td>Minimum characters</td>
                </tr>
                <tr>
                    <td><code>maxChars(n)</code></td>
                    <td>int</td>
                    <td>Maximum characters</td>
                </tr>
                <tr>
                    <td><code>length(n)</code></td>
                    <td>int</td>
                    <td>Exact character count</td>
                </tr>
            </tbody>
        </table>

        <h3>Value range</h3>

        <p>
            <code>min()</code> and <code>max()</code> are smart. they
            apply to numeric values if the value is numeric, and to
            string length otherwise:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Number range</span>
Validator::<span class="fn">body</span>(<span class="str">"age"</span>)-&gt;<span class="fn">min</span>(<span class="num">18</span>)-&gt;<span class="fn">max</span>(<span class="num">99</span>)-&gt;<span class="fn">run</span>();

<span class="comment">// String length range</span>
Validator::<span class="fn">body</span>(<span class="str">"username"</span>)-&gt;<span class="fn">min</span>(<span class="num">3</span>)-&gt;<span class="fn">max</span>(<span class="num">20</span>)-&gt;<span class="fn">run</span>();</code></pre>
        </div>

        <h3>Format</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Rule</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>alpha()</code></td>
                    <td>Only letters (spaces allowed)</td>
                </tr>
                <tr>
                    <td><code>alphaStrict()</code></td>
                    <td>Only letters (no spaces)</td>
                </tr>
                <tr>
                    <td><code>alphanumeric()</code></td>
                    <td>Letters and numbers only</td>
                </tr>
                <tr>
                    <td><code>startsWith(str)</code></td>
                    <td>Must start with <code>str</code></td>
                </tr>
                <tr>
                    <td><code>endsWith(str)</code></td>
                    <td>Must end with <code>str</code></td>
                </tr>
                <tr>
                    <td><code>contain(val)</code></td>
                    <td>Must contain <code>val</code></td>
                </tr>
                <tr>
                    <td><code>exclude(val)</code></td>
                    <td>Must not contain <code>val</code></td>
                </tr>
                <tr>
                    <td><code>regex(pattern)</code></td>
                    <td>Must match the regex</td>
                </tr>
            </tbody>
        </table>

        <h3>Whitelist / blacklist</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Rule</th><th>Arg</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>in([...])</code></td>
                    <td>array</td>
                    <td>Must be one of the listed values</td>
                </tr>
                <tr>
                    <td><code>notIn([...])</code></td>
                    <td>array</td>
                    <td>Must not be any listed value</td>
                </tr>
                <tr>
                    <td><code>equal(val)</code></td>
                    <td>string</td>
                    <td>Must match exactly</td>
                </tr>
            </tbody>
        </table>

        <h3>Database rules</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Rule</th><th>Arg</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>in_table("table:col")</code></td>
                    <td>string</td>
                    <td>Value must exist in the table</td>
                </tr>
                <tr>
                    <td><code>unique("table:col")</code></td>
                    <td>string</td>
                    <td>Value must not exist in the table</td>
                </tr>
            </tbody>
        </table>

        <p>Example. email must be unique in the users table:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Validator::<span class="fn">body</span>(<span class="str">"email"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">email</span>()
    -&gt;<span class="fn">unique</span>(<span class="str">"users:email"</span>)
    -&gt;<span class="fn">run</span>();</code></pre>
        </div>

        <h3>Transformations</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Rule</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>trim()</code></td>
                    <td>Trim whitespace before validating</td>
                </tr>
                <tr>
                    <td><code>decrypt()</code></td>
                    <td>Decrypt the value first (used with <code>params</code>)</td>
                </tr>
            </tbody>
        </table>

        <h3>Collection</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Rule</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>column("name")</code></td>
                    <td>Store the value under a custom key in <code>Validator::data()</code></td>
                </tr>
                <tr>
                    <td><code>collect("name")</code></td>
                    <td>Alias for <code>column()</code></td>
                </tr>
            </tbody>
        </table>

        <h2 id="custom-messages">Custom error messages</h2>

        <p>
            Every rule accepts an optional message as its last argument.
            If you don't pass one, CTRX generates a default message using
            the field's label:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Default message</span>
Validator::<span class="fn">body</span>(<span class="str">"email"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">run</span>();
<span class="comment">// → "email is required."</span>

<span class="comment">// With label. nicer message</span>
Validator::<span class="fn">body</span>(<span class="str">"email"</span>)-&gt;<span class="fn">label</span>(<span class="str">"Email"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">run</span>();
<span class="comment">// → "Email is required."</span>

<span class="comment">// With custom message. full control</span>
Validator::<span class="fn">body</span>(<span class="str">"email"</span>)
    -&gt;<span class="fn">required</span>(<span class="str">"Please enter your email address"</span>)
    -&gt;<span class="fn">run</span>();
<span class="comment">// → "Please enter your email address"</span></code></pre>
        </div>

        <h2 id="terminal-methods">Terminal methods</h2>

        <p>
            Every validation chain ends with one of these. They're
            <strong>all aliases</strong>. pick whichever reads best in
            context:
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>Method</th><th>Reads as</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>-&gt;run()</code></td>
                    <td>"Run the validation"</td>
                </tr>
                <tr>
                    <td><code>-&gt;exec()</code></td>
                    <td>"Execute the validation"</td>
                </tr>
                <tr>
                    <td><code>-&gt;validate()</code></td>
                    <td>"Validate"</td>
                </tr>
                <tr>
                    <td><code>-&gt;X()</code></td>
                    <td>Shortest form</td>
                </tr>
                <tr>
                    <td><code>-&gt;go()</code></td>
                    <td>"Go"</td>
                </tr>
            </tbody>
        </table>

        <div class="callout">
            <p>
                <strong>Which to use?</strong>
                <code>run()</code> is the most common in CTRX apps.
                <code>exec()</code> appears in the task controllers.
                Both work identically.
            </p>
        </div>

        <h2 id="checking-errors">Checking for errors</h2>

        <p>
            After validating all your fields, check for failures:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}</code></pre>
        </div>

        <p>
            The <code>errors</code> array maps each failed field to its
            message:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>[
    <span class="str">"email"</span>    =&gt; <span class="str">"Email is required."</span>,
    <span class="str">"password"</span> =&gt; <span class="str">"Password must be at least 8 characters."</span>
]</code></pre>
        </div>

        <h3>Other error-checking methods</h3>

        <table class="docs-table">
            <thead>
                <tr><th>Method</th><th>Purpose</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Validator::errors()</code></td>
                    <td>All errors (or a subset by field name)</td>
                </tr>
                <tr>
                    <td><code>Validator::failed()</code></td>
                    <td>Did validation fail? (bool)</td>
                </tr>
                <tr>
                    <td><code>Validator::post_error()</code></td>
                    <td>Get the first error message</td>
                </tr>
                <tr>
                    <td><code>Validator::field_error("email")</code></td>
                    <td>Get the error for one field</td>
                </tr>
                <tr>
                    <td><code>Validator::reset()</code></td>
                    <td>Clear all errors and collected data</td>
                </tr>
            </tbody>
        </table>

        <h2 id="full-example">Full example. login controller</h2>

        <p>
            This is the exact pattern from CTRX's <code>user/login.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">//route: user/login</span>

<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Users;

<span class="comment">// ── Validate input</span>
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

<span class="comment">// ── Return errors if any</span>
<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">400</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

<span class="comment">// ── Continue with business logic</span>
$findUser = Users::<span class="fn">findOne</span>([<span class="str">"email"</span> =&gt; $email]);
<span class="comment">// ...</span></code></pre>
        </div>

        <h2 id="batch-rules">Batch validation</h2>

        <p>
            For simple cases, <code>Validator::rules()</code> lets you
            define everything in one array:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>$data = Validator::<span class="fn">rules</span>([
    <span class="str">"email"</span>    =&gt; <span class="str">"required|email"</span>,
    <span class="str">"password"</span> =&gt; <span class="str">"required|min_chars:8"</span>,
    <span class="str">"age"</span>      =&gt; [<span class="str">"Age"</span>, <span class="str">"required|number|min:18"</span>],   <span class="comment">// with label</span>
]);

<span class="kw">if</span> (Validator::<span class="fn">failed</span>()) {
    Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>(Validator::<span class="fn">errors</span>())-&gt;<span class="fn">send</span>();
}</code></pre>
        </div>

        <p>
            Rules are separated by <code>|</code>. Parameters use
            <code>:</code>. A <code>[label, rules]</code> array sets both
            at once.
        </p>

        <h2 id="collect-data">Collecting values</h2>

        <p>
            After validation, <code>Validator::data()</code> returns every
            validated field:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Validator::<span class="fn">body</span>(<span class="str">"email"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">email</span>()-&gt;<span class="fn">run</span>();
Validator::<span class="fn">body</span>(<span class="str">"password"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">run</span>();

$data = Validator::<span class="fn">data</span>();
<span class="comment">// [</span>
<span class="comment">//     "email"    =&gt; "user@example.com",</span>
<span class="comment">//     "password" =&gt; "secret123"</span>
<span class="comment">// ]</span></code></pre>
        </div>

        <p>
            To store a value under a custom key, use <code>column()</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Validator::<span class="fn">body</span>(<span class="str">"userEmail"</span>)-&gt;<span class="fn">column</span>(<span class="str">"email"</span>)-&gt;<span class="fn">email</span>()-&gt;<span class="fn">run</span>();
<span class="comment">// Validator::data() now returns ["email" =&gt; "..."]</span></code></pre>
        </div>

        <h2 id="quick-reference">Quick reference</h2>

        <h3>Sources</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Validator::<span class="fn">body</span>(<span class="str">"field"</span>)
Validator::<span class="fn">post</span>(<span class="str">"field"</span>)
Validator::<span class="fn">input</span>(<span class="str">"field"</span>)</code></pre>
        </div>

        <h3>Most-used rules</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="fn">required</span>()
<span class="fn">label</span>(<span class="str">"Field Name"</span>)
<span class="fn">email</span>()
<span class="fn">number</span>()
<span class="fn">string</span>()
<span class="fn">minChars</span>(<span class="num">8</span>)
<span class="fn">maxChars</span>(<span class="num">255</span>)
<span class="fn">length</span>(<span class="num">10</span>)
<span class="fn">min</span>(<span class="num">18</span>)
<span class="fn">max</span>(<span class="num">99</span>)
<span class="fn">in</span>([<span class="num">1</span>, <span class="num">2</span>, <span class="num">3</span>])
<span class="fn">unique</span>(<span class="str">"users:email"</span>)
<span class="fn">in_table</span>(<span class="str">"projects:id"</span>)
<span class="fn">regex</span>(<span class="str">"/^[0-9]+$/"</span>)
<span class="fn">trim</span>()
<span class="fn">decrypt</span>()</code></pre>
        </div>

        <h3>Terminal methods</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>-&gt;<span class="fn">run</span>()    <span class="comment">// most common</span>
-&gt;<span class="fn">exec</span>()   <span class="comment">// same thing</span>
-&gt;<span class="fn">validate</span>()
-&gt;<span class="fn">X</span>()</code></pre>
        </div>

        <h3>Error checking</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) { ... }
<span class="kw">if</span> (Validator::<span class="fn">failed</span>()) { ... }
Validator::<span class="fn">post_error</span>()
Validator::<span class="fn">field_error</span>(<span class="str">"email"</span>)
Validator::<span class="fn">reset</span>()</code></pre>
        </div>

        <nav class="docs-pager">
            <a href="response.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← Response</span>
            </a>
            <a href="middleware.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Middleware →</span>
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