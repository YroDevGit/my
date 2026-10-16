<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Insert to a Table. CTRX Documentation</title>
<link rel="stylesheet" href="<?=pagedir('docs/style.css')?>" />
</head>
<body>

<header class="docs-header">
    <div class="docs-header-inner">
        <a href="../index.html" class="docs-logo">Code<span>tazer</span>-X</a>
        <nav class="docs-top-nav">
            <a href="../getting-started/index.html">Get Started</a>
            <a href="insert-to-table.html" class="active">Tutorials</a>
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
            <span>Insert to a Table</span>
        </nav>

        <h1>Insert to a Table</h1>
        <p class="lead">
            This tutorial walks through inserting a record from a
            frontend form into a database table. We'll build a small
            <strong>library app</strong>: the user fills in a modal to
            add a book, and the record lands in the <code>books</code>
            table.
        </p>

        <div class="callout">
            <p>
                <strong>How to read this guide:</strong> Backend
                developers only need <em>Part 1</em>. Frontend developers
                only need <em>Part 2</em>. The only thing both need to
                agree on is <em>Part 0. The Contract</em>. Nothing else
                is shared.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="flow">The full flow</h2>

        <p>
            Before we touch any code, here's the complete journey. from
            user click to database row:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>┌────────────────────────────────────────────────────────────┐
│ FRONTEND TRACK (views/)                                     │
│                                                             │
│  1. User clicks ".addbookbtn"                               │
│  2. TModal opens with a declarative form                    │
│  3. User fills the form and submits                         │
│  4. modal.form_submit((data, raw) =&gt; {...})                 │
│  5. Tyrax.post({ url: "book/add", req: raw, ... })          │
└────────────────────────────────────────────────────────────┘
                             ↓
                    ┌──────────────────┐
                    │   THE CONTRACT   │
                    │  url: book/add   │
                    │  { code, message,│
                    │    data, errors }│
                    └──────────────────┘
                             ↓
┌────────────────────────────────────────────────────────────┐
│ BACKEND TRACK (app/)                                        │
│                                                             │
│  6. Route matches in app/_routes/api.php                    │
│  7. Middleware auth checks the session                      │
│  8. Controller runs: app/_controller/book/add.php           │
│  9. Validator checks every field                            │
│ 10. Book::insert([...]) writes the row                      │
│ 11. Response::code(200)-&gt;message("OK")-&gt;send()             │
└────────────────────────────────────────────────────────────┘
                             ↓
┌────────────────────────────────────────────────────────────┐
│ BACK ON THE FRONTEND                                        │
│                                                             │
│ 12. res(send, code, message, data, errors) fires            │
│ 13. Handler reads code. 200 / 401 / 422                    │
│ 14. Twal.ok("Book added", true) → reload                    │
└────────────────────────────────────────────────────────────┘</code></pre>
        </div>

        <p>
            Notice the shape: <strong>frontend → contract → backend →
            contract → frontend</strong>. Each side touches only its own
            folder. The only thing they share is the route name and the
            response format.
        </p>

        <!-- ============================================================ -->
        <h2 id="part-0">Part 0. The contract</h2>

        <p>
            Before either team writes code, both agree on the interface.
            This is what the backend promises to expose, and what the
            frontend promises to send:
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>Item</th><th>Value</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>Route name</td>
                    <td><code>book/add</code></td>
                </tr>
                <tr>
                    <td>HTTP method</td>
                    <td><code>POST</code></td>
                </tr>
                <tr>
                    <td>Auth</td>
                    <td>Required</td>
                </tr>
                <tr>
                    <td>Payload</td>
                    <td>
                        <code>title</code>, <code>author</code>,
                        <code>isbn</code>, <code>rating</code>,
                        <code>notes</code>
                    </td>
                </tr>
                <tr>
                    <td>Returns <code>200</code></td>
                    <td><code>{ code: 200, message: "OK" }</code></td>
                </tr>
                <tr>
                    <td>Returns <code>401</code></td>
                    <td><code>{ code: 401, message: "Unauthorized" }</code></td>
                </tr>
                <tr>
                    <td>Returns <code>422</code></td>
                    <td>
                        <code>{ code: 422, errors: { field: "message" } }</code>
                    </td>
                </tr>
            </tbody>
        </table>

        <p>
            Write this contract once. Both teams build against it
            independently. Nothing else needs to be coordinated.
        </p>

        <!-- ============================================================ -->
        <h2 id="backend-track">Part 1. Backend track</h2>

        <p class="lead">
            Owned by the backend developer. Everything in this part
            lives inside <code>app/</code>. The frontend developer never
            sees these files.
        </p>

        <h3 id="backend-1">1.1. The table</h3>

        <p>
            Every backend feature starts with a table. Add one to
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

        <p>Then run the migration and sync the model:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> db:migrate</code></pre>
        </div>

        <p>
            CTRX creates the table and generates
            <code>app/base/Book.php</code> automatically.
        </p>

        <h3 id="backend-2">1.2. The route</h3>

        <p>
            Open <code>app/_routes/api.php</code> and add the route to
            your authenticated group:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span>

