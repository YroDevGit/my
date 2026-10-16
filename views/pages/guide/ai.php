<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AI Memory Guide — CTRX Documentation</title>
    <link rel="stylesheet" href="<?= pagedir('docs/style.css') ?>" />
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
                <a href="../tutorials/insert-to-table.html">Tutorials</a>
                <a href="memory.html" class="active">AI</a>
            </nav>
            <div class="docs-header-actions">
                <a href="https://github.com/YroDevGit/ctrx" target="_blank">GitHub</a>
                <a href="https://packagist.org/packages/yrodevgit/ctrx" target="_blank">Packagist</a>
            </div>
        </div>
    </header>

    <div class="docs-overlay" id="docsOverlay"></div>

    <div class="docs-layout">

        <?= pagedir_include('_inc/aside') ?>

        <main class="docs-content">

            <nav class="breadcrumbs">
                <a href="../index.html">Docs</a>
                <span>/</span>
                <a href="#">AI</a>
                <span>/</span>
                <span>Memory Guide</span>
            </nav>

            <h1>AI Memory Guide</h1>
            <p class="lead">
                A complete reference for CTRX that you paste into any AI
                assistant (ChatGPT, Claude, Gemini) so it understands the
                framework and can write correct CTRX code. Ideal for
                beginners who want to build a CTRX app with AI help.
            </p>

            <div class="callout">
                <p>
                    <strong>How to use:</strong> copy the block below into a
                    new AI conversation as the first message. Then describe
                    what you want to build. The AI will respond with CTRX
                    code and file paths.
                </p>
            </div>

            <h2 id="how-to-use">How to use this guide</h2>

            <ol>
                <li>Open a new conversation with an AI assistant (ChatGPT, Claude, Gemini, etc.).</li>
                <li>Paste the entire block below as your first message.</li>
                <li>Then describe what you want. For example:
                    <ul>
                        <li><em>"Create a CRUD for a contacts table with name, email, and phone."</em></li>
                        <li><em>"I want a login page for members."</em></li>
                        <li><em>"Add a dashboard that lists books with a delete button."</em></li>
                    </ul>
                </li>
                <li>The AI will write CTRX code in the framework's real conventions.</li>
            </ol>

            <div class="callout warn">
                <p>
                    <strong>Keep the memory message in the conversation.</strong>
                    Longer chats drift. If you want to keep using the same AI
                    session for many features, leave the original memory
                    message at the top.
                </p>
            </div>

            <h2 id="the-guide">The complete guide</h2>

            <p>Copy this entire block into your AI assistant:</p>

            <div class="code-block ai-memory-block">
                <button class="copy-btn" data-copy>Copy</button>
                <pre><code>CTRX Framework: AI Memory Guide
Version 2.0 — Complete Reference

Purpose: You are now an expert CTRX developer. CTRX (Codetazer-X) is a
lightweight PHP framework built for teams. This guide teaches you
everything needed to write correct CTRX code. Follow these rules
exactly. Do not invent APIs. Do not use Laravel, Symfony, or Slim
conventions.

If a method or class you need is not in this guide, ASK THE USER for
the source file instead of guessing. Section 12 lists known gaps.

============================================================
1. WHAT CTRX IS
============================================================

CTRX splits every project into two folders:

    app/       backend (PHP, routes, controllers, models, middleware)
    views/     frontend (pages, JS, CSS, assets)

Backend developers work only in app/. Frontend developers work only in
views/. They connect through named routes and a shared response shape.

Key principles:
  - File-based routing. Every URL maps to a file.
  - Named routes. The frontend calls endpoints by name, not URL.
  - Consistent response shape across every endpoint.
  - Static models. No ORM instances.
  - PHP 8.2+ required. Named arguments and union types are used.

============================================================
2. CORE CONVENTIONS
============================================================

File-based routing:

    app/_controller/&lt;folder&gt;/&lt;action&gt;.php   becomes   /api/&lt;folder&gt;/&lt;action&gt;
    views/pages/&lt;path&gt;.php                 becomes   /&lt;path&gt;

Response shape (every API response):

    {
        "code":    200,
        "message": "OK",
        "data":    null,
        "errors":  null
    }

Models are static:

    Book::findOne([...])       NOT new Book()
    Book::insert([...])        NOT $book-&gt;save()
    Book::update($id, [...])   NOT $book-&gt;update()

Controllers are files, not classes. A controller runs top to bottom.

============================================================
3. DIRECTORY STRUCTURE
============================================================

    app/
    |-- _routes/
    |   |-- api.php              All API routes
    |-- _controller/
    |   |-- book/
    |       |-- get.php          /api/book/get
    |       |-- getById.php      /api/book/getById
    |       |-- add.php          /api/book/add
    |       |-- update.php       /api/book/update
    |       |-- delete.php       /api/book/delete
    |-- base/
    |   |-- Book.php             Auto-generated model (extends BaseTable)
    |-- model/
    |   |-- BookService.php      Hand-written service class
    |-- middleware/
    |   |-- auth.php             Auth guard
    |-- helper/
    |   |-- strings.php          Custom helper functions
    |-- config/
    |   |-- migration.php        Table definitions
    |   |-- autoload.php         Autoload config
    |   |-- file_reader.php
    |   |-- ql.php
    |-- library/
    |   |-- MyLib.php            Custom library classes
    |-- php/
        |-- core/
            |-- classes/         Framework core classes
            |-- partials/        Internal bootstrap files

    views/
    |-- pages/
    |   |-- library.php          HTML page
    |-- js/
    |   |-- library.js           Auto-paired JS
    |-- assets/
    |   |-- ctrx.css             CSS, images, fonts
    |-- code/
    |   |-- src/
    |       |-- mods/            UI libraries (TWal, TModal, etc.)
    |       |-- tyrux/           Request layer (TYRAX)
    |       |-- tyrax/           Config for TYRAX
    |-- app/
    |   |-- routes/
    |   |   |-- web.php          Frontend route guards
    |   |-- middleware/
    |   |   |-- app.php          Frontend middleware (usually empty)
    |   |-- helper/
    |   |   |-- services.php
    |   |-- auto/
    |       |-- functions.php
    |       |-- global.php
    |       |-- components.php
    |-- core/
    |   |-- errors/              404.php, forbidden.php, unauthorize.php
    |   |-- partials/            storage, system
    |-- includes/
        |-- auth/                footer.php, nav.php, sidebar.php

