<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Session &amp; Auth — CTRX Documentation</title>
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
            <a href="../tutorials/insert-to-table.html">Tutorials</a>
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
            <a href="#">Backend</a>
            <span>/</span>
            <span>Session &amp; Auth</span>
        </nav>

        <h1>Session &amp; Auth</h1>
        <p class="lead">
            CTRX stores the current user in an encrypted cookie called
            <code>ctrx_user_data</code>. Setting it is one call,
            checking it is another. This page covers the full session
            API, how to protect routes with middleware, and how roles
            drive navigation.
        </p>

        <h2 id="how-it-works">How session works</h2>

        <p>
            CTRX doesn't use PHP's native <code>$_SESSION</code> for
            authentication. Instead, it stores user data in an
            <strong>encrypted cookie</strong> named
            <code>ctrx_user_data</code>. This gives you:
        </p>

        <ul>
            <li>Session persistence across server restarts</li>
            <li>No session files to clean up</li>
            <li>Built-in encryption — the cookie value can't be read by the client</li>
            <li>Works across multiple servers without shared storage</li>
        </ul>

        <p>
            You never touch the cookie directly. Every read and write
            goes through static methods on <code>Ctrx</code>.
        </p>

        <h2 id="session-api">The session API</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Ctrx::set_user_data([...])</code></td>
                    <td>Store user data</td>
                </tr>
                <tr>
                    <td><code>Ctrx::get_user_data()</code></td>
                    <td>Read all user data</td>
                </tr>
                <tr>
                    <td><code>Ctrx::get_user_data("id")</code></td>
                    <td>Read one field</td>
                </tr>
                <tr>
                    <td><code>Ctrx::has_user_data()</code></td>
                    <td>Is anyone logged in?</td>
                </tr>
                <tr>
                    <td><code>Ctrx::extend_user_data($mins)</code></td>
                    <td>Extend the session's lifetime</td>
                </tr>
                <tr>
                    <td><code>Ctrx::delete_user_data()</code></td>
                    <td>Clear the session</td>
                </tr>
                <tr>
                    <td><code>Ctrx::reset_all_user_data()</code></td>
                    <td>Clear session + logged-in flag</td>
                </tr>
                <tr>
                    <td><code>Ctrx::set_user_role("AD")</code></td>
                    <td>Set the current role</td>
                </tr>
                <tr>
                    <td><code>Ctrx::get_user_role()</code></td>
                    <td>Read the current role</td>
                </tr>
                <tr>
                    <td><code>Ctrx::has_user_roles("AD", "SA")</code></td>
                    <td>Check if role is one of these</td>
                </tr>
            </tbody>
        </table>

        <h2 id="logging-in">Logging a user in</h2>

        <p>
            After verifying credentials, call <code>set_user_data()</code>
            with whatever fields your app needs, then
            <code>set_user_role()</code> with the role code:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: auth/login</span>

<span class="kw">use</span> Classes\Ctrx;
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Members;

<span class="comment">// 1. Validate</span>
$email    = Validator::<span class="fn">post</span>(<span class="str">"email"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">email</span>()-&gt;<span class="fn">exec</span>();
$password = Validator::<span class="fn">post</span>(<span class="str">"password"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">exec</span>();

<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

<span class="comment">// 2. Find and check the user</span>
$member = Members::<span class="fn">findOne</span>([<span class="str">"email"</span> =&gt; $email]);

<span class="kw">if</span> (! $member) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid credentials"</span>)-&gt;<span class="fn">send</span>();
}

<span class="kw">if</span> ($member[<span class="str">'active'</span>] == <span class="num">0</span>) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Account disabled"</span>)-&gt;<span class="fn">send</span>();
}

<span class="kw">if</span> ($password !== $member[<span class="str">'password'</span>]) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Incorrect password"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// 3. Store the session</span>
Ctrx::<span class="fn">set_user_data</span>([
    <span class="str">"id"</span>    =&gt; $member[<span class="str">'id'</span>],
    <span class="str">"email"</span> =&gt; $member[<span class="str">'email'</span>],
    <span class="str">"name"</span>  =&gt; $member[<span class="str">'name'</span>],
], <span class="num">1440</span>);   <span class="comment">// 1440 minutes = 24 hours (default)</span>