<span class="kw">use</span> Classes\Router;

Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>, controller: <span class="str">"book/add"</span>),
    <span class="comment">// ...other routes</span>
)-&gt;<span class="fn">middleware</span>(<span class="str">"g1"</span>);</code></pre>
        </div>

        <p>What each part does:</p>

        <ul>
            <li>
                <code>method: "post"</code>. only POST requests reach
                this controller
            </li>
            <li>
                <code>controller: "book/add"</code>. resolves to
                <code>app/_controller/book/add.php</code>
            </li>
            <li>
                <code>-&gt;middleware("g1")</code>. runs
                <code>app/middleware/g1.php</code> before the controller.
                Only logged-in users can insert records.
            </li>
        </ul>

        <h3 id="backend-3">1.3. The controller</h3>

        <p>
            Create <code>app/_controller/book/add.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/add</span>

<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Book;

<span class="comment">// 1. Validate input</span>
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

<span class="comment">// 2. Stop on validation errors</span>
<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

<span class="comment">// 3. Insert the row</span>
$result = Book::<span class="fn">insert</span>([
    <span class="str">"title"</span>  =&gt; $title,
    <span class="str">"author"</span> =&gt; $author,
    <span class="str">"isbn"</span>   =&gt; $isbn,
    <span class="str">"rating"</span> =&gt; $rating,
    <span class="str">"notes"</span>  =&gt; $notes,
]);

$newId = $result-&gt;<span class="fn">_id</span>();

<span class="comment">// 4. Respond</span>
Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"OK"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <p>Four steps, each with a single responsibility:</p>

        <table class="docs-table">
            <thead>
                <tr><th>Step</th><th>Purpose</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Validator::post()</code></td>
                    <td>Reads and validates each field</td>
                </tr>
                <tr>
                    <td><code>Validator::errors()</code></td>
                    <td>Returns an array of errors (or empty). 422 if any</td>
                </tr>
                <tr>
                    <td><code>Book::insert()</code></td>
                    <td>Writes the row, returns an object with <code>_id()</code></td>
                </tr>
                <tr>
                    <td><code>Response::code(200)</code></td>
                    <td>Sends the success JSON back to the frontend</td>
                </tr>
            </tbody>
        </table>

        <h3 id="backend-4">1.4. Testing the endpoint</h3>

        <p>
            Before the frontend gets involved, verify the endpoint works
            with <code>curl</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">curl</span> -X POST https://your-app.test/api/book/add \
  -H <span class="str">"Content-Type: application/json"</span> \
  -d <span class="str">'{
    "title": "The Pragmatic Programmer",
    "author": "Andrew Hunt",
    "isbn": "978-0201616224",
    "rating": 5,
    "notes": "A must-read for anyone shipping software."
  }'</span></code></pre>
        </div>

        <p>Expected responses:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Success</span>
{ <span class="str">"code"</span>: <span class="num">200</span>, <span class="str">"message"</span>: <span class="str">"OK"</span> }