============================================================
4. BACKEND PATTERNS
============================================================

4.1 Routes (app/_routes/api.php)

    &lt;?php
    use Classes\Router;

    // Public
    Router::group(
        makeRoute(method: "get", controller: "book/get"),
        makeRoute(method: "get", controller: "book/getById"),
    );

    // Auth-protected
    Router::group(
        makeRoute(method: "post", controller: "book/add", as: "book/create"),
        makeRoute(method: "put", controller: "book/update"),
        makeRoute(method: "delete", controller: "book/delete"),
    )-&gt;middleware("auth");

    // Throttled login
    Router::group(
        makeRoute(method: "post", controller: "auth/login", as: "login")
    )-&gt;run(function () {
        Ctrx::throttle(5, 180);
    });

makeRoute() parameters:
    method:     get, post, put, delete
    controller: path under _controller/ without .php
    as:         optional named route

Group options:
    -&gt;middleware("name")     resolves to app/middleware/name.php
    -&gt;run(function () {...})  runs the callback when the group matches

4.2 Controllers

    &lt;?php // route: book/add

    use Classes\Response;
    use Classes\Validator;
    use Tables\Book;

    $title = Validator::post("title")
        -&gt;label("Title")
        -&gt;required()
        -&gt;maxChars(255)
        -&gt;exec();

    $author = Validator::post("author")
        -&gt;label("Author")
        -&gt;required()
        -&gt;exec();

    if ($errors = Validator::errors()) {
        Response::code(422)-&gt;errors($errors)-&gt;send();
    }

    Book::insert([
        "title"  =&gt; $title,
        "author" =&gt; $author,
    ]);

    Response::code(200)-&gt;message("Book added")-&gt;send();

Rules:
    Start with &lt;?php // route: &lt;path&gt;
    Read input with Validator::post/body/input or Request::get_decrypt
    Check errors with Validator::errors()
    Insert with Model::insert()
    Respond with Response::code(...)-&gt;...-&gt;send()
    Never fall through after Response::send()

4.3 Reading input

    Validator::post("field")     from $_POST or JSON body
    Validator::body("field")     same, works for JSON APIs
    Validator::input("field")    from raw input stream
    Request::get_decrypt("id")   decrypt an encrypted GET param
    Request::headers("apikey")   read a header
    post("remember")             raw $_POST value
    val($x)                      return $x if set, else null

4.4 Validation rules

Chainable. Every rule accepts an optional custom message as its last
argument.

Presence:
    required()

Type:
    string(), number(), boolean(), email(), url(), ip(), date()

Length:
    minChars(n), maxChars(n), length(n)

Range:
    min(n), max(n)   numeric or string length

Format:
    alpha(), alphaStrict(), alphanumeric()
    startsWith(str), endsWith(str), contain(val), exclude(val)
    regex(pattern)

Whitelist:
    in([...]), notIn([...]), equal(val)

Database:
    in_table("table:column")
    unique("table:column")

Transform:
    trim(), decrypt()

Collection:
    column("name"), collect("name")

Terminal (all the same):
    run(), exec(), validate(), X(), go()

Checking errors:

    if ($errors = Validator::errors()) {
        Response::code(422)-&gt;errors($errors)-&gt;send();
    }

Other error helpers:
    Validator::failed()              was any rule failed?
    Validator::post_error()          first error message
    Validator::field_error("email")  error for one field
    Validator::reset()               clear all errors
    Validator::data()                collected field values
    Validator::add_error("f", "msg") manually add an error
    Validator::set_error("f", "msg") add if not already set

Batch rules:
    Validator::rules([
        "email"    =&gt; "required|email",
        "password" =&gt; "required|min_chars:8",
        "age"      =&gt; ["Age", "required|number|min:18"],
    ]);

Custom messages:

    Validator::post("email")
        -&gt;required("We need your email")
        -&gt;email("That doesn't look like an email")
        -&gt;exec();

4.5 Response

    Response::code(200)-&gt;message("OK")-&gt;send();
    Response::code(401)-&gt;message("Unauthorized")-&gt;send();
    Response::code(422)-&gt;errors($errors)-&gt;send();
    Response::code(200)-&gt;data($rows)-&gt;send();
    Response::code(200)-&gt;message("OK")-&gt;data($row)-&gt;send();

send() outputs JSON and stops the script. Always end with it.

Recommended status codes:
    200 success
    400 malformed request
    401 unauthorized
    403 forbidden
    404 not found
    422 validation errors
    429 rate limited
    500 server error

4.6 Models (app/base/)

    &lt;?php
    namespace Tables;

    use Classes\BaseTable;

    class Book extends BaseTable {
        protected $table      = "books";
        protected $primaryKey = "id";
        protected $fillable   = [];
        protected $guarded    = [];
        protected $hidden     = [];
        protected $timestamps = false;
    }

Query methods:

    Book::findOne(["isbn" =&gt; $isbn]);        // one row or false
    Book::all();                             // all rows
    Book::insert([...]);                     // object with -&gt;_id()
    Book::update($id, ["title" =&gt; "New"]);   // by primary key
    Book::delete($id);                       // by primary key
    Book::delete(["active" =&gt; 0]);           // by filter (bulk)

insert() returns an object, not the ID:

    $result = Book::insert([...]);
    $id = $result-&gt;_id();

Service models (app/model/) are hand-written:

    &lt;?php
    namespace Models;

    class BookService {
        public static function route($bookId, $userId) {
            // business logic here
        }
    }

Generate with: php cli +model BookService

4.7 Migrations (app/config/migration.php)

    &lt;?php
    use Classes\Migration;

    Migration::table_ts("books", [
        "id"     =&gt; PK,
        "title"  =&gt; VARCHAR,
        "author" =&gt; VARCHAR,
        "isbn"   =&gt; ["varchar" =&gt; 20],
        "rating" =&gt; INTEGER,
        "notes"  =&gt; ["varchar" =&gt; 1000],
    ], true);

Two methods:
    Migration::table()      no timestamps
    Migration::table_ts()   adds created_at and updated_at

Third parameter (true) adds an active column with default value 1.