Ctrx::<span class="fn">set_user_role</span>(<span class="str">"AD"</span>);

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"Logged in"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <h3>Session duration</h3>

        <p>
            <code>set_user_data($data, $duration)</code> takes a duration
            in minutes. The default is <strong>1440</strong> (24 hours).
            Pass a shorter or longer value depending on your app:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Ctrx::<span class="fn">set_user_data</span>($data);        <span class="comment">// 24 hours</span>
Ctrx::<span class="fn">set_user_data</span>($data, <span class="num">60</span>);    <span class="comment">// 1 hour</span>
Ctrx::<span class="fn">set_user_data</span>($data, <span class="num">10080</span>); <span class="comment">// 7 days</span></code></pre>
        </div>

        <div class="callout">
            <p>
                <strong>Important:</strong> call
                <code>set_user_data()</code> <em>before</em>
                <code>set_user_role()</code>. The role is stored inside
                the user data cookie, so the data must exist first.
            </p>
        </div>

        <h2 id="checking-session">Checking the session</h2>

        <h3>Is anyone logged in?</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">use</span> Classes\Ctrx;

<span class="kw">if</span> (Ctrx::<span class="fn">has_user_data</span>()) {
    <span class="comment">// someone is logged in</span>
} <span class="kw">else</span> {
    <span class="comment">// guest</span>
}</code></pre>
        </div>

        <h3>Reading the user</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Everything at once</span>
$user = Ctrx::<span class="fn">get_user_data</span>();
<span class="comment">// ["id" =&gt; 7, "email" =&gt; "...", "name" =&gt; "..."]</span>

<span class="comment">// One field</span>
$id    = Ctrx::<span class="fn">get_user_data</span>(<span class="str">"id"</span>);
$email = Ctrx::<span class="fn">get_user_data</span>(<span class="str">"email"</span>);</code></pre>
        </div>

        <h3>Reading the role</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>$role = Ctrx::<span class="fn">get_user_role</span>();   <span class="comment">// "AD", "SA", "US", etc.</span>

<span class="kw">if</span> (Ctrx::<span class="fn">has_user_roles</span>(<span class="str">"AD"</span>, <span class="str">"SA"</span>)) {
    <span class="comment">// user is admin or super admin</span>
}</code></pre>
        </div>

        <h2 id="middleware">Protecting routes</h2>

        <p>
            Rather than checking <code>has_user_data()</code> in every
            controller, use a <strong>middleware</strong>. It runs
            before the controller and stops the request if the user
            isn't authenticated.
        </p>

        <h3>1. Create the middleware</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> +middleware auth</code></pre>
        </div>

        <p>This creates <code>app/middleware/auth.php</code>:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// app/middleware/auth.php</span>

<span class="kw">use</span> Classes\Ctrx;
<span class="kw">use</span> Classes\Response;

<span class="kw">if</span> (! Ctrx::<span class="fn">has_user_data</span>()) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)
        -&gt;<span class="fn">message</span>(<span class="str">"Unauthorized"</span>)
        -&gt;<span class="fn">send</span>();
}</code></pre>
        </div>

        <h3>2. Attach it to a route group</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// app/_routes/api.php</span>

Router::<span class="fn">group</span>(
    <span class="fn">makeRoute</span>(method: <span class="str">"get"</span>,  controller: <span class="str">"book/get"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"post"</span>, controller: <span class="str">"book/add"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"put"</span>,  controller: <span class="str">"book/update"</span>),
    <span class="fn">makeRoute</span>(method: <span class="str">"delete"</span>, controller: <span class="str">"book/delete"</span>)
)-&gt;<span class="fn">middleware</span>(<span class="str">"auth"</span>);</code></pre>
        </div>

        <p>
            Every route in that group now requires a logged-in user.
            No controller-level checks needed.
        </p>

        <h2 id="roles">Roles</h2>

        <p>
            A role is a short string stored alongside the user data. CTRX
            doesn't ship with a fixed role list — you define whatever
            codes make sense for your app.
        </p>

        <h3>Setting a role</h3>

        <p>
            If your <code>members</code> table has a <code>type</code>
            column, map it to a role code during login:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>$roleMap = [
    <span class="num">1</span> =&gt; <span class="str">"SA"</span>,
    <span class="num">2</span> =&gt; <span class="str">"AD"</span>,
    <span class="num">3</span> =&gt; <span class="str">"MG"</span>,
    <span class="num">4</span> =&gt; <span class="str">"US"</span>,
];