<span class="comment">// Validation errors</span>
{
    <span class="str">"code"</span>: <span class="num">422</span>,
    <span class="str">"errors"</span>: {
        <span class="str">"title"</span>: <span class="str">"Title is required."</span>,
        <span class="str">"rating"</span>: <span class="str">"Rating must be one of 1, 2, 3, 4, 5."</span>
    }
}</code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Backend track is done.</strong> Message the
                frontend developer with the contract from Part 0 and
                hand off. Nothing else is needed from this side until
                the frontend reports an issue.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="frontend-track">Part 2. Frontend track</h2>

        <p class="lead">
            Owned by the frontend developer. Everything in this part
            lives inside <code>views/</code>. The backend developer
            never sees these files.
        </p>

        <h3 id="frontend-1">2.1. The page</h3>

        <p>
            The page is a PHP file inside <code>views/pages/</code>.
            Every URL maps to a file by path. Since our route is
            <code>/library</code>, the page lives at:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>views/pages/library.php</code></pre>
        </div>

        <p>
            The page is a shell. it renders the UI, but the interactive
            logic lives in a paired JS file:
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

    &lt;!-- Book list rendered here --&gt;

&lt;/body&gt;
&lt;/html&gt;</code></pre>
        </div>

        <p>
            You don't need to add a <code>&lt;script&gt;</code> tag.
            CTRX auto-pairs the page to
            <code>views/js/library.js</code> and injects it into
            <code>&lt;head&gt;</code> automatically.
        </p>

        <h3 id="frontend-2">2.2. The paired JS</h3>

        <p>
            Create <code>views/js/library.js</code>. This is where you
            wire up the modal, form, and API call:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">import</span> Ctr <span class="kw">from</span> <span class="str">"../code/src/mods/ctr.js"</span>;
<span class="kw">import</span> TModal <span class="kw">from</span> <span class="str">"../code/src/mods/modals/tmodal.js"</span>;
<span class="kw">import</span> Twal <span class="kw">from</span> <span class="str">"../code/src/mods/twal.js"</span>;
<span class="kw">import</span> Tyrax <span class="kw">from</span> <span class="str">"../code/src/tyrux/main.js"</span>;