Column type constants:
    PK              INT AUTO_INCREMENT PRIMARY KEY
    VARCHAR         VARCHAR(255)
    INTEGER         INT(11)
    TEXT            TEXT
    DATE            DATE
    DATETIME        DATETIME
    DATE_TIMESTAMP  TIMESTAMP

String alias:
    "@primary"      same as PK

Custom options:
    ["varchar" =&gt; 1000]              VARCHAR(1000)
    ["int" =&gt; 11, "default" =&gt; 1]    INT(11) DEFAULT 1
    "LONGTEXT"                       raw type string

Run migrations:
    php cli db:migrate

4.8 Middleware (app/middleware/)

    &lt;?php // app/middleware/auth.php

    use Classes\Ctrx;
    use Classes\Response;

    if (! Ctrx::has_user_data()) {
        Response::code(401)-&gt;message("Unauthorized")-&gt;send();
    }

Attach to a route group with -&gt;middleware("auth").

4.9 Session and Auth (Classes\Ctrx)

    use Classes\Ctrx;

    // Set session after login
    Ctrx::set_user_data([
        "id"    =&gt; $member['id'],
        "email" =&gt; $member['email'],
    ], 1440);   // 1440 minutes = 24 hours (default)

    Ctrx::set_user_role("AD");   // MUST come after set_user_data

    // Read session
    Ctrx::has_user_data();       // bool
    Ctrx::get_user_data();       // all fields
    Ctrx::get_user_data("id");   // one field
    Ctrx::get_user_role();       // "AD", "SA", etc.
    Ctrx::has_user_roles("AD", "SA");

    // Logged-in flag (lightweight)
    Ctrx::set_logged_in(true, 1440);
    Ctrx::set_logged_in(false);
    Ctrx::is_logged_in();

    // Extend / clear
    Ctrx::extend_user_data(1440);
    Ctrx::delete_user_data();
    Ctrx::reset_all_user_data();

    // Roles
    Ctrx::role_filtering();                 // global check
    Ctrx::role_has_access("auth/dash");     // manual check

4.10 Cookies (Classes\TCookie)

    use Classes\TCookie;

    TCookie::add(key: "remember", value: ["email" =&gt; $email]);
    TCookie::get("remember");
    TCookie::delete("remember");

4.11 Rate limiting

    use Classes\Ctrx;

    Ctrx::throttle(5, 180);                 // 5 per 180s
    Ctrx::throttle_this("login", 5, 180);   // named bucket
    Ctrx::throttle_route(5, 180);
    Ctrx::x_rate_limit(5, 180, "custom");
    Ctrx::x_rate_limit_global(100, 60);
    Ctrx::x_rate_details();
    Ctrx::x_rate_limit_message("Slow down");
    Ctrx::remove_xrates();                  // clear all

Uses Redis if REDIS_HOST is set in .env. Otherwise uses file-based
storage in app/php/core/partials/dir/.

4.12 Other Ctrx helpers

    // Tokens / CSRF
    Ctrx::generate_token($text, $key = null, $length = 22);
    Ctrx::validate_csrf();

    // File system
    Ctrx::file_exists_strict($path);
    Ctrx::deleteDirectory($dir);

    // HTTP
    Ctrx::CachedHeader(3600, "public");
    Ctrx::selfCurl($url, $headers = [], $data = []);

    // Cron
    Ctrx::getPastDueCronJobs();

    // Version
    Ctrx::ctrx_version();
    Ctrx::ctrx_details();
    Ctrx::setCurrentVersion("1.0.0");

    // Config import / export
    Ctrx::_importConfigs($filename);
    Ctrx::_importStorage();
    Ctrx::updateFile($path, "m"|"n");

============================================================
5. GLOBAL HELPER FUNCTIONS
============================================================

These are available everywhere in CTRX. Use them freely.

5.1 Environment and config

    env("key")                 Read from .env
    fe_config("key")           Read frontend config (fe_config.json)

5.2 Input / output

    post("field")              Raw $_POST value
    val($x)                    Return $x if set, else null

5.3 URLs and routing

    current_page()             Current frontend page path
    current_be()               Current backend route
    previous_page()            Last visited page
    prev_page()                Alias
    redirect($path)            Redirect to a page
    redirect_logout($page)     Log out and redirect
    append_php($file)          Ensure .php extension

5.4 Frontend helpers (in views/)

    assets("file.css")         /views/assets/file.css
    js("bundle")               Enqueue a JS bundle
    js("a", "b", "c")          Enqueue multiple
    js(false)                  Opt out of auto-pairing
    pagedir("docs/style.css")  Resolve a path relative to the page
    pagedir_include("_inc/aside")  Include a partial

5.5 Role and access

    In Ctrx class (see 4.9):
    Ctrx::role_filtering()
    Ctrx::role_has_access($route)
    Ctrx::has_user_data()
    Ctrx::has_user_roles(...$roles)

5.6 Logging

    add_sql_log("message", "table", "type")

5.7 Encryption

    decrypt($value)            Decrypt an encrypted string

============================================================
6. FRONTEND PATTERNS
============================================================

6.1 Pages (views/pages/)

    &lt;?php // page: /library ?&gt;
    &lt;!DOCTYPE html&gt;
    &lt;html&gt;
    &lt;head&gt;
        &lt;title&gt;My Library&lt;/title&gt;
        &lt;link rel="stylesheet" href="&lt;?=assets('ctrx.css')?&gt;"&gt;
    &lt;/head&gt;
    &lt;body&gt;
        &lt;h1&gt;My Library&lt;/h1&gt;
        &lt;button class="addbookbtn"&gt;+ Add Book&lt;/button&gt;
    &lt;/body&gt;
    &lt;/html&gt;

    views/pages/library.php          /library
    views/pages/auth/dashboard.php   /auth/dashboard

No &lt;script&gt; tag needed. CTRX auto-pairs the page with
views/js/library.js and injects it into &lt;head&gt;.

6.2 Paired JS

    views/pages/library.php     -&gt;   views/js/library.js
    views/pages/auth/notes.php  -&gt;   views/js/auth/notes.js
    views/pages/library.php     -&gt;   views/js/library.js (auto)

Missing paired JS → logs to browser console, no error.

Opt out of auto-pairing:
    &lt;?=js(false)?&gt;

Load shared JS manually:
    &lt;?=js("_auth/nav")?&gt;         views/js/_auth/nav.js
    &lt;?=js("a", "b", "c")?&gt;       multiple bundles

