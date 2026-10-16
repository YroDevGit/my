<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Insert from a Form. CTRX Documentation</title>
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
            <a href="../getting-started/index.html">Get Started</a>
            <a href="../concepts/team-workflow.html">Concepts</a>
            <a href="insert-from-form.html" class="active">Tutorials</a>
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
            <a href="#">Tutorials</a>
            <span>/</span>
            <span>Insert from a Form</span>
        </nav>

        <h1>Insert from a Form</h1>
        <p class="lead">
            This tutorial follows a single value. a book title. from
            the moment a user types it into an input field to the moment
            it lands in a database row. Every step, every conversion,
            nothing skipped.
        </p>

        <div class="callout">
            <p>
                <strong>Who this is for:</strong> if you've ever wondered
                "what actually happens when I click Submit?". this is
                the answer. If you just want the pattern, see
                <a href="insert-to-table.html">Insert to a Table</a>.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="the-path">The path of a value</h2>

        <p>
            Here's the full journey. Seven stops. Each one changes the
            shape of the data.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>1. User types "The Pragmatic Programmer"
        ↓
2. HTML input           &lt;input name="title"&gt;
        ↓
3. JavaScript           FormData → { title: "The Pragmatic..." }
        ↓
4. TYRAX                POST /api/book/add  (JSON body)
        ↓
5. Route                Router matches book/add
        ↓
6. Controller           Validator::post("title")-&gt;exec()
        ↓
7. Model                Book::insert([...])
        ↓
8. Database             INSERT INTO books ...</code></pre>
        </div>

        <p>
            Each stop has one job. If something breaks, you can isolate
            exactly where.
        </p>

        <!-- ============================================================ -->
        <h2 id="step-1-page">1. The page</h2>

        <p>
            <code>views/pages/library.php</code>. the shell. It renders
            the form inputs, but doesn't do anything with them yet.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>&lt;?php <span class="comment">// page: /library</span> ?&gt;
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;My Library&lt;/title&gt;
    &lt;link rel=<span class="str">"stylesheet"</span> href=<span class="str">"&lt;?=assets('ctrx.css')?&gt;"</span>&gt;
&lt;/head&gt;
&lt;body&gt;

    &lt;form id=<span class="str">"bookForm"</span>&gt;
        &lt;input name=<span class="str">"title"</span> placeholder=<span class="str">"Title"</span>&gt;
        &lt;input name=<span class="str">"author"</span> placeholder=<span class="str">"Author"</span>&gt;
        &lt;input name=<span class="str">"isbn"</span> placeholder=<span class="str">"ISBN"</span>&gt;
        &lt;button type="submit"&gt;+ Add Book&lt;/button&gt;
    &lt;/form&gt;

&lt;/body&gt;
&lt;/html&gt;</code></pre>
        </div>

        <p>
            Notice the <code>name</code> attribute on each input. That's
            the key. it becomes the field name at every later step:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>HTML</th>
                    <th>JS object</th>
                    <th>PHP read</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>name="title"</code></td>
                    <td><code>raw.title</code></td>
                    <td><code>Validator::post("title")</code></td>
                </tr>
                <tr>
                    <td><code>name="author"</code></td>
                    <td><code>raw.author</code></td>
                    <td><code>Validator::post("author")</code></td>
                </tr>
                <tr>
                    <td><code>name="isbn"</code></td>
                    <td><code>raw.isbn</code></td>
                    <td><code>Validator::post("isbn")</code></td>
                </tr>
            </tbody>
        </table>

        <div class="callout">
            <p>
                <strong>The name attribute is the contract.</strong>
                Rename it, and you break every layer above. Keep it
                consistent with the payload your controller expects.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="step-2-js">2. The paired JS</h2>

        <p>
            <code>views/js/library.js</code>. auto-paired to the page.
            It reads the form, serializes it, and sends it.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">import</span> Ctr <span class="kw">from</span> <span class="str">"../code/src/mods/ctr.js"</span>;
<span class="kw">import</span> Twal <span class="kw">from</span> <span class="str">"../code/src/mods/twal.js"</span>;
<span class="kw">import</span> Tyrax <span class="kw">from</span> <span class="str">"../code/src/tyrux/main.js"</span>;