<span class="comment">// 1. Build the modal form from a schema</span>
<span class="kw">let</span> modal = TModal.<span class="fn">init</span>({
    id: <span class="str">"AddBook"</span>,
    title: <span class="str">"Add a book"</span>,
    form_id: <span class="str">"AddBookForm"</span>,
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

<span class="comment">// 2. Open the modal when "+ Add Book" is clicked</span>
Ctr.<span class="fn">click</span>(<span class="str">".addbookbtn"</span>, <span class="kw">function</span> () {
    modal.openNew;
});

<span class="comment">// 3. Handle the submit</span>
modal.<span class="fn">form_submit</span>(<span class="kw">function</span> (data, raw) {
    Tyrax.<span class="fn">post</span>({
        url: <span class="str">"book/add"</span>,
        req: raw,
        loading: { id: <span class="str">"AddBookForm"</span>, size: <span class="num">35</span> },
        res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) {
                modal.<span class="fn">displayErrors</span>(errors);
                <span class="kw">return</span>;
            }
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">401</span>) {
                Twal.<span class="fn">err</span>(message);
                <span class="kw">return</span>;
            }
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) {
                Twal.<span class="fn">ok</span>(<span class="str">"Book added to your library"</span>, <span class="kw">true</span>);
            }
        }
    });
});</code></pre>
        </div>

        <p>What each part does:</p>

        <table class="docs-table">
            <thead>
                <tr><th>Line</th><th>Purpose</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>TModal.init({...})</code></td>
                    <td>Builds the modal form from a schema. no HTML needed</td>
                </tr>
                <tr>
                    <td><code>modal.openNew</code></td>
                    <td>Opens the modal in "new record" mode</td>
                </tr>
                <tr>
                    <td><code>modal.form_submit()</code></td>
                    <td>Binds a handler that fires when the modal form is submitted</td>
                </tr>
                <tr>
                    <td><code>Tyrax.post()</code></td>
                    <td>Sends the request with the form data as JSON</td>
                </tr>
                <tr>
                    <td><code>loading</code></td>
                    <td>Shows a spinner on the form while waiting</td>
                </tr>
                <tr>
                    <td><code>res</code></td>
                    <td>Handles the response based on the status code</td>
                </tr>
            </tbody>
        </table>

        <h3 id="frontend-3">2.3. Reading the response</h3>

        <p>
            The <code>res</code> callback receives the server's response
            object plus shortcuts for its fields:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
    <span class="comment">// send    → full response object</span>
    <span class="comment">// code    → send.code</span>
    <span class="comment">// message → send.message</span>
    <span class="comment">// data    → send.data</span>
    <span class="comment">// errors  → send.errors</span>
}</code></pre>
        </div>

        <p>In an insert flow, three codes matter most:</p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Meaning</th>
                    <th>What the frontend does</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>200</code></td>
                    <td>Insert succeeded</td>
                    <td><code>Twal.ok("Book added to your library", true)</code></td>
                </tr>
                <tr>
                    <td><code>401</code></td>
                    <td>Auth failed</td>
                    <td><code>Twal.err(message)</code></td>
                </tr>
                <tr>
                    <td><code>422</code></td>
                    <td>Validation errors</td>
                    <td><code>modal.displayErrors(errors)</code></td>
                </tr>
            </tbody>
        </table>

        <div class="callout">
            <p>
                <strong>The second argument to <code>Twal.ok()</code></strong>
               . passing <code>true</code> tells Twal to reload the page
                after the success alert closes. That's why new records
                appear immediately.
            </p>
        </div>

        <!-- ============================================================ -->
        <h2 id="wire-format">The wire format</h2>

        <p>
            This is the JSON that travels between the two tracks. On
            success, the server sends:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"code"</span>: <span class="num">200</span>,
    <span class="str">"message"</span>: <span class="str">"OK"</span>,
    <span class="str">"data"</span>: <span class="kw">null</span>,
    <span class="str">"errors"</span>: <span class="kw">null</span>
}</code></pre>
        </div>

        <p>On validation failure, the server sends:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>{
    <span class="str">"code"</span>: <span class="num">422</span>,
    <span class="str">"message"</span>: <span class="str">"Validation failed"</span>,
    <span class="str">"data"</span>: <span class="kw">null</span>,
    <span class="str">"errors"</span>: {
        <span class="str">"title"</span>: <span class="str">"Title is required."</span>,
        <span class="str">"isbn"</span>: <span class="str">"ISBN already exists."</span>,
        <span class="str">"rating"</span>: <span class="str">"Rating must be one of 1, 2, 3, 4, 5."</span>
    }
}</code></pre>
        </div>

        <p>
            The <code>errors</code> object is what
            <code>modal.displayErrors(errors)</code> paints onto the
            form fields.
        </p>

        <!-- ============================================================ -->
        <h2 id="file-tree">The full file tree</h2>

        <p>Every file this tutorial touches, split by owner:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// BACKEND TRACK. owned by backend developer</span>
app/
├─ config/
│  └─ migration.php              <span class="comment">← step 1.1: table</span>
├─ _routes/
│  └─ api.php                    <span class="comment">← step 1.2: route</span>
├─ _controller/
│  └─ book/
│     └─ add.php                 <span class="comment">← step 1.3: controller</span>
├─ base/
│  └─ Book.php                   <span class="comment">← auto-generated model</span>
└─ middleware/
   └─ g1.php                     <span class="comment">← auth guard</span>