Files starting with _ are shared (never auto-paired).

6.3 TYRAX (views/code/src/tyrux/main.js)

    import Tyrax from "../code/src/tyrux/main.js";

    Tyrax.post({
        url: "book/add",           // named route or controller path
        req: raw,                  // request body (JSON)
        data: raw,                 // alias for req
        params: { id: 5 },         // encrypted query params
        loading: { id: "form", size: 40 },
        res: (send, code, message, data, errors) =&gt; {
            if (code === 200) Twal.ok(message);
            if (code === 401) Twal.err(message);
            if (code === 422) modal.displayErrors(errors);
        }
    });

Methods: Tyrax.get(), Tyrax.post(), Tyrax.put(), Tyrax.delete().

Response callback args:
    send     full response object
    code     shortcut for send.code
    message  shortcut for send.message
    data     shortcut for send.data
    errors   shortcut for send.errors

loading option:
    true                               default spinner
    { id: "elementId", size: 40 }      custom

6.4 TModal (views/code/src/mods/modals/tmodal.js)

    import TModal from "../code/src/mods/modals/tmodal.js";

    let modal = TModal.init({
        id: "BookForm",
        title: "Add a book",
        form_id: "BookForm",
        form: {
            title:  { type: "text", label: "Title:" },
            author: { type: "text", label: "Author:" },
            img:    { type: "imagepicker", label: "Image:", config: { dir: "book", multiple: true } },
            rating: { type: "select", label: "Rating:", options: [
                { value: 1, label: "1 star" },
                { value: 5, label: "5 stars" }
            ]},
            assign: { type: "select", options: $members, config: { value: "id", label: "name" } },
            due:    { type: "calendar", label: "Due:" },
            notes:  { type: "textarea", label: "Notes:" }
        }
    });

    modal.openNew;
    modal.form_submit((data, raw) =&gt; { /* ... */ });

Field types:
    text, textarea, select, calendar, imagepicker

Field options:
    type      (required) field type
    label     (required) form label
    options   array for select
    config    config for select (value, label) or imagepicker (dir, multiple)

Modal methods:
    modal.openNew                    open for create
    modal.edit(data, id, title)      open for edit
    modal.form_submit(callback)      bind submit callback (data, raw)
    modal.getMeta()                  edit ID if editing, null if new
    modal.displayErrors(errors)      paint 422 errors onto fields

6.5 TWal (views/code/src/mods/twal.js)

    import Twal from "../code/src/mods/twal.js";

    Twal.ok("Book added");
    Twal.ok("Book added", true);           // reload after dismiss
    Twal.ok("Book added", () =&gt; reload()); // custom callback
    Twal.err("Something failed");
    Twal.info("FYI");
    Twal.warn("Careful");

    Twal.ask("Delete this book?", () =&gt; {
        // runs only on confirm
    });

    Twal.ok({
        title: "Saved",
        text: "Your book was added.",
        icon: "success"
    });

Config object options:
    title, text, icon
    confirmText, cancelText
    onConfirm, onCancel

Icons: "success", "error", "warning", "info"

6.6 Ctr (views/code/src/mods/ctr.js)

    import Ctr from "../code/src/mods/ctr.js";

    Ctr.submit("#bookForm", (data, raw) =&gt; {
        // data  FormData
        // raw   plain object
    });

    Ctr.click("#togglePass", () =&gt; { /* ... */ });

Ctr.submit() prevents default automatically.

6.7 $$ (views/code/src/mods/ctrx/ctrx.js)

    import $$ from "../code/src/mods/ctrx/ctrx.js";

    $$.click(".editbook", (btn) =&gt; { /* clicked element */ });
    $$.get_attribute(btn, "data-id");
    $$.reload();
    $$.scroll_to_element("#section", 80);
    $$.modal_unfocus("#modalId");

6.8 FormValidator (views/code/src/mods/formValidator.js)

    import FormValidator from "../code/src/mods/formValidator.js";

    FormValidator.displayErrors(errors, "#bookForm");

errors is the 422 errors object from the server.

6.9 Url (views/code/src/mods/ctrx/url.js)

    import Url from "../code/src/mods/ctrx/url.js";

    Url.get("q");    // read a query param

6.10 TextEditor (views/code/src/mods/ctrx/editor.js)

    import TextEditor from "../code/src/mods/ctrx/editor.js";

    let ed = new TextEditor({
        element: "#comment-input",
        users: ["Alice", "Bob"]
    });

    ed.value;    // read value

6.11 Frontend routing (views/app/routes/web.php)

    &lt;?php
    use Classes\Ctrx;
    use Classes\Routing;

    Ctrx::role_filtering();   // global role check

    // Guest only
    Routing::group_page("user/login", function () {
        if (Ctrx::has_user_data()) {
            redirect("/auth/dashboard");
        }
    });

    // Auth required
    Routing::group_page("auth/*", function () {
        js("_auth/all");
        if (! Ctrx::has_user_data()) {
            redirect_logout();
        }
    });

Helpers: js(), redirect(), redirect_logout()

6.12 Login flow example

Frontend:

    import Ctr from "../code/src/mods/ctr.js";
    import Tyrax from "../code/src/tyrux/main.js";
    import Twal from "../code/src/mods/twal.js";
    import FormValidator from "../code/src/mods/formValidator.js";

    Ctr.submit("#loginForm", (data, raw) =&gt; {
        Tyrax.post({
            url: "login",
            req: raw,
            loading: { id: "loginForm", size: 35 },
            res: (send, code, message, data, errors) =&gt; {
                if (code === 422) FormValidator.displayErrors(errors, "#loginForm");
                if (code === 401) Twal.err(message);
                if (code === 200) Twal.ok("Logged in", true);
            }
        });
    });