Ctr.<span class="fn">submit</span>(<span class="str">"#bookForm"</span>, (data, raw) <span class="kw">=&gt;</span> {
    <span class="comment">// data → native FormData</span>
    <span class="comment">// raw  → plain object { title, author, isbn }</span>

    Tyrax.<span class="fn">post</span>({
        url: <span class="str">"book/add"</span>,
        req: raw,
        res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) Twal.<span class="fn">ok</span>(<span class="str">"Book added"</span>, <span class="kw">true</span>);
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) console.<span class="fn">log</span>(errors);
        }
    });
});</code></pre>
        </div>

        <h3>What <code>Ctr.submit()</code> does behind the scenes</h3>

        <p>
            When the form is submitted, <code>Ctr.submit()</code> runs
            three things automatically:
        </p>

        <ol>
            <li>
                <strong>Prevents the default submit</strong>. the page
                doesn't navigate or reload
            </li>
            <li>
                <strong>Serializes the form</strong>. reads every
                <code>name</code>d input and turns it into a plain object
            </li>
            <li>
                <strong>Calls your callback</strong> with two versions of
                the data. <code>FormData</code> (native) and the plain
                object
            </li>
        </ol>

        <p>
            You almost always want <code>raw</code>, because it's already
            JSON-serializable. <code>data</code> is only needed when you
            upload files.
        </p>

        <h3>What <code>raw</code> looks like</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"title"</span>:  <span class="str">"The Pragmatic Programmer"</span>,
    <span class="str">"author"</span>: <span class="str">"Andrew Hunt"</span>,
    <span class="str">"isbn"</span>:   <span class="str">"978-0201616224"</span>
}</code></pre>
        </div>

        <!-- ============================================================ -->
        <h2 id="step-3-tyrax">3. TYRAX sends the request</h2>

        <p>
            <code>Tyrax.post({ url: "book/add", req: raw })</code> does
            four things:
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>#</th><th>Action</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Resolves <code>"book/add"</code> to the matching route</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Serializes <code>raw</code> to JSON</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>POSTs to <code>/api/book/add</code> with the JSON body</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Calls your <code>res</code> callback when the response arrives</td>
                </tr>
            </tbody>
        </table>

        <p>
            The HTTP request body looks like this on the wire:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>POST /api/book/add HTTP/1.1
Content-Type: application/json

{
    "title":  "The Pragmatic Programmer",
    "author": "Andrew Hunt",
    "isbn":   "978-0201616224"
}</code></pre>
        </div>

        <!-- ============================================================ -->
        <h2 id="step-4-route">4. The route matches</h2>

        <p>
            <code>app/_routes/api.php</code> declares that
            <code>book/add</code> is handled by
            <code>app/_controller/book/add.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>, controller: <span class="str">"book/add"</span>),
)-&gt;<span class="fn">middleware</span>(<span class="str">"auth"</span>);</code></pre>
        </div>

        <p>
            The middleware (<code>app/middleware/auth.php</code>) runs
            first, checking the session. If the user isn't logged in,
            the request stops here with a 401. If they are, the
            controller runs.
        </p>

        <!-- ============================================================ -->
        <h2 id="step-5-controller">5. The controller reads the body</h2>

        <p>
            <code>app/_controller/book/add.php</code>. this is where the
            data is validated and written:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/add</span>

<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Book;