<span class="comment">// FRONTEND TRACK. owned by frontend developer</span>
views/
├─ pages/
│  └─ library.php                <span class="comment">← step 2.1: page shell</span>
└─ js/
   └─ library.js                 <span class="comment">← step 2.2: paired JS</span></code></pre>
        </div>

        <p>
            Notice: <strong>no file appears in both lists</strong>. That's
            the whole point.
        </p>

        <!-- ============================================================ -->
        <h2 id="checklists">Checklists</h2>

        <h3>Backend checklist. before handoff</h3>

        <table class="docs-table">
            <thead>
                <tr><th>✓</th><th>Check</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>☐</td>
                    <td>
                        Table added to
                        <code>app/config/migration.php</code> and
                        migrated
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        Route exists in <code>api.php</code> with the
                        right <code>method:</code> and
                        <code>controller:</code>
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        Middleware attached if auth is needed
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        Controller file exists at
                        <code>app/_controller/book/add.php</code>
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        Model generated at <code>app/base/Book.php</code>
                        (<code>php cli db:sync</code>)
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        Endpoint tested with <code>curl</code>. returns
                        200 and 422 correctly
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>Contract shared with frontend dev</td>
                </tr>
            </tbody>
        </table>

        <h3>Frontend checklist. before testing</h3>

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
                    <td>
                        Paired JS exists at <code>views/js/library.js</code>
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        TModal schema field names match the contract
                        payload
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        <code>Tyrax.post({ url: "..." })</code> matches
                        the contract route name
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        <code>res</code> handler covers 200 / 401 / 422
                    </td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>
                        <code>form_id</code> matches the modal's
                        <code>loading.id</code>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- ============================================================ -->
        <h2 id="common-errors">Common errors</h2>

        <h3>Backend: "Unauthorized" on every submit</h3>

        <p>
            The route isn't inside the authenticated group. Make sure
            <code>-&gt;middleware("g1")</code> is attached to the group
            containing your route.
        </p>

        <h3>Backend: Unique validation fails when it shouldn't</h3>

        <p>
            Check the format of the <code>unique()</code> rule. It
            expects <code>"table:column"</code>. for example
            <code>unique("books:isbn")</code>. If the table or column
            name is wrong, the check silently fails open.
        </p>

        <h3>Frontend: Validation returns 422 but nothing shows</h3>

        <p>
            Check that your <code>res</code> callback calls
            <code>modal.displayErrors(errors)</code>. and that the
            modal's <code>form_id</code> matches the internal form's ID.
            Also verify that the field names in your TModal schema match
            the error keys returned by the server.
        </p>

        <h3>Frontend: Insert succeeds but the new record doesn't appear</h3>

        <p>
            Pass <code>true</code> as the second argument to
            <code>Twal.ok()</code> to force a page reload:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Twal.<span class="fn">ok</span>(<span class="str">"Book added to your library"</span>, <span class="kw">true</span>);</code></pre>
        </div>

        <!-- ============================================================ -->
        <h2 id="recap">Recap</h2>

        <p>
            The insert flow in CTRX is split cleanly into two tracks:
        </p>

        <p><strong>Backend track</strong> (in <code>app/</code>):</p>

        <ol>
            <li>Add a table to <code>migration.php</code></li>
            <li>Declare a route in <code>api.php</code></li>
            <li>Write the controller in <code>_controller/</code></li>
            <li>Validate input with <code>Validator</code></li>
            <li>Insert with <code>Model::insert([...])</code></li>
            <li>Respond with <code>Response::code(...)-&gt;send()</code></li>
        </ol>

        <p><strong>Frontend track</strong> (in <code>views/</code>):</p>

        <ol>
            <li>Create the page in <code>pages/</code></li>
            <li>Create the paired JS in <code>js/</code></li>
            <li>Build a TModal schema matching the contract payload</li>
            <li>Call the endpoint with <code>Tyrax.post()</code></li>
            <li>Handle 200 / 401 / 422 in the <code>res</code> callback</li>
        </ol>

        <p>
            The two never share a file. The only thing they share is
            the contract. Every CTRX insert. books, contacts, projects,
            anything. follows this exact shape.
        </p>

        <div class="callout">
            <p>
                <strong>This is why CTRX works for teams.</strong>
                Two developers, one feature, zero coordination after the
                initial contract. Read the
                <a href="../concepts/team-workflow.html">Team Workflow</a>
                page to see why this matters at scale.
            </p>
        </div>

        <nav class="docs-pager">
            <a href="../backend/cli.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← CLI</span>
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