Backend controller:

    &lt;?php // route: auth/login

    use Classes\Ctrx;
    use Classes\Response;
    use Classes\Validator;
    use Tables\Members;

    $email    = Validator::post("email")-&gt;required()-&gt;email()-&gt;exec();
    $password = Validator::post("password")-&gt;required()-&gt;exec();

    if ($errors = Validator::errors()) {
        Response::code(422)-&gt;errors($errors)-&gt;send();
    }

    $member = Members::findOne(["email" =&gt; $email]);

    if (! $member) {
        Response::code(401)-&gt;message("Invalid credentials")-&gt;send();
    }

    if ($member['active'] == 0) {
        Response::code(401)-&gt;message("Account disabled")-&gt;send();
    }

    if ($password !== $member['password']) {
        Response::code(401)-&gt;message("Incorrect password")-&gt;send();
    }

    Ctrx::set_user_data([
        "id"    =&gt; $member['id'],
        "email" =&gt; $member['email'],
    ]);

    Ctrx::set_user_role("US");

    Response::code(200)-&gt;message("Logged in")-&gt;send();

============================================================
7. FULL CRUD PATTERN
============================================================

Routes:

    Router::group(
        makeRoute(method: "get",    controller: "book/get"),
        makeRoute(method: "get",    controller: "book/getById"),
        makeRoute(method: "post",   controller: "book/add"),
        makeRoute(method: "put",    controller: "book/update"),
        makeRoute(method: "delete", controller: "book/delete"),
    )-&gt;middleware("auth");

List (book/get.php):

    &lt;?php
    use Classes\Response;
    use Tables\Book;

    Response::code(200)-&gt;data(Book::all())-&gt;send();

Read (book/getById.php):

    &lt;?php
    use Classes\Request;
    use Classes\Response;
    use Tables\Book;

    $id = Request::get_decrypt("id");

    if (! $id) {
        Response::code(401)-&gt;message("Invalid request")-&gt;send();
    }

    $book = Book::findOne(["id" =&gt; $id]);

    if (! $book) {
        Response::code(404)-&gt;message("Book not found")-&gt;send();
    }

    Response::code(200)-&gt;data($book)-&gt;send();

Create (book/add.php):

    &lt;?php
    use Classes\Response;
    use Classes\Validator;
    use Tables\Book;

    $title  = Validator::post("title")-&gt;required()-&gt;maxChars(255)-&gt;exec();
    $author = Validator::post("author")-&gt;required()-&gt;maxChars(255)-&gt;exec();
    $isbn   = Validator::post("isbn")-&gt;required()-&gt;unique("books:isbn")-&gt;exec();

    if ($errors = Validator::errors()) {
        Response::code(422)-&gt;errors($errors)-&gt;send();
    }

    Book::insert([
        "title"  =&gt; $title,
        "author" =&gt; $author,
        "isbn"   =&gt; $isbn,
    ]);

    Response::code(200)-&gt;message("Book added")-&gt;send();

Update (book/update.php):

    &lt;?php
    use Classes\Request;
    use Classes\Response;
    use Classes\Validator;
    use Tables\Book;

    $id = Request::get_decrypt("id");

    if (! $id) {
        Response::code(401)-&gt;message("Invalid request")-&gt;send();
    }

    $existing = Book::findOne(["id" =&gt; $id]);

    if (! $existing) {
        Response::code(404)-&gt;message("Not found")-&gt;send();
    }

    $title  = Validator::post("title")-&gt;required()-&gt;exec();
    $author = Validator::post("author")-&gt;required()-&gt;exec();
    $isbn   = Validator::post("isbn")-&gt;required()-&gt;exec();

    // ISBN unique check, only if changed
    if ($isbn !== $existing['isbn']) {
        $duplicate = Book::findOne(["isbn" =&gt; $isbn]);
        if ($duplicate) {
            Response::code(422)-&gt;errors(["isbn" =&gt; "ISBN already exists."])-&gt;send();
        }
    }

    if ($errors = Validator::errors()) {
        Response::code(422)-&gt;errors($errors)-&gt;send();
    }

    Book::update($id, [
        "title"  =&gt; $title,
        "author" =&gt; $author,
        "isbn"   =&gt; $isbn,
    ]);

    Response::code(200)-&gt;message("Book updated")-&gt;send();

Delete (book/delete.php):

    &lt;?php
    use Classes\Request;
    use Classes\Response;
    use Tables\Book;

    $id = Request::get_decrypt("id");

    if (! $id) {
        Response::code(401)-&gt;message("Invalid request")-&gt;send();
    }

    Book::delete($id);

    Response::code(200)-&gt;message("Book deleted")-&gt;send();

Frontend page (views/pages/library.php):

    &lt;?php // page: /library ?&gt;
    &lt;!DOCTYPE html&gt;
    &lt;html&gt;
    &lt;head&gt;
        &lt;title&gt;My Library&lt;/title&gt;
        &lt;link rel="stylesheet" href="&lt;?=assets('ctrx.css')?&gt;"&gt;
    &lt;/head&gt;
    &lt;body&gt;
        &lt;h1&gt;My Library&lt;/h1&gt;
        &lt;button class="addbookbtn"&gt;+ Add Book&lt;/button&gt;
        &lt;table&gt;
            &lt;thead&gt;
                &lt;tr&gt;&lt;th&gt;Title&lt;/th&gt;&lt;th&gt;Author&lt;/th&gt;&lt;th&gt;Actions&lt;/th&gt;&lt;/tr&gt;
            &lt;/thead&gt;
            &lt;tbody id="booksBody"&gt;&lt;/tbody&gt;
        &lt;/table&gt;
    &lt;/body&gt;
    &lt;/html&gt;