<span class="comment">// Read each field from the JSON body</span>
$title  = Validator::<span class="fn">post</span>(<span class="str">"title"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"Title"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">maxChars</span>(<span class="num">255</span>)
    -&gt;<span class="fn">exec</span>();

$author = Validator::<span class="fn">post</span>(<span class="str">"author"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"Author"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">maxChars</span>(<span class="num">255</span>)
    -&gt;<span class="fn">exec</span>();

$isbn   = Validator::<span class="fn">post</span>(<span class="str">"isbn"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"ISBN"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">unique</span>(<span class="str">"books:isbn"</span>)
    -&gt;<span class="fn">exec</span>();

<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

Book::<span class="fn">insert</span>([
    <span class="str">"title"</span>  =&gt; $title,
    <span class="str">"author"</span> =&gt; $author,
    <span class="str">"isbn"</span>   =&gt; $isbn,
]);

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"Book added"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <h3>How <code>Validator::post()</code> finds the value</h3>

        <p>
            When the request arrives with a JSON body, CTRX parses it and
            makes every field available by name. The
            <code>Validator::post("title")</code> call:
        </p>

        <ol>
            <li>Reads <code>title</code> from the parsed request body</li>
            <li>Runs it through each rule in the chain (<code>required</code>, <code>maxChars(255)</code>)</li>
            <li>Returns the value if all rules pass, or records an error</li>
        </ol>

        <p>
            After all fields are checked,
            <code>Validator::errors()</code> returns any that failed.
            If there are none, the controller proceeds.
        </p>

        <h3>What the controller sees</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Inside the controller after validation:</span>
$title  = <span class="str">"The Pragmatic Programmer"</span>;
$author = <span class="str">"Andrew Hunt"</span>;
$isbn   = <span class="str">"978-0201616224"</span>;

<span class="comment">// These are the actual PHP strings. validated, safe to use</span></code></pre>
        </div>

        <!-- ============================================================ -->
        <h2 id="step-6-model">6. The model inserts the row</h2>

        <p>
            <code>Book::insert([...])</code> takes an associative array
            and writes one row to the <code>books</code> table:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Book::<span class="fn">insert</span>([
    <span class="str">"title"</span>  =&gt; <span class="str">"The Pragmatic Programmer"</span>,
    <span class="str">"author"</span> =&gt; <span class="str">"Andrew Hunt"</span>,
    <span class="str">"isbn"</span>   =&gt; <span class="str">"978-0201616224"</span>,
]);</code></pre>
        </div>

        <p>
            Under the hood, this becomes:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>INSERT INTO books (title, author, isbn)
VALUES ('The Pragmatic Programmer', 'Andrew Hunt', '978-0201616224');</code></pre>
        </div>

        <p>
            CTRX handles the PDO binding. the values are escaped
            automatically. You never concatenate SQL strings by hand.
        </p>

        <!-- ============================================================ -->
        <h2 id="step-7-response">7. The response travels back</h2>

        <p>
            The controller sends a JSON response:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"code"</span>:    <span class="num">200</span>,
    <span class="str">"message"</span>: <span class="str">"Book added"</span>,
    <span class="str">"data"</span>:    <span class="kw">null</span>,
    <span class="str">"errors"</span>:  <span class="kw">null</span>
}</code></pre>
        </div>

        <p>
            TYRAX receives this and calls the <code>res</code> callback
            with the four fields pre-extracted:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
    <span class="comment">// code = 200, message = "Book added"</span>
    <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) Twal.<span class="fn">ok</span>(message, <span class="kw">true</span>);
}</code></pre>
        </div>

        <!-- ============================================================ -->
        <h2 id="validation-fail">When validation fails</h2>

        <p>
            If a field fails validation, the controller stops before
            touching the database and returns a 422 with the errors:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"code"</span>:    <span class="num">422</span>,
    <span class="str">"message"</span>: <span class="str">"Validation failed"</span>,
    <span class="str">"data"</span>:    <span class="kw">null</span>,
    <span class="str">"errors"</span>: {
        <span class="str">"title"</span>:  <span class="str">"Title is required."</span>,
        <span class="str">"isbn"</span>:   <span class="str">"ISBN already exists."</span>
    }
}</code></pre>
        </div>

        <p>
            The error keys. <code>title</code>, <code>isbn</code>.
            match the input <code>name</code> attributes from step 1.
            That's how the frontend knows which input to highlight:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) {
    <span class="comment">// Paints each error under the matching input</span>
    FormValidator.<span class="fn">displayErrors</span>(errors, <span class="str">"#bookForm"</span>);
}</code></pre>
        </div>

        <p>
            The circle is closed: the value's name survived from the
            HTML input through the entire stack and back.
        </p>

        <!-- ============================================================ -->
        <h2 id="debugging">Debugging the flow</h2>

        <p>
            If an insert isn't working, isolate the layer. Each step can
            be tested independently.
        </p>

        <h3>Is the form sending the right values?</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Ctr.<span class="fn">submit</span>(<span class="str">"#bookForm"</span>, (data, raw) <span class="kw">=&gt;</span> {
    console.<span class="fn">log</span>(<span class="str">"Form values:"</span>, raw);
    <span class="comment">// If this is empty, check your input "name" attributes</span>
});</code></pre>
        </div>

        <h3>Is the request reaching the backend?</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Tyrax.<span class="fn">post</span>({
    url: <span class="str">"book/add"</span>,
    req: raw,
    res: (send, code, message) <span class="kw">=&gt;</span> {
        console.<span class="fn">log</span>(<span class="str">"Response:"</span>, code, message);
        <span class="comment">// If code is 401, the middleware blocked it</span>
        <span class="comment">// If code is 404, the route didn't match</span>
        <span class="comment">// If code is 500, the controller crashed</span>
    }
});</code></pre>
        </div>

        <h3>Is the controller seeing the values?</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Temporarily at the top of the controller:</span>
Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">data</span>([
    <span class="str">"received_title"</span>  =&gt; Validator::<span class="fn">post</span>(<span class="str">"title"</span>)-&gt;<span class="fn">exec</span>(),
    <span class="str">"received_author"</span> =&gt; Validator::<span class="fn">post</span>(<span class="str">"author"</span>)-&gt;<span class="fn">exec</span>(),
])-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <p>
            The frontend will show exactly what the controller received.
            If it's empty, the payload isn't arriving. If it's there but
            the insert fails, the problem is the model or the database.
        </p>

        <!-- ============================================================ -->
        <h2 id="field-names">Field names. the golden rule</h2>

        <p>
            The <code>name</code> attribute is the one string that ties
            every layer together. If they don't match, nothing works:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Layer</th>
                    <th>Where the name appears</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>HTML</td>
                    <td><code>&lt;input name="title"&gt;</code></td>
                </tr>
                <tr>
                    <td>JS raw object</td>
                    <td><code>raw.title</code></td>
                </tr>
                <tr>
                    <td>HTTP body</td>
                    <td><code>{ "title": "..." }</code></td>
                </tr>
                <tr>
                    <td>Controller read</td>
                    <td><code>Validator::post("title")</code></td>
                </tr>
                <tr>
                    <td>Model insert</td>
                    <td><code>["title" =&gt; $title]</code></td>
                </tr>
                <tr>
                    <td>DB column</td>
                    <td><code>title VARCHAR</code></td>
                </tr>
                <tr>
                    <td>Error key</td>
                    <td><code>{ "title": "..." }</code></td>
                </tr>
                <tr>
                    <td>Frontend display</td>
                    <td><code>errors.title</code></td>
                </tr>
            </tbody>
        </table>

        <div class="callout warn">
            <p>
                <strong>Use the same name everywhere.</strong>
                Some teams prefer <code>firstName</code>, some
                <code>first_name</code>. It doesn't matter which. pick
                one and use it in the HTML <code>name</code>, the
                database column, and every reference in between.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="recap">Recap</h2>

        <p>
            A single value travels through seven layers:
        </p>

        <ol>
            <li>The user types it into an HTML input with a <code>name</code></li>
            <li><code>Ctr.submit()</code> serializes the form into an object</li>
            <li>TYRAX POSTs the object as JSON to <code>book/add</code></li>
            <li>The route matches and the middleware passes</li>
            <li><code>Validator::post()</code> reads and validates each field</li>
            <li><code>Book::insert()</code> writes the row</li>
            <li><code>Response::code(200)</code> travels back, TYRAX fires <code>res</code></li>
        </ol>

        <p>
            At every step, the value is passed by name. never by
            position, never by magic. That's why a single mismatch
            anywhere breaks everything, and why matching names
            everywhere makes everything work.
        </p>

        <nav class="docs-pager">
            <a href="insert-to-table.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← Insert to a Table</span>
            </a>
            <a href="full-crud.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Full CRUD →</span>
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