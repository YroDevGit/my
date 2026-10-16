<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Full CRUD. CTRX Documentation</title>
<link rel="stylesheet" href="<?=pagedir('docs/style.css')?>" />
</head>
<body>

<header class="docs-header">
    <div class="docs-header-inner">
        <a href="../index.html" class="docs-logo">Code<span>tazer</span>-X</a>
        <nav class="docs-top-nav">
            <a href="../getting-started/index.html">Get Started</a>
            <a href="full-crud.html" class="active">Tutorials</a>
            <a href="../reference/helpers.html">Reference</a>
        </nav>
        <div class="docs-header-actions">
            <a href="https://github.com/YroDevGit/ctrx" target="_blank">GitHub</a>
            <a href="https://packagist.org/packages/yrodevgit/ctrx" target="_blank">Packagist</a>
        </div>
    </div>
</header>

<div class="docs-layout">

    <?=pagedir_include("_inc/aside")?>

    <main class="docs-content">

        <nav class="breadcrumbs">
            <a href="../index.html">Docs</a>
            <span>/</span>
            <a href="#">Tutorials</a>
            <span>/</span>
            <span>Full CRUD</span>
        </nav>

        <h1>Full CRUD</h1>
        <p class="lead">
            This tutorial builds a complete CRUD interface for a
            <strong>books</strong> table: list, create, read, update,
            and delete. It's the natural extension of the
            <a href="insert-to-table.html">Insert to a Table</a> tutorial
           . same patterns, applied across all five operations.
        </p>

        <div class="callout">
            <p>
                <strong>What you'll build:</strong> a library page with
                a table of books, an "+ Add Book" button, an "Edit" link
                on each row, and a "Delete" link that confirms before
                removing.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="overview">The five endpoints</h2>

        <p>
            CRUD means five operations, each with its own controller
            file and route. Here's the full contract before we write any
            code:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Operation</th>
                    <th>Route</th>
                    <th>Method</th>
                    <th>Payload / Params</th>
                    <th>Returns</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>List</td>
                    <td><code>book/get</code></td>
                    <td>GET</td>
                    <td>—</td>
                    <td><code>{ code: 200, data: [...] }</code></td>
                </tr>
                <tr>
                    <td>Read one</td>
                    <td><code>book/getById</code></td>
                    <td>GET</td>
                    <td><code>{ id }</code></td>
                    <td><code>{ code: 200, data: {...} }</code></td>
                </tr>
                <tr>
                    <td>Create</td>
                    <td><code>book/add</code></td>
                    <td>POST</td>
                    <td><code>{ title, author, isbn, rating, notes }</code></td>
                    <td><code>{ code: 200 }</code></td>
                </tr>
                <tr>
                    <td>Update</td>
                    <td><code>book/update</code></td>
                    <td>PUT</td>
                    <td><code>{ id }</code> + same payload as create</td>
                    <td><code>{ code: 200 }</code></td>
                </tr>
                <tr>
                    <td>Delete</td>
                    <td><code>book/delete</code></td>
                    <td>DELETE</td>
                    <td><code>{ id }</code></td>
                    <td><code>{ code: 200 }</code></td>
                </tr>
            </tbody>
        </table>

        <p>
            Five routes. Five controllers. Two frontend pieces. a page
            and a paired JS file. That's the whole feature.
        </p>

        <div class="callout">
            <p>
                <strong>Why <code>getById</code> instead of <code>/book/5</code>?</strong>
                CTRX uses action-named endpoints because every URL maps to
                a file. <code>/book/getById</code> reads as "the getById
                action on the book resource," which matches
                <code>app/_controller/book/getById.php</code>. If you
                prefer REST-style path parameters, see
                <a href="#restful">RESTful alternatives</a> below.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="restful">RESTful alternatives</h2>

        <p>
            If you prefer REST-pure URLs like <code>GET /api/book/5</code>,
            CTRX supports it. you just trade some of the
            one-file-per-endpoint simplicity. There are three options.
        </p>

        <h3>Option 1. Keep <code>getById</code> (default)</h3>

        <p>
            What this tutorial uses. Each action gets its own file and URL.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>GET    /api/book/get