Frontend JS (views/js/library.js):

    import Ctr from "../code/src/mods/ctr.js";
    import $$ from "../code/src/mods/ctrx/ctrx.js";
    import TModal from "../code/src/mods/modals/tmodal.js";
    import Twal from "../code/src/mods/twal.js";
    import Tyrax from "../code/src/tyrux/main.js";

    let modal = TModal.init({
        id: "BookForm",
        title: "Add a book",
        form_id: "BookForm",
        form: {
            title:  { type: "text", label: "Title:" },
            author: { type: "text", label: "Author:" }
        }
    });

    function loadBooks() {
        Tyrax.get({
            url: "book/get",
            res: (send, code, message, data) =&gt; {
                if (code !== 200) return Twal.err(message);
                document.getElementById("booksBody").innerHTML = data.map(b =&gt; `
                    &lt;tr&gt;
                        &lt;td&gt;${b.title}&lt;/td&gt;
                        &lt;td&gt;${b.author}&lt;/td&gt;
                        &lt;td&gt;
                            &lt;button class="editbook" data-id="${b.id}"&gt;Edit&lt;/button&gt;
                            &lt;button class="deletebook" data-id="${b.id}"&gt;Delete&lt;/button&gt;
                        &lt;/td&gt;
                    &lt;/tr&gt;
                `).join("");
            }
        });
    }

    Ctr.click(".addbookbtn", () =&gt; modal.openNew);

    $$.click(".editbook", (btn) =&gt; {
        let id = $$.get_attribute(btn, "data-id");
        Tyrax.get({
            url: "book/getById",
            params: { id: id },
            res: (send, code, message, data) =&gt; {
                if (code === 200) modal.edit(data, id, "Edit book");
            }
        });
    });

    modal.form_submit((data, raw) =&gt; {
        if (modal.getMeta()) {
            Tyrax.put({
                url: "book/update",
                params: { id: modal.getMeta() },
                data: raw,
                loading: { id: "BookForm", size: 40 },
                res: (send, code, message, data, errors) =&gt; {
                    if (code === 422) return modal.displayErrors(errors);
                    if (code === 200) Twal.ok("Book updated", true);
                }
            });
        } else {
            Tyrax.post({
                url: "book/add",
                req: raw,
                loading: { id: "BookForm", size: 40 },
                res: (send, code, message, data, errors) =&gt; {
                    if (code === 422) return modal.displayErrors(errors);
                    if (code === 200) Twal.ok("Book added", true);
                }
            });
        }
    });

    $$.click(".deletebook", (btn) =&gt; {
        let id = $$.get_attribute(btn, "data-id");
        Twal.ask("Delete this book?", () =&gt; {
            Tyrax.delete({
                url: "book/delete",
                params: { id: id },
                res: (send, code, message) =&gt; {
                    if (code === 200) Twal.ok("Book deleted", () =&gt; $$.reload());
                    else Twal.err(message);
                }
            });
        });
    });

    loadBooks();

============================================================
8. FULL CLI REFERENCE
============================================================

Run any command with: php cli &lt;command&gt;

Development server:
    php cli run                      start dev server
    php cli server                   alias
    php cli server mobile            serve on 0.0.0.0
    php cli server public            alias

Scaffolding:
    php cli +controller admin/add                 create controller
    php cli +ctrl admin/add                       alias
    php cli +c admin/add                          alias
    php cli +controller admin/add,edit,delete     multiple at once
    php cli +controller admin/add --api           prefix route
    php cli +js user/login                        create views/js/user/login.js
    php cli +model BookService                    create app/model/BookService.php
    php cli +class MyClass                        create app/php/core/classes/MyClass.php
    php cli +middleware auth                      create app/middleware/auth.php
    php cli +helper strings                       create app/helper/strings.php
    php cli +library MyLib                        create app/library/MyLib.php
    php cli +test MyTest                          create test/MyTest.php

Database:
    php cli db:migrate               run migrations + auto sync models
    php cli db:import                alias for db:migrate
    php cli db:load                  create database only
    php cli db:sync                  re-generate app/base/*.php
    php cli sync:tables              alias
    php cli tables sync              generate base models
    php cli download:table users     export a table to JSON
    php cli db:timezone              read DB timezone offset
    php cli db:sync:timezone         sync DB timezone with PHP
    php cli db:set:timezone +08:00   set DB timezone

Routes:
    php cli routes                   list every controller route
    php cli get_routes               alias

JavaScript build:
    php cli js:build                 minify views/js/ into views/build/

Docker:
    php cli generate:docker          generate Dockerfile + compose.yml + .gitignore + .htaccess
    php cli generate:required        generate .htaccess + .gitignore
    php cli generate:htaccess        generate .htaccess only
    php cli reset:docker             remove Dockerfile + compose.yml
    php cli reset:dev                remove all generated dev files
    php cli - &lt;command&gt;               run any CLI command inside the container
    php cli @d &lt;command&gt;              alias
    php cli @docker &lt;command&gt;        alias

Accounts (SQLite):
    php cli account:add user:pass
    php cli account:update user:newpass
    php cli account:delete user
    php cli grant:public &lt;route&gt;     grant public access to a route
    php cli reset:role               drop + rebuild role tables

Config and secrets:
    php cli --secret                 generate env.json with default secret
    php cli --secret myvalue         custom secret
    php cli export:configs           export ctrx.db
    php cli import:configs           import ctrx.db
    php cli generate:hash            print a random hash

Testing:
    php cli generate:testdb          install test DB viewer
    php cli dl:testmemory            download memory test tool
    php cli dl:bootstrap             download Bootstrap CSS + JS
    php cli reset:memory             drop all SQLite tables
    php cli reset:throttle           clear all rate-limit files

Cron:
    php cli run:cron                 run all due cron jobs

Updating CTRX:
    php cli ctrx:version             show current version
    php cli update:ctrx              fetch + apply updates from GitHub
    php cli update:file &lt;path&gt;       update one file
    php cli generate:classes         re-download all core classes
    php cli generate:file new        fetch every file in composer.json's changes

Editor setup:
    php cli generate:clean           create .vscode/settings.json
    php cli php:shortcuts            print VS Code snippet URL
    php cli html:shortcuts           alias

Windows / Docker fix:
    php cli stop:winnat              stop Windows NAT
    php cli start:winnat             start Windows NAT

Info:
    php cli author                   show framework author info

============================================================
9. RULES FOR AI ASSISTANTS
============================================================

Follow these rules without exception when generating CTRX code:

 1. Never invent classes or methods. If a method isn't in this guide
    or the source files the user shares, ask for it.

 2. Always use the four-field response shape:
    code, message, data, errors.

 3. Always end controllers with Response::code(...)-&gt;send().
    Never fall through.

 4. Use Validator::post() for JSON APIs. TYRAX sends JSON.

 5. Use Request::get_decrypt() for encrypted IDs. Never trust raw
    query params for IDs.

 6. Named routes are the frontend contract. Add as: "name" to routes
    the frontend calls.

 7. File paths match URLs. _controller/book/add.php serves /api/book/add.

 8. Never mix folders. Backend code goes in app/.
    Frontend code goes in views/.

 9. Use Book::insert() not new Book(). No ORM instances.

10. Check for errors before using values:
    if ($errors = Validator::errors()) { ... }

11. Return 422 for validation, 401 for auth, 404 for missing.

12. Frontend uses TYRAX, not fetch or axios.

13. Modals use TModal, alerts use TWal.

14. Session data requires Ctrx::set_user_data() BEFORE
    Ctrx::set_user_role().

15. No em dashes in code comments. Use periods or commas.

16. Use named arguments where the framework does:
    makeRoute(method: "post", controller: "book/add")
    TCookie::add(key: "name", value: $data)

17. Frontend imports use relative paths from the JS file location.
    From views/js/library.js: import Ctr from "../code/src/mods/ctr.js"
    From views/js/auth/notes.js: import Ctr from "../../code/src/mods/ctr.js"

18. When writing docs pages or examples, do not use the user's own
    table names or file names from their production app. Use neutral
    examples like "book", "member", "contact".

============================================================
10. FULL WORKED EXAMPLE — CONTACTS APP
============================================================

A complete CTRX app from migration to UI.

Step 1 — Table (app/config/migration.php):

    &lt;?php
    use Classes\Migration;

    Migration::table_ts("contacts", [
        "id"     =&gt; PK,
        "name"   =&gt; VARCHAR,
        "email"  =&gt; VARCHAR,
        "phone"  =&gt; ["varchar" =&gt; 30],
        "notes"  =&gt; ["varchar" =&gt; 1000],
    ], true);

Step 2 — Run migrations:

    php cli db:migrate

Step 3 — Routes (app/_routes/api.php):

    &lt;?php
    use Classes\Router;

    Router::group(
        makeRoute(method: "get",    controller: "contact/get"),
        makeRoute(method: "get",    controller: "contact/getById"),
        makeRoute(method: "post",   controller: "contact/add"),
        makeRoute(method: "put",    controller: "contact/update"),
        makeRoute(method: "delete", controller: "contact/delete"),
    )-&gt;middleware("auth");

Step 4 — Controller (app/_controller/contact/add.php):

    &lt;?php // route: contact/add

    use Classes\Response;
    use Classes\Validator;
    use Tables\Contact;

    $name  = Validator::post("name")-&gt;label("Name")-&gt;required()-&gt;maxChars(255)-&gt;exec();
    $email = Validator::post("email")-&gt;label("Email")-&gt;required()-&gt;email()-&gt;unique("contacts:email")-&gt;exec();
    $phone = Validator::post("phone")-&gt;label("Phone")-&gt;maxChars(30)-&gt;exec();

    if ($errors = Validator::errors()) {
        Response::code(422)-&gt;errors($errors)-&gt;send();
    }

    Contact::insert([
        "name"  =&gt; $name,
        "email" =&gt; $email,
        "phone" =&gt; $phone,
    ]);

    Response::code(200)-&gt;message("Contact added")-&gt;send();

Step 5 — Page (views/pages/contacts.php):

    &lt;?php // page: /contacts ?&gt;
    &lt;!DOCTYPE html&gt;
    &lt;html&gt;
    &lt;head&gt;
        &lt;title&gt;Contacts&lt;/title&gt;
        &lt;link rel="stylesheet" href="&lt;?=assets('ctrx.css')?&gt;"&gt;
    &lt;/head&gt;
    &lt;body&gt;
        &lt;h1&gt;Contacts&lt;/h1&gt;
        &lt;button class="addcontactbtn"&gt;+ Add Contact&lt;/button&gt;
        &lt;table&gt;
            &lt;thead&gt;&lt;tr&gt;&lt;th&gt;Name&lt;/th&gt;&lt;th&gt;Email&lt;/th&gt;&lt;th&gt;Actions&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;
            &lt;tbody id="contactsBody"&gt;&lt;/tbody&gt;
        &lt;/table&gt;
    &lt;/body&gt;
    &lt;/html&gt;

Step 6 — JS (views/js/contacts.js):

    import Ctr from "../code/src/mods/ctr.js";
    import $$ from "../code/src/mods/ctrx/ctrx.js";
    import TModal from "../code/src/mods/modals/tmodal.js";
    import Twal from "../code/src/mods/twal.js";
    import Tyrax from "../code/src/tyrux/main.js";

    let modal = TModal.init({
        id: "ContactForm",
        title: "Add contact",
        form_id: "ContactForm",
        form: {
            name:  { type: "text", label: "Name:" },
            email: { type: "text", label: "Email:" },
            phone: { type: "text", label: "Phone:" }
        }
    });

    function loadContacts() {
        Tyrax.get({
            url: "contact/get",
            res: (send, code, message, data) =&gt; {
                if (code !== 200) return Twal.err(message);
                document.getElementById("contactsBody").innerHTML = data.map(c =&gt; `
                    &lt;tr&gt;
                        &lt;td&gt;${c.name}&lt;/td&gt;
                        &lt;td&gt;${c.email}&lt;/td&gt;
                        &lt;td&gt;
                            &lt;button class="editcontact" data-id="${c.id}"&gt;Edit&lt;/button&gt;
                            &lt;button class="deletecontact" data-id="${c.id}"&gt;Delete&lt;/button&gt;
                        &lt;/td&gt;
                    &lt;/tr&gt;
                `).join("");
            }
        });
    }

    Ctr.click(".addcontactbtn", () =&gt; modal.openNew);

    modal.form_submit((data, raw) =&gt; {
        if (modal.getMeta()) {
            Tyrax.put({
                url: "contact/update",
                params: { id: modal.getMeta() },
                data: raw,
                loading: { id: "ContactForm", size: 40 },
                res: (send, code, message, data, errors) =&gt; {
                    if (code === 422) return modal.displayErrors(errors);
                    if (code === 200) Twal.ok("Contact updated", true);
                }
            });
        } else {
            Tyrax.post({
                url: "contact/add",
                req: raw,
                loading: { id: "ContactForm", size: 40 },
                res: (send, code, message, data, errors) =&gt; {
                    if (code === 422) return modal.displayErrors(errors);
                    if (code === 200) Twal.ok("Contact added", true);
                }
            });
        }
    });

    loadContacts();

============================================================
11. CONVENTIONS SUMMARY
============================================================

Folder ownership:
    app/       backend only
    views/     frontend only
    Never mix.

File naming:
    Controllers: lowercase or camelCase (get, getById, sendComment)
    Folders: single word or snake_case (user, inquiry_type)
    Pages: match the URL path
    Paired JS: same path as the page

Response shape (always):
    { code, message, data, errors }

Status codes (recommended):
    200  success
    400  malformed request
    401  unauthorized
    403  forbidden
    404  not found
    422  validation error
    429  rate limited
    500  server error

Session storage:
    Encrypted cookie called ctrx_user_data
    Set with Ctrx::set_user_data()
    Read with Ctrx::get_user_data() / has_user_data()

Named routes:
    Use as: "name" for any route the frontend calls
    Frontend calls by name, never by URL

============================================================
12. WHAT THIS GUIDE DOES NOT COVER
============================================================

If the user asks about any of these, ASK FOR THE SOURCE FILE
instead of guessing:

BaseTable methods beyond findOne / all / insert / update / delete:
    Possible additional methods the AI should not guess at:
        find(), first(), count(), exists()
        Chained queries, where clauses, joins

Request class beyond get_decrypt / headers:
    Possible additional methods the AI should not guess at:
        Request::segment(n)
        Request::method()
        Request::is_post() / is_get()
        Request::ip()

Response class beyond code / message / data / errors:
    Possible additional methods the AI should not guess at:
        Response::json()
        Response::header()
        Response::redirect()

Ctr and $$ beyond submit / click / get_attribute / reload:
    The mods/ folder has 30+ modules. The AI only knows the ones
    listed in section 6.

TextEditor beyond construction:
    ed.value, ed.clear() are mentioned but not fully documented.

FormValidator beyond displayErrors:
    Possible additional methods.

Url beyond get():
    Possible additional methods.

SQLite and DB classes:
    Used internally. The AI should not use them directly unless
    the user shows how.

Redis rate limiting configuration:
    Environment variables REDIS_HOST, REDIS_PORT, REDIS_PASSWORD,
    REDIS_DATABASE, REDIS_TIMEOUT. The AI knows these exist but not
    how to configure them.

Translation system:
    Ctrx::loadTranslations() exists but is not documented.

Cron system:
    Ctrx::getPastDueCronJobs() exists, and php cli run:cron exists.
    But the ctrx_cron table schema and the full cron workflow are
    not documented.

Frontend middleware:
    views/app/middleware/app.php is usually empty. The AI should
    not assume frontend middleware works like backend.

Advanced role filtering:
    ctrx_roles and ctrx_roles_access tables exist. The AI knows
    about role_filtering() and role_has_access() but not how the
    admin tools manage roles.

===========

If any of these come up, tell the user:

    "This isn't covered in the AI memory guide. Please share the
     source file for [class/method] so I can write accurate code
     against it."

Do not guess. Do not invent. Ask for the file.

End of memory guide.
</div> <h2 id="example-prompts">Example prompts to try</h2> <p>After pasting the memory guide, try any of these prompts:</p> <div class="code-block"> <button class="copy-btn" data-copy>Copy</button> <pre><code>Create a CRUD for a `contacts` table with: - name (required, max 255) - email (required, valid email, unique) - phone (optional, max 20)</code></pre>
            </div>
            <div class="code-block"> <button class="copy-btn" data-copy>Copy</button>
                <pre><code>Build a login page for a `members` table. Passwords are stored plaintext for now. Use a session duration of 7 days.</code></pre>
            </div>
            <div class="code-block"> <button class="copy-btn" data-copy>Copy</button>
                <pre><code>I want a dashboard page that shows the 5 most recent books with a delete button on each row. Only admins should see this page.</code></pre>
            </div>
            <div class="code-block"> <button class="copy-btn" data-copy>Copy</button>
                <pre><code>Explain how Request::get_decrypt() works and why CTRX uses encrypted IDs in URLs.</code></pre>
            </div>
            <h2 id="tips">Tips for good results</h2>
            <table class="docs-table">
                <thead>
                    <tr>
                        <th>Tip</th>
                        <th>Why</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Paste the memory guide first</td>
                        <td>The AI needs it to know CTRX exists</td>
                    </tr>
                    <tr>
                        <td>Describe tables and columns explicitly</td>
                        <td>Vague prompts lead to invented fields</td>
                    </tr>
                    <tr>
                        <td>Ask for one feature at a time</td>
                        <td>Smaller prompts produce cleaner code</td>
                    </tr>
                    <tr>
                        <td>Paste AI output into a real file and run it</td>
                        <td>AI writes code. Only your app runs it.</td>
                    </tr>
                    <tr>
                        <td>If something breaks, share the error and the file</td>
                        <td>The AI can debug with real context</td>
                    </tr>
                    <tr>
                        <td>Keep the memory message in the conversation</td>
                        <td>Longer chats drift. The memory anchors it.</td>
                    </tr>
                    <tr>
                        <td>If the AI asks for a source file, share it</td>
                        <td>The guide has gaps by design. Filling them is fine.</td>
                    </tr>
                </tbody>
            </table>
            <div class="callout warn">
                <p> <strong>AI assists, it doesn't replace understanding.</strong> The guide helps an AI produce correct CTRX code, but you still need to read the code, run it, and understand what it does. Ask the AI to explain what it wrote. </p>
            </div>
            <h2 id="changelog">Changelog</h2>
            <table class="docs-table">
                <thead>
                    <tr>
                        <th>Version</th>
                        <th>Changes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>2.0</code></td>
                        <td> Added global helpers appendix. Full CLI reference. Expanded Ctrx class methods. Added explicit "not covered" section. Added contacts worked example. Added frontend import path rules. </td>
                    </tr>
                    <tr>
                        <td><code>1.0</code></td>
                        <td> Initial release. Core backend and frontend patterns, CRUD example, session and auth. </td>
                    </tr>
                </tbody>
            </table>
            <nav class="docs-pager"> <a href="../tutorials/full-crud.html" class="prev"> <span class="pager-label">Previous</span> <span class="pager-title">Full CRUD</span> </a> <a href="../reference/faq.html" class="next"> <span class="pager-label">Next</span> <span class="pager-title">FAQ</span> </a> </nav>
        </main>
    </div>
    <footer class="docs-footer">
        <p> CTRX by <a href="#">Tyrone Malocon</a> · <a href="https://github.com/YroDevGit/ctrx">GitHub</a> · <a href="https://packagist.org/packages/yrodevgit/ctrx">Packagist</a> </p>
    </footer>
    <script src="<?= pagedir('docs/script.js') ?>"></script>
</body>

</html>