$role = $roleMap[$member[<span class="str">'type'</span>]] ?? <span class="str">"US"</span>;

Ctrx::<span class="fn">set_user_data</span>([
    <span class="str">"id"</span>    =&gt; $member[<span class="str">'id'</span>],
    <span class="str">"email"</span> =&gt; $member[<span class="str">'email'</span>],
]);

Ctrx::<span class="fn">set_user_role</span>($role);</code></pre>
        </div>

        <h3>Checking a role in a controller</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: book/delete</span>

<span class="kw">use</span> Classes\Ctrx;
<span class="kw">use</span> Classes\Response;

<span class="comment">// Admins and super admins only</span>
<span class="kw">if</span> (! Ctrx::<span class="fn">has_user_roles</span>(<span class="str">"AD"</span>, <span class="str">"SA"</span>)) {
    Response::<span class="fn">code</span>(<span class="num">403</span>)-&gt;<span class="fn">message</span>(<span class="str">"Admins only"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// Continue with business logic</span>
<span class="comment">// ...</span></code></pre>
        </div>

        <h2 id="frontend-guards">Frontend guards</h2>

        <p>
            The frontend also needs session checks — one for pages that
            require login, one for pages that should only be seen by
            guests. Both live in
            <code>views/app/routes/web.php</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span>
<span class="kw">use</span> Classes\Ctrx;
<span class="kw">use</span> Classes\Routing;

Ctrx::<span class="fn">role_filtering</span>();   <span class="comment">// global role check</span>

<span class="comment">// Guest-only: logged-in users get redirected</span>
Routing::<span class="fn">group_page</span>(<span class="str">"user/login"</span>, <span class="kw">function</span> () {
    <span class="kw">if</span> (Ctrx::<span class="fn">has_user_data</span>()) {
        <span class="fn">redirect</span>(<span class="str">"/auth/dashboard"</span>);
    }
});

<span class="comment">// Auth-required: guests get logged out</span>
Routing::<span class="fn">group_page</span>(<span class="str">"auth/*"</span>, <span class="kw">function</span> () {
    <span class="fn">js</span>(<span class="str">"_auth/all"</span>);
    <span class="kw">if</span> (! Ctrx::<span class="fn">has_user_data</span>()) {
        <span class="fn">redirect_logout</span>();
    }
});</code></pre>
        </div>

        <p>
            Two guards, two behaviors:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Guard</th>
                    <th>Behavior</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>user/login</code> (guest)</td>
                    <td>
                        If the user is logged in, redirect them to the
                        dashboard
                    </td>
                </tr>
                <tr>
                    <td><code>auth/*</code> (protected)</td>
                    <td>
                        If the user isn't logged in, log them out and
                        send them to the login page
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 id="role-filtering">Role filtering</h2>

        <p>
            <code>Ctrx::role_filtering()</code> runs on every frontend
            request. It reads the current user's role from the session,
            looks up which pages that role is allowed to see, and either
            allows the request or shows a forbidden / unauthorized page.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// views/app/routes/web.php</span>
Ctrx::<span class="fn">role_filtering</span>();   <span class="comment">// runs on every request</span></code></pre>
        </div>

        <p>
            Role access is stored in two SQLite tables — <code>ctrx_roles</code>
            and <code>ctrx_roles_access</code> — which are managed from the
            CTRX admin tools (<code>php cli use:roles</code> or similar).
            Once a role has been granted or denied access to a route,
            <code>role_filtering()</code> enforces it automatically.
        </p>

        <p>
            If you want to check access manually — for a single route,
            without triggering a redirect — use:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">if</span> (Ctrx::<span class="fn">role_has_access</span>(<span class="str">"auth/dashboard"</span>)) {
    <span class="comment">// allowed</span>
}</code></pre>
        </div>

        <h2 id="extending">Extending the session</h2>

        <p>
            If your app has a "keep me logged in" or activity-based
            timeout, you can refresh the session without re-authenticating:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Extend by another 24 hours</span>
Ctrx::<span class="fn">extend_user_data</span>(<span class="num">1440</span>);</code></pre>
        </div>

        <p>
            This re-issues the cookie with the same data but a new
            expiry. Useful on a heartbeat endpoint or after a
            user-triggered action.
        </p>

        <h2 id="logout">Logging out</h2>

        <p>
            Clear the session with <code>delete_user_data()</code> or
            <code>reset_all_user_data()</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: auth/logout</span>

<span class="kw">use</span> Classes\Ctrx;
<span class="kw">use</span> Classes\Response;

Ctrx::<span class="fn">reset_all_user_data</span>();   <span class="comment">// clears session + logged-in flag</span>

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"Logged out"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <p>
            From the frontend, <code>redirect_logout()</code> sends the
            user to the login page after the API call completes:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Tyrax.<span class="fn">post</span>({
    url: <span class="str">"auth/logout"</span>,
    res: (send, code) <span class="kw">=&gt;</span> {
        <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) {
            window.<span class="fn">location</span>.href = <span class="str">"/user/login"</span>;
        }
    }
});</code></pre>
        </div>

        <h2 id="logging-in-flag">The logged-in flag</h2>

        <p>
            CTRX keeps a separate lightweight cookie called
            <code>ctrx_logged_in</code> for quick "is this user logged in"
            checks that don't need to decrypt the full session:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Ctrx::<span class="fn">set_logged_in</span>(<span class="kw">true</span>, <span class="num">1440</span>);   <span class="comment">// mark as logged in</span>
Ctrx::<span class="fn">set_logged_in</span>(<span class="kw">false</span>);        <span class="comment">// clear the flag</span>
Ctrx::<span class="fn">is_logged_in</span>();                <span class="comment">// check the flag</span></code></pre>
        </div>

        <p>
            This is mostly useful when you want to show different UI
            (e.g. "Sign in" vs "My account" in the header) without
            decrypting the full session on every request. The full
            session — <code>has_user_data()</code> — is still the
            source of truth for authorization.
        </p>

        <h2 id="full-example">Full login controller</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span> <span class="comment">// route: auth/login</span>

<span class="kw">use</span> Classes\Ctrx;
<span class="kw">use</span> Classes\Response;
<span class="kw">use</span> Classes\Validator;
<span class="kw">use</span> Tables\Members;

<span class="comment">// 1. Validate input</span>
$email    = Validator::<span class="fn">post</span>(<span class="str">"email"</span>)-&gt;<span class="fn">label</span>(<span class="str">"Email"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">email</span>()-&gt;<span class="fn">exec</span>();
$password = Validator::<span class="fn">post</span>(<span class="str">"password"</span>)-&gt;<span class="fn">label</span>(<span class="str">"Password"</span>)-&gt;<span class="fn">required</span>()-&gt;<span class="fn">exec</span>();

<span class="kw">if</span> ($errors = Validator::<span class="fn">errors</span>()) {
    Response::<span class="fn">code</span>(<span class="num">422</span>)-&gt;<span class="fn">errors</span>($errors)-&gt;<span class="fn">send</span>();
}

<span class="comment">// 2. Find user</span>
$member = Members::<span class="fn">findOne</span>([<span class="str">"email"</span> =&gt; $email]);

<span class="kw">if</span> (! $member) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Invalid credentials"</span>)-&gt;<span class="fn">send</span>();
}

<span class="kw">if</span> ($member[<span class="str">'active'</span>] == <span class="num">0</span>) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Account disabled"</span>)-&gt;<span class="fn">send</span>();
}

<span class="kw">if</span> ($password !== $member[<span class="str">'password'</span>]) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Incorrect password"</span>)-&gt;<span class="fn">send</span>();
}

<span class="comment">// 3. Store session data first, then the role</span>
Ctrx::<span class="fn">set_user_data</span>([
    <span class="str">"id"</span>    =&gt; $member[<span class="str">'id'</span>],
    <span class="str">"email"</span> =&gt; $member[<span class="str">'email'</span>],
    <span class="str">"name"</span>  =&gt; $member[<span class="str">'name'</span>],
]);

$roleMap = [<span class="num">1</span> =&gt; <span class="str">"SA"</span>, <span class="num">2</span> =&gt; <span class="str">"AD"</span>, <span class="num">3</span> =&gt; <span class="str">"MG"</span>, <span class="num">4</span> =&gt; <span class="str">"US"</span>];
Ctrx::<span class="fn">set_user_role</span>($roleMap[$member[<span class="str">'type'</span>]] ?? <span class="str">"US"</span>);

Ctrx::<span class="fn">set_logged_in</span>(<span class="kw">true</span>, <span class="num">1440</span>);

Response::<span class="fn">code</span>(<span class="num">200</span>)-&gt;<span class="fn">message</span>(<span class="str">"Logged in"</span>)-&gt;<span class="fn">send</span>();</code></pre>
        </div>

        <h2 id="quick-reference">Quick reference</h2>

        <h3>Session data</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Ctrx::<span class="fn">set_user_data</span>([...], $minutes = <span class="num">1440</span>)
Ctrx::<span class="fn">get_user_data</span>()           <span class="comment">// all fields</span>
Ctrx::<span class="fn">get_user_data</span>(<span class="str">"id"</span>)       <span class="comment">// one field</span>
Ctrx::<span class="fn">has_user_data</span>()
Ctrx::<span class="fn">extend_user_data</span>($minutes)
Ctrx::<span class="fn">delete_user_data</span>()
Ctrx::<span class="fn">reset_all_user_data</span>()</code></pre>
        </div>

        <h3>Roles</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Ctrx::<span class="fn">set_user_role</span>(<span class="str">"AD"</span>)
Ctrx::<span class="fn">get_user_role</span>()
Ctrx::<span class="fn">has_user_roles</span>(<span class="str">"AD"</span>, <span class="str">"SA"</span>)
Ctrx::<span class="fn">role_filtering</span>()
Ctrx::<span class="fn">role_has_access</span>(<span class="str">"auth/dashboard"</span>)</code></pre>
        </div>

        <h3>Logged-in flag</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Ctrx::<span class="fn">set_logged_in</span>(<span class="kw">true</span>, <span class="num">1440</span>)
Ctrx::<span class="fn">set_logged_in</span>(<span class="kw">false</span>)
Ctrx::<span class="fn">is_logged_in</span>()</code></pre>
        </div>

        <h3>Middleware</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Create: php cli +middleware auth</span>
<span class="comment">// Attach: -&gt;middleware("auth")</span>

<span class="comment">// Inside app/middleware/auth.php:</span>
<span class="kw">if</span> (! Ctrx::<span class="fn">has_user_data</span>()) {
    Response::<span class="fn">code</span>(<span class="num">401</span>)-&gt;<span class="fn">message</span>(<span class="str">"Unauthorized"</span>)-&gt;<span class="fn">send</span>();
}</code></pre>
        </div>

        <nav class="docs-pager">
            <a href="middleware.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← Middleware</span>
            </a>
            <a href="cli.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">CLI →</span>
            </a>
        </nav>

    </main>

</div>

<footer class="docs-footer">
    <p>
        CTRX — Codetazer-X Framework by <a href="#">Tyrone Malocon</a>
        · <a href="https://github.com/YroDevGit/ctrx">GitHub</a>
        · <a href="https://packagist.org/packages/yrodevgit/ctrx">Packagist</a>
    </p>
</footer>

<script src="<?=pagedir('docs/script.js')?>"></script>
<script src="<?=pagedir('js/script.js')?>"></script>
</body>
</html>