GET    /api/book/getById?id=5
POST   /api/book/add
PUT    /api/book/update?id=5
DELETE /api/book/delete?id=5</code></pre>
        </div>

        <table class="docs-table">
            <thead>
                <tr><th>Pros</th><th>Cons</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Matches CTRX's file-based routing<br>
                        One file per action<br>
                        Easy to reason about
                    </td>
                    <td>
                        Not REST-pure<br>
                        Verb in URL (<code>getById</code>)<br>
                        Nested lookups multiply files
                    </td>
                </tr>
            </tbody>
        </table>

        <h3>Option 2. Fallback controller with path segments</h3>

        <p>
            Create a single controller that reads the URL segment and
            dispatches based on the value:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/show</span>

<span class="kw">use</span> Classes\Request;
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Tables\Book;

<span class="comment">// Read the id segment from the URL</span>
$id = Request::<span class="fn">segment</span>(<span class="num">2</span>);

<span class="kw">if</span> (! $id) {
    Response::<span class="fn">code</span>(<span class="num">404</span>)-&gt;<span class="fn">message</span>(<span class="str">"Not found"</span>)-&gt;<span class="fn">send</span>();
}

$book = Book::<span class="fn">findOne</span>([<span class="str">"id"</span> =&gt; $id]);

<span class="kw">if</span> (! $book) {
    Response::<span class="fn">code</span>(<span class="num">404</span>)-&gt;<span class="fn">message</span>(<span class="str">"Book not found"</span>)-&gt;<span class="fn">send</span>();
}

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">data</span>($book)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <p>
            Then add a rewrite rule so <code>/api/book/5</code> reaches
            that controller:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>RewriteRule ^api/book/([0-9]+)$ api/book/show?$1 [L,QSA]</code></pre>
        </div>

        <table class="docs-table">
            <thead>
                <tr><th>Pros</th><th>Cons</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        REST-pure URLs<br>
                        One controller handles many IDs<br>
                        Familiar to REST-first teams
                    </td>
                    <td>
                        Requires Apache/Nginx rewrite rules<br>
                        Breaks one-file-one-URL purity<br>
                        Path parsing is manual
                    </td>
                </tr>
            </tbody>
        </table>

        <h3>Option 3. Query string on a single endpoint</h3>

        <p>
            Keep one file, but let it behave differently based on whether
            an ID is present:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/get</span>

<span class="kw">use</span> Classes\Request;
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Tables\Book;

$id = Request::<span class="fn">get_decrypt</span>(<span class="str">"id"</span>);

<span class="kw">if</span> ($id) {
    $book = Book::<span class="fn">findOne</span>([<span class="str">"id"</span> =&gt; $id]);
    <span class="kw">if</span> (! $book) {
        Response::<span class="fn">code</span>(<span class="num">404</span>)-&gt;<span class="fn">message</span>(<span class="str">"Not found"</span>)-&gt;<span class="fn">send</span>();
    }
    Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">data</span>($book)-&gt;<span class="fn">send</span>();
}

$books = Book::<span class="fn">all</span>();
Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">data</span>($books)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>GET /api/book/get          <span class="comment">→ list all</span>
GET /api/book/get?id=5     <span class="comment">→ one book</span></code></pre>
        </div>

        <table class="docs-table">
            <thead>
                <tr><th>Pros</th><th>Cons</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        One file for both list and read<br>
                        No rewrite rules<br>
                        Simple mental model
                    </td>
                    <td>
                        Two behaviors in one file<br>
                        Harder to test independently<br>
                        Mixes concerns
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="callout">
            <p>
                <strong>Which should you pick?</strong> For consistency
                with the rest of CTRX. and for the cleanest separation
               . stick with <strong>Option 1</strong>. It matches what
                every other CTRX example does. If you have a strong
                REST-first team, <strong>Option 2</strong> gives you
                REST paths at the cost of some file-based simplicity.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="part-0">Part 0. The contract</h2>

        <p>
            Before either team writes code, agree on the interface.
            This is what the frontend will call and what the backend
            promises to return:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>GET     /api/book/get          →  list of books
GET     /api/book/getById      →  { id } → one book
POST    /api/book/add          →  create
PUT     /api/book/update       →  { id } → update
DELETE  /api/book/delete       →  { id } → delete

All responses follow the same shape:
{
    "code":    200 | 401 | 404 | 422,
    "message": "OK" | error message,
    "data":    null | object | array,
    "errors":  null | { field: "message" }
}</code></pre>
        </div>

        <p>
            Both teams build against this contract independently.
            Nothing else needs coordination.
        </p>

        <!-- ============================================================ -->
        <h2 id="backend-track">Part 1. Backend track</h2>

        <p class="lead">
            Owned by the backend developer. Everything lives inside
            <code>app/</code>.
        </p>

        <h3 id="backend-1">1.1. The table</h3>

        <p>
            Add the <code>books</code> table to
            <code>app/config/migration.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span>
<span class="kw">use</span> Classes\Migration;

Migration::<span class="fn">table_ts</span>(<span class="str">"books"</span>, [
    <span class="str">"id"</span>     =&gt; PK,
    <span class="str">"title"</span>  =&gt; VARCHAR,
    <span class="str">"author"</span> =&gt; VARCHAR,
    <span class="str">"isbn"</span>   =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">20</span>],
    <span class="str">"rating"</span> =&gt; INTEGER,
    <span class="str">"notes"</span>  =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">1000</span>],
], <span class="kw">true</span>);</code></pre>
        </div>

        <p>Then migrate:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> db:migrate</code></pre>
        </div>

        <h3 id="backend-2">1.2. The routes</h3>

        <p>
            All five routes go inside the authenticated group in
            <code>app/_routes/api.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"get"</span>,    controller: <span class="str">"book/get"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"get"</span>,    controller: <span class="str">"book/getById"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>,   controller: <span class="str">"book/add"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"put"</span>,    controller: <span class="str">"book/update"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"delete"</span>, controller: <span class="str">"book/delete"</span>),
)-&gt;<span class="fn">middleware</span>(<span class="str">"g1"</span>);</code></pre>
        </div>

        <h3 id="backend-3">1.3. The list controller</h3>

        <p>
            <code>app/_controller/book/get.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/get</span>

<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Tables\Book;

$books = Book::<span class="fn">all</span>();

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">data</span>($books)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <h3 id="backend-4">1.4. The read controller</h3>

        <p>
            <code>app/_controller/book/getById.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/getById</span>

<span class="kw">use</span> Classes\Request;
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Tables\Book;

$id = Request::<span class="fn">get_decrypt</span>(<span class="str">"id"</span>);

<span class="kw">if</span> (! $id) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid request"</span>)-&gt;<span class="fn">send</span>();
}

$book = Book::<span class="fn">findOne</span>([<span class="str">"id"</span> =&gt; $id]);

<span class="kw">if</span> (! $book) {
    Response::<span class="fn">code</span>(<span class="num">404</span>)-&gt;<span class="fn">message</span>(<span class="str">"Book not found"</span>)-&gt;<span class="fn">send</span>();
}

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">data</span>($book)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <h3 id="backend-5">1.5. The create controller</h3>

        <p>
            <code>app/_controller/book/add.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/add</span>

<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Book;

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

$rating = Validator::<span class="fn">post</span>(<span class="str">"rating"</span>)
    -&gt;<span class="fn">label</span>(<span class="str">"Rating"</span>)
    -&gt;<span class="fn">required</span>()
    -&gt;<span class="fn">number</span>()
    -&gt;<span class="fn">in</span>([<span class="num">1</span>,<span class="num">2</span>,<span class="num">3</span>,<span class="num">4</span>,<span class="num">5</span>])
    -&gt;<span class="fn">exec</span>();

$notes  = Validator::<span class="fn">post</span>(<span class="str">"notes"</span>)
    -&gt;<span class="fn">maxChars</span>(<span class="num">1000</span>)
    -&gt;<span class="fn">exec</span>();

<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

Book::<span class="fn">insert</span>([
    <span class="str">"title"</span>  =&gt; $title,
    <span class="str">"author"</span> =&gt; $author,
    <span class="str">"isbn"</span>   =&gt; $isbn,
    <span class="str">"rating"</span> =&gt; $rating,
    <span class="str">"notes"</span>  =&gt; $notes,
]);

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"Book added"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <h3 id="backend-6">1.6. The update controller</h3>

        <p>
            <code>app/_controller/book/update.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/update</span>

<span class="kw">use</span> Classes\Request;
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Book;

$id = Request::<span class="fn">get_decrypt</span>(<span class="str">"id"</span>);

<span class="kw">if</span> (! $id) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid request"</span>)-&gt;<span class="fn">send</span>();
}

$existing = Book::<span class="fn">findOne</span>([<span class="str">"id"</span> =&gt; $id]);

<span class="kw">if</span> (! $existing) {
    Response::<span class="fn">code</span>(<span class="num">404</span>)-&gt;<span class="fn">message</span>(<span class="str">"Book not found"</span>)-&gt;<span class="fn">send</span>();
}

$title  = Validator::<span class="fn">post</span>(<span class="str">"title"</span>)-&gt;<span class="fn">label</span>(<span class="str">"Title"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">maxChars</span>(<span class="num">255</span>)-&gt;<span class="fn">exec</span>();
$author = Validator::<span class="fn">post</span>(<span class="str">"author"</span>)-&gt;<span class="fn">label</span>(<span class="str">"Author"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">maxChars</span>(<span class="num">255</span>)-&gt;<span class="fn">exec</span>();
$isbn   = Validator::<span class="fn">post</span>(<span class="str">"isbn"</span>)-&gt;<span class="fn">label</span>(<span class="str">"ISBN"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">exec</span>();
$rating = Validator::<span class="fn">post</span>(<span class="str">"rating"</span>)-&gt;<span class="fn">label</span>(<span class="str">"Rating"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">number</span>()-&gt;<span class="fn">in</span>([<span class="num">1</span>,<span class="num">2</span>,<span class="num">3</span>,<span class="num">4</span>,<span class="num">5</span>])-&gt;<span class="fn">exec</span>();
$notes  = Validator::<span class="fn">post</span>(<span class="str">"notes"</span>)-&gt;<span class="fn">maxChars</span>(<span class="num">1000</span>)-&gt;<span class="fn">exec</span>();

<span class="comment">// ISBN unique check. only if it changed</span>
<span class="kw">if</span> ($isbn !== $existing[<span class="str">'isbn'</span>]) {
    $duplicate = Book::<span class="fn">findOne</span>([<span class="str">"isbn"</span> =&gt; $isbn]);
    <span class="kw">if</span> ($duplicate) {
        Response::<span class="fn">code</span>(<span class="num">422</span>)
            -&gt;<span class="fn">errors</span>([<span class="str">"isbn"</span> =&gt; <span class="str">"ISBN already exists."</span>])
            -&gt;<span class="fn">send</span>();
    }
}

<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

Book::<span class="fn">update</span>($id, [
    <span class="str">"title"</span>  =&gt; $title,
    <span class="str">"author"</span> =&gt; $author,
    <span class="str">"isbn"</span>   =&gt; $isbn,
    <span class="str">"rating"</span> =&gt; $rating,
    <span class="str">"notes"</span>  =&gt; $notes,
]);

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"Book updated"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Why the manual ISBN check?</strong> The
                <code>unique()</code> validator rule would also work
                here. but it would reject the record's own ISBN. We
                only want to reject a <em>different</em> book with the
                same ISBN. So we check manually.
            </p>
        </div>

        <h3 id="backend-7">1.7. The delete controller</h3>

        <p>
            <code>app/_controller/book/delete.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/delete</span>

<span class="kw">use</span> Classes\Request;
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Tables\Book;

$id = Request::<span class="fn">get_decrypt</span>(<span class="str">"id"</span>);

<span class="kw">if</span> (! $id) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid request"</span>)-&gt;<span class="fn">send</span>();
}

$existing = Book::<span class="fn">findOne</span>([<span class="str">"id"</span> =&gt; $id]);

<span class="kw">if</span> (! $existing) {
    Response::<span class="fn">code</span>(<span class="num">404</span>)-&gt;<span class="fn">message</span>(<span class="str">"Book not found"</span>)-&gt;<span class="fn">send</span>();
}

Book::<span class="fn">delete</span>($id);

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"Book deleted"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <h3 id="backend-8">1.8. Testing the endpoints</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment"># List</span>
<span class="cmd">curl</span> https://your-app.test/api/book/get

<span class="comment"># Read one</span>
<span class="cmd">curl</span> <span class="str">"https://your-app.test/api/book/getById?id=ENCRYPTED_ID"</span>

<span class="comment"># Create</span>
<span class="cmd">curl</span> -X POST https://your-app.test/api/book/add \
  -H <span class="str">"Content-Type: application/json"</span> \
  -d <span class="str">'{"title":"The Pragmatic Programmer","author":"Andrew Hunt","isbn":"978-0201616224","rating":5,"notes":"A must-read."}'</span>

<span class="comment"># Update</span>
<span class="cmd">curl</span> -X PUT <span class="str">"https://your-app.test/api/book/update?id=ENCRYPTED_ID"</span> \
  -H <span class="str">"Content-Type: application/json"</span> \
  -d <span class="str">'{"title":"Updated Title","author":"Andrew Hunt","isbn":"978-0201616224","rating":4,"notes":"Re-read recently."}'</span>

<span class="comment"># Delete</span>
<span class="cmd">curl</span> -X DELETE <span class="str">"https://your-app.test/api/book/delete?id=ENCRYPTED_ID"</span></code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Backend track is done.</strong> Message the
                frontend developer with the contract from Part 0 and
                hand off.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="frontend-track">Part 2. Frontend track</h2>

        <p class="lead">
            Owned by the frontend developer. Everything lives inside
            <code>views/</code>.
        </p>

        <h3 id="frontend-1">2.1. The page</h3>

        <p>
            <code>views/pages/library.php</code>:
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

    &lt;h1&gt;My Library&lt;/h1&gt;

    &lt;button class=<span class="str">"addbookbtn"</span>&gt;+ Add Book&lt;/button&gt;

    &lt;table id=<span class="str">"booksTable"</span>&gt;
        &lt;thead&gt;
            &lt;tr&gt;
                &lt;th&gt;Title&lt;/th&gt;
                &lt;th&gt;Author&lt;/th&gt;
                &lt;th&gt;ISBN&lt;/th&gt;
                &lt;th&gt;Rating&lt;/th&gt;
                &lt;th&gt;Actions&lt;/th&gt;
            &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody id=<span class="str">"booksBody"</span>&gt;&lt;/tbody&gt;
    &lt;/table&gt;

&lt;/body&gt;
&lt;/html&gt;</code></pre>
        </div>

        <h3 id="frontend-2">2.2. The paired JS</h3>

        <p>
            <code>views/js/library.js</code>. the entire CRUD feature:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">import</span> Ctr <span class="kw">from</span> <span class="str">"../code/src/mods/ctr.js"</span>;
<span class="kw">import</span> $$ <span class="kw">from</span> <span class="str">"../code/src/mods/ctrx/ctrx.js"</span>;
<span class="kw">import</span> TModal <span class="kw">from</span> <span class="str">"../code/src/mods/modals/tmodal.js"</span>;
<span class="kw">import</span> Twal <span class="kw">from</span> <span class="str">"../code/src/mods/twal.js"</span>;
<span class="kw">import</span> Tyrax <span class="kw">from</span> <span class="str">"../code/src/tyrux/main.js"</span>;

<span class="comment">// ─── 1. Build the modal (create + edit share it) ───</span>
<span class="kw">let</span> modal = TModal.<span class="fn">init</span>({
    id: <span class="str">"BookForm"</span>,
    title: <span class="str">"Add a book"</span>,
    form_id: <span class="str">"BookForm"</span>,
    form: {
        title:  { type: <span class="str">"text"</span>,     label: <span class="str">"Title:"</span> },
        author: { type: <span class="str">"text"</span>,     label: <span class="str">"Author:"</span> },
        isbn:   { type: <span class="str">"text"</span>,     label: <span class="str">"ISBN:"</span> },
        rating: { type: <span class="str">"select"</span>,   label: <span class="str">"Rating:"</span>, options: [
            { value: <span class="num">1</span>, label: <span class="str">"1 star"</span> },
            { value: <span class="num">2</span>, label: <span class="str">"2 stars"</span> },
            { value: <span class="num">3</span>, label: <span class="str">"3 stars"</span> },
            { value: <span class="num">4</span>, label: <span class="str">"4 stars"</span> },
            { value: <span class="num">5</span>, label: <span class="str">"5 stars"</span> }
        ]},
        notes:  { type: <span class="str">"textarea"</span>, label: <span class="str">"Notes:"</span> }
    }
});

<span class="comment">// ─── 2. Load and render the book list ───</span>
<span class="kw">function</span> <span class="fn">loadBooks</span>() {
    Tyrax.<span class="fn">get</span>({
        url: <span class="str">"book/get"</span>,
        res: (send, code, message, data) <span class="kw">=&gt;</span> {
            <span class="kw">if</span> (code <span class="op">!==</span> <span class="num">200</span>) {
                Twal.<span class="fn">err</span>(message);
                <span class="kw">return</span>;
            }
            <span class="fn">renderBooks</span>(data);
        }
    });
}

<span class="kw">function</span> <span class="fn">renderBooks</span>(books) {
    <span class="kw">let</span> rows = books.<span class="fn">map</span>(book <span class="kw">=&gt;</span> `
        &lt;tr&gt;
            &lt;td&gt;${book.title}&lt;/td&gt;
            &lt;td&gt;${book.author}&lt;/td&gt;
            &lt;td&gt;${book.isbn}&lt;/td&gt;
            &lt;td&gt;${book.rating} / 5&lt;/td&gt;
            &lt;td&gt;
                &lt;button class=<span class="str">"editbook"</span> data-id=<span class="str">"${book.id}"</span>&gt;Edit&lt;/button&gt;
                &lt;button class=<span class="str">"deletebook"</span> data-id=<span class="str">"${book.id}"</span>&gt;Delete&lt;/button&gt;
            &lt;/td&gt;
        &lt;/tr&gt;
    `).<span class="fn">join</span>(<span class="str">""</span>);

    document.<span class="fn">getElementById</span>(<span class="str">"booksBody"</span>).innerHTML = rows;
}

<span class="comment">// ─── 3. Open modal for a new book ───</span>
Ctr.<span class="fn">click</span>(<span class="str">".addbookbtn"</span>, () <span class="kw">=&gt;</span> {
    modal.openNew;
});

<span class="comment">// ─── 4. Open modal for editing ───</span>
$$.<span class="fn">click</span>(<span class="str">".editbook"</span>, (btn) <span class="kw">=&gt;</span> {
    <span class="kw">let</span> id = $$.<span class="fn">get_attribute</span>(btn, <span class="str">"data-id"</span>);

    Tyrax.<span class="fn">get</span>({
        url: <span class="str">"book/getById"</span>,
        params: { id: id },
        res: (send, code, message, data) <span class="kw">=&gt;</span> {
            <span class="kw">if</span> (code <span class="op">!==</span> <span class="num">200</span>) {
                Twal.<span class="fn">err</span>(message);
                <span class="kw">return</span>;
            }
            modal.<span class="fn">edit</span>(data, id, <span class="str">"Edit book"</span>);
        }
    });
});

<span class="comment">// ─── 5. Handle create + update in one submit ───</span>
modal.<span class="fn">form_submit</span>((data, raw) <span class="kw">=&gt;</span> {
    <span class="kw">if</span> (modal.<span class="fn">getMeta</span>()) {
        <span class="comment">// EDIT MODE</span>
        Tyrax.<span class="fn">put</span>({
            url: <span class="str">"book/update"</span>,
            params: { id: modal.<span class="fn">getMeta</span>() },
            data: raw,
            loading: { id: <span class="str">"BookForm"</span>, size: <span class="num">40</span> },
            res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) {
                    modal.<span class="fn">displayErrors</span>(errors);
                    <span class="kw">return</span>;
                }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">404</span>) {
                    Twal.<span class="fn">err</span>(message);
                    <span class="kw">return</span>;
                }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) {
                    Twal.<span class="fn">ok</span>(<span class="str">"Book updated"</span>, <span class="kw">true</span>);
                }
            }
        });
    } <span class="kw">else</span> {
        <span class="comment">// CREATE MODE</span>
        Tyrax.<span class="fn">post</span>({
            url: <span class="str">"book/add"</span>,
            req: raw,
            loading: { id: <span class="str">"BookForm"</span>, size: <span class="num">40</span> },
            res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) {
                    modal.<span class="fn">displayErrors</span>(errors);
                    <span class="kw">return</span>;
                }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) {
                    Twal.<span class="fn">ok</span>(<span class="str">"Book added"</span>, <span class="kw">true</span>);
                }
            }
        });
    }
});

<span class="comment">// ─── 6. Confirm and delete ───</span>
$$.<span class="fn">click</span>(<span class="str">".deletebook"</span>, (btn) <span class="kw">=&gt;</span> {
    <span class="kw">let</span> id = $$.<span class="fn">get_attribute</span>(btn, <span class="str">"data-id"</span>);

    Twal.<span class="fn">ask</span>(<span class="str">"Delete this book?"</span>, () <span class="kw">=&gt;</span> {
        Tyrax.<span class="fn">delete</span>({
            url: <span class="str">"book/delete"</span>,
            params: { id: id },
            res: (send, code, message) <span class="kw">=&gt;</span> {
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) {
                    Twal.<span class="fn">ok</span>(<span class="str">"Book deleted"</span>, () <span class="kw">=&gt;</span> $$.<span class="fn">reload</span>());
                } <span class="kw">else</span> {
                    Twal.<span class="fn">err</span>(message);
                }
            }
        });
    });
});

<span class="comment">// ─── 7. Initial load ───</span>
<span class="fn">loadBooks</span>();</code></pre>
        </div>

        <p>What each numbered block does:</p>

        <table class="docs-table">
            <thead>
                <tr><th>#</th><th>Purpose</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>One modal serves both create and edit</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Fetch all books and render rows into the table</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Wire the "+ Add" button to <code>modal.openNew</code></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>
                        On "Edit" click, fetch that book and call
                        <code>modal.edit()</code>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>
                        One submit handler. checks
                        <code>modal.getMeta()</code> to decide POST or PUT
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Confirm with <code>Twal.ask()</code>, then delete</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Load the list on page load</td>
                </tr>
            </tbody>
        </table>

        <!-- ============================================================ -->
        <h2 id="wire-format">The wire format</h2>

        <h3>List. success</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"code"</span>: <span class="num">200</span>,
    <span class="str">"message"</span>: <span class="str">"OK"</span>,
    <span class="str">"data"</span>: [
        {
            <span class="str">"id"</span>: <span class="num">1</span>,
            <span class="str">"title"</span>: <span class="str">"The Pragmatic Programmer"</span>,
            <span class="str">"author"</span>: <span class="str">"Andrew Hunt"</span>,
            <span class="str">"isbn"</span>: <span class="str">"978-0201616224"</span>,
            <span class="str">"rating"</span>: <span class="num">5</span>,
            <span class="str">"notes"</span>: <span class="str">"A must-read."</span>
        }
    ],
    <span class="str">"errors"</span>: <span class="kw">null</span>
}</code></pre>
        </div>

        <h3>Validation error. <code>422</code></h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"code"</span>: <span class="num">422</span>,
    <span class="str">"message"</span>: <span class="str">"Validation failed"</span>,
    <span class="str">"data"</span>: <span class="kw">null</span>,
    <span class="str">"errors"</span>: {
        <span class="str">"title"</span>: <span class="str">"Title is required."</span>,
        <span class="str">"isbn"</span>: <span class="str">"ISBN already exists."</span>
    }
}</code></pre>
        </div>

        <h3>Not found. <code>404</code></h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"code"</span>: <span class="num">404</span>,
    <span class="str">"message"</span>: <span class="str">"Book not found"</span>,
    <span class="str">"data"</span>: <span class="kw">null</span>,
    <span class="str">"errors"</span>: <span class="kw">null</span>
}</code></pre>
        </div>

        <!-- ============================================================ -->
        <h2 id="file-tree">The full file tree</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// BACKEND TRACK. owned by backend developer</span>
app/
├─ config/
│  └─ migration.php              <span class="comment">← books table</span>
├─ _routes/
│  └─ api.php                    <span class="comment">← 5 routes</span>
├─ _controller/
│  └─ book/
│     ├─ get.php                 <span class="comment">← list</span>
│     ├─ getById.php             <span class="comment">← read one</span>
│     ├─ add.php                 <span class="comment">← create</span>
│     ├─ update.php              <span class="comment">← update</span>
│     └─ delete.php              <span class="comment">← delete</span>
├─ base/
│  └─ Book.php                   <span class="comment">← auto-generated model</span>
└─ middleware/
   └─ g1.php                     <span class="comment">← auth guard</span>

<span class="comment">// FRONTEND TRACK. owned by frontend developer</span>
views/
├─ pages/
│  └─ library.php                <span class="comment">← page shell</span>
└─ js/
   └─ library.js                 <span class="comment">← all CRUD logic</span></code></pre>
        </div>

        <!-- ============================================================ -->
        <h2 id="checklists">Checklists</h2>

        <h3>Backend checklist</h3>

        <table class="docs-table">
            <thead>
                <tr><th>✓</th><th>Check</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>☐</td>
                    <td>Table added to <code>migration.php</code> and migrated</td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>All five routes in <code>api.php</code> inside the auth group</td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>All five controller files created</td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>Model generated at <code>app/base/Book.php</code></td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>Every endpoint tested with <code>curl</code></td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>All errors return the correct status code (401/404/422)</td>
                </tr>
            </tbody>
        </table>

        <h3>Frontend checklist</h3>

        <table class="docs-table">
            <thead>
                <tr><th>✓</th><th>Check</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>☐</td>
                    <td>Page exists at <code>views/pages/library.php</code></td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>Paired JS exists at <code>views/js/library.js</code></td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>TModal schema fields match the contract payload</td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>List loads on page start (<code>loadBooks()</code>)</td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>Edit fetches the record before opening the modal</td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        Submit handler distinguishes create vs. edit via
                        <code>modal.getMeta()</code>
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>Delete confirms with <code>Twal.ask()</code></td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>All <code>res</code> handlers cover 200 / 401 / 404 / 422</td>
                </tr>
            </tbody>
        </table>

        <!-- ============================================================ -->
        <h2 id="patterns">Patterns worth remembering</h2>

        <h3>One modal, two operations</h3>

        <p>
            The create and edit forms are identical, so they share one
            modal. The only difference is what happens on submit:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">if</span> (modal.<span class="fn">getMeta</span>()) {
    <span class="comment">// edit → PUT with id</span>
} <span class="kw">else</span> {
    <span class="comment">// create → POST without id</span>
}</code></pre>
        </div>

        <h3>Reload after mutation</h3>

        <p>
            After create or delete, reload the page so the list refreshes:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>(<span class="str">"Book added"</span>, <span class="kw">true</span>);              <span class="comment">// boolean form</span>
Twal.<span class="fn">ok</span>(<span class="str">"Book deleted"</span>, () <span class="kw">=&gt;</span> $$.<span class="fn">reload</span>());  <span class="comment">// callback form</span></code></pre>
        </div>

        <h3>Encrypted IDs</h3>

        <p>
            IDs in params are encrypted by CTRX. The frontend passes the
            raw value; the backend decrypts with
            <code>Request::get_decrypt()</code>. Clients can't enumerate
            records by guessing IDs.
        </p>

        <!-- ============================================================ -->
        <h2 id="common-errors">Common errors</h2>

        <h3>404 on every edit or delete</h3>

        <p>
            The ID isn't being decrypted properly. Check that the
            frontend sends <code>params: { id }</code> and the backend
            reads it with <code>Request::get_decrypt("id")</code>.
        </p>

        <h3>Update fails with 422 but the field looks fine</h3>

        <p>
            If you're using the <code>unique()</code> validator rule on
            a field that the record already has, it will fail. Do the
            duplicate check manually, comparing against the existing
            record:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">if</span> ($isbn !== $existing[<span class="str">'isbn'</span>]) {
    <span class="comment">// only check for duplicates if the value changed</span>
}</code></pre>
        </div>

        <h3>Delete removes the row but the list still shows it</h3>

        <p>
            Pass a reload callback to <code>Twal.ok()</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>(<span class="str">"Book deleted"</span>, () <span class="kw">=&gt;</span> $$.<span class="fn">reload</span>());</code></pre>
        </div>

        <h3>Table renders empty on page load</h3>

        <p>
            Check that <code>loadBooks()</code> is called at the end of
            your JS file. TYRAX uses the response's <code>data</code>
            key. make sure the list controller wraps the rows in
            <code>-&gt;data($books)</code>.
        </p>

        <!-- ============================================================ -->
        <h2 id="recap">Recap</h2>

        <p>
            Full CRUD in CTRX is five endpoints and two files on the
            frontend:
        </p>

        <p><strong>Backend</strong> (5 controllers, 5 routes):</p>

        <ul>
            <li><code>book/get.php</code>. list</li>
            <li><code>book/getById.php</code>. read one</li>
            <li><code>book/add.php</code>. create</li>
            <li><code>book/update.php</code>. update</li>
            <li><code>book/delete.php</code>. delete</li>
        </ul>

        <p><strong>Frontend</strong> (1 page, 1 JS file):</p>

        <ul>
            <li><code>pages/library.php</code>. UI shell</li>
            <li><code>js/library.js</code>. modal + list + all calls</li>
        </ul>

        <p>
            The two halves never share a file. The only thing they share
            is the contract. Every CTRX CRUD feature. books, contacts,
            invoices, whatever. follows this exact shape.
        </p>

        <div class="callout">
            <p>
                <strong>You've now seen the full pattern.</strong>
                Insert, read, update, delete. same five-step controller,
                same response shape, same frontend handler. Once you've
                built one CRUD feature, you've built them all.
            </p>
        </div>

        <nav class="docs-pager">
            <a href="insert-to-table.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← Insert to a Table</span>
            </a>
            <a href="login-flow.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Login Flow →</span>
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