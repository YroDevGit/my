<?php // page: /tutorials/migrations ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Migrations — CTRX Documentation</title>
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
            <a href="migrations.html" class="active">Tutorials</a>
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
            <span>Migrations</span>
        </nav>

        <h1>Migrations</h1>
        <p class="lead">
            Migrations define your database tables in PHP. CTRX reads
            one file, creates every table it finds, and keeps existing
            tables in sync as you add columns. This tutorial walks
            through defining tables, running migrations, and updating
            schemas without losing data.
        </p>

        <div class="callout">
            <p>
                <strong>What you'll learn:</strong> how to define a table,
                how to add columns, how to change a column's type, and
                how to run the migration in development and in Docker.
            </p>
        </div>

        <h2 id="location">Where migrations live</h2>

        <p>
            Every table is defined in one file:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>app/config/migration.php</code></pre>
        </div>

        <p>
            There are no separate migration files, no timestamps, no
            up/down pairs. You describe the tables you want, and CTRX
            makes them match. Existing tables are updated to match the
            new definition, and data is preserved.
        </p>

        <h2 id="first-table">Your first table</h2>

        <p>
            Open <code>app/config/migration.php</code> and add a call to
            <code>Migration::table_ts()</code>:
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

        <p>Then run the migration:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> db:migrate</code></pre>
        </div>

        <p>CTRX creates the table and logs what it did:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Running Migration query....
✔️ Table `books` created successfully</code></pre>
        </div>

        <p>It also generates <code>app/base/Book.php</code> so you can
        query the table from any controller.</p>

        <h2 id="two-methods">Two ways to define a table</h2>

        <p>
            CTRX ships with two migration methods. They differ in whether
            the table gets automatic timestamp columns.
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Adds <code>created_at</code> / <code>updated_at</code></th>
                    <th>Adds <code>active</code></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>Migration::table()</code></td>
                    <td>No</td>
                    <td>Optional (third arg)</td>
                </tr>
                <tr>
                    <td><code>Migration::table_ts()</code></td>
                    <td>Yes</td>
                    <td>Optional (third arg)</td>
                </tr>
            </tbody>
        </table>

        <p>
            <code>_ts</code> stands for "timestamp". A table created with
            <code>table_ts()</code> automatically includes
            <code>created_at</code> and <code>updated_at</code> columns.
        </p>

        <p>
            Passing <code>true</code> as the third argument adds an
            <code>active</code> column with a default value of
            <code>1</code>:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Timestamps only</span>
Migration::<span class="fn">table_ts</span>(<span class="str">"logs"</span>, [
    <span class="str">"id"</span>      =&gt; PK,
    <span class="str">"message"</span> =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">800</span>],
]);

<span class="comment">// Timestamps + active column</span>
Migration::<span class="fn">table_ts</span>(<span class="str">"users"</span>, [
    <span class="str">"id"</span>    =&gt; PK,
    <span class="str">"email"</span> =&gt; VARCHAR,
], <span class="kw">true</span>);</code></pre>
        </div>

        <h2 id="column-types">Column types</h2>

        <p>
            Type constants are globally available. Use them directly
            inside the column array.
        </p>

        <table class="docs-table">
            <thead>
                <tr><th>Constant</th><th>SQL type</th><th>Use for</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>PK</code></td>
                    <td><code>BIGINT AUTO_INCREMENT PRIMARY KEY</code></td>
                    <td>Primary key</td>
                </tr>
                <tr>
                    <td><code>VARCHAR</code></td>
                    <td><code>VARCHAR(50)</code></td>
                    <td>Short text</td>
                </tr>
                <tr>
                    <td><code>INTEGER</code></td>
                    <td><code>INT(11)</code></td>
                    <td>Numbers, foreign keys</td>
                </tr>
                <tr>
                    <td><code>TEXT</code></td>
                    <td><code>TEXT</code></td>
                    <td>Long text</td>
                </tr>
                <tr>
                    <td><code>DATE</code></td>
                    <td><code>DATE</code></td>
                    <td>Date only</td>
                </tr>
                <tr>
                    <td><code>DATETIME</code></td>
                    <td><code>DATETIME</code></td>
                    <td>Date + time</td>
                </tr>
                <tr>
                    <td><code>DATE_TIMESTAMP</code></td>
                    <td><code>TIMESTAMP</code></td>
                    <td>Timestamp</td>
                </tr>
            </tbody>
        </table>

        <h3>Custom lengths</h3>

        <p>
            Wrap the type in an array to set length, default value, or
            other modifiers:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Migration::<span class="fn">table_ts</span>(<span class="str">"task"</span>, [
    <span class="str">"id"</span>          =&gt; PK,
    <span class="str">"title"</span>       =&gt; VARCHAR,
    <span class="str">"description"</span> =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">3000</span>],
    <span class="str">"remarks"</span>     =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">2000</span>],
    <span class="str">"status"</span>      =&gt; [<span class="str">"int"</span> =&gt; <span class="num">11</span>, <span class="str">"default"</span> =&gt; <span class="num">1</span>],
]);</code></pre>
        </div>

        <table class="docs-table">
            <thead>
                <tr><th>Key</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>varchar</code></td>
                    <td>Length of a VARCHAR column</td>
                </tr>
                <tr>
                    <td><code>int</code></td>
                    <td>Display width of an INT column</td>
                </tr>
                <tr>
                    <td><code>default</code></td>
                    <td>Default value for the column</td>
                </tr>
            </tbody>
        </table>

        <h3>Raw SQL types</h3>

        <p>
            For types not covered by constants, pass a raw string:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Migration::<span class="fn">table_ts</span>(<span class="str">"TaskRoute"</span>, [
    <span class="str">"id"</span>      =&gt; PK,
    <span class="str">"comment"</span> =&gt; <span class="str">"LONGTEXT"</span>,
    <span class="str">"image"</span>   =&gt; TEXT,
], <span class="kw">true</span>);</code></pre>
        </div>

        <h2 id="adding-columns">Adding columns to an existing table</h2>

        <p>
            This is where CTRX migrations differ from most frameworks.
            When you add a new column to the array, CTRX detects it and
            issues an <code>ALTER TABLE ADD COLUMN</code>. Existing rows
            get the column's default value. No data is lost.
        </p>

        <p>
            Start with the current definition:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Migration::<span class="fn">table_ts</span>(<span class="str">"books"</span>, [
    <span class="str">"id"</span>     =&gt; PK,
    <span class="str">"title"</span>  =&gt; VARCHAR,
    <span class="str">"author"</span> =&gt; VARCHAR,
], <span class="kw">true</span>);</code></pre>
        </div>

        <p>Add a new field to the array:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Migration::<span class="fn">table_ts</span>(<span class="str">"books"</span>, [
    <span class="str">"id"</span>     =&gt; PK,
    <span class="str">"title"</span>  =&gt; VARCHAR,
    <span class="str">"author"</span> =&gt; VARCHAR,
    <span class="str">"isbn"</span>   =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">20</span>],
], <span class="kw">true</span>);</code></pre>
        </div>

        <p>Run migrations again:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> db:migrate</code></pre>
        </div>

        <p>
            CTRX compares the current schema to the new definition,
            detects that <code>isbn</code> is missing, and adds it. The
            existing <code>title</code> and <code>author</code> rows are
            untouched.
        </p>

        <div class="callout">
            <p>
                <strong>You never write <code>ALTER TABLE</code>
                yourself.</strong> Add the column to the array, run the
                migration, and CTRX handles the SQL.
            </p>
        </div>

        <h2 id="changing-columns">Changing a column's type</h2>

        <p>
            If you change a column's definition, CTRX detects the
            difference and issues <code>ALTER TABLE MODIFY COLUMN</code>.
        </p>

        <p>For example, this column starts at <code>VARCHAR(500)</code>:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="str">"description"</span> =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">500</span>],</code></pre>
        </div>

        <p>Change it to <code>VARCHAR(2000)</code>:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="str">"description"</span> =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">2000</span>],</code></pre>
        </div>

        <p>
            Run <code>php cli db:migrate</code>. CTRX issues:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>ALTER TABLE `books` MODIFY COLUMN `description` VARCHAR(2000);</code></pre>
        </div>

        <div class="callout warn">
            <p>
                <strong>Shrinking a column can truncate data.</strong>
                Going from <code>VARCHAR(2000)</code> to
                <code>VARCHAR(500)</code> will cut off any string longer
                than 500 characters. CTRX does not warn you before doing
                this. Back up your data before shrinking.
            </p>
        </div>

        <h2 id="primary-keys">Primary keys</h2>

        <p>
            There are three ways to declare a primary key. All produce
            the same result.
        </p>

        <h3>Using the PK constant</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="str">"id"</span> =&gt; PK,</code></pre>
        </div>

        <h3>Using the @primary string</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="str">"id"</span> =&gt; <span class="str">"@primary"</span>,</code></pre>
        </div>

        <p>
            <code>@primary</code>, <code>@primarykey</code>,
            <code>@main</code>, and <code>@pk</code> are all aliases.
            Use whichever reads best.
        </p>

        <h3>Using the primary key flag</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="str">"id"</span> =&gt; [<span class="str">"int"</span> =&gt; <span class="num">20</span>, <span class="str">"primary key"</span>, <span class="str">"auto_increment"</span>, <span class="str">"not null"</span>],</code></pre>
        </div>

        <h2 id="running">Running migrations</h2>

        <h3>Local development</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> db:migrate</code></pre>
        </div>

        <h3>Inside Docker</h3>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">docker compose</span> exec app php cli db:migrate</code></pre>
        </div>

        <p>Or using the CLI passthrough:</p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="cmd">php cli</span> - db:migrate</code></pre>
        </div>

        <h3>What <code>db:migrate</code> actually does</h3>

        <ol>
            <li>Reads <code>database</code> from <code>.env</code></li>
            <li>Creates the database if it does not exist</li>
            <li>Includes <code>app/config/migration.php</code></li>
            <li>Runs every <code>Migration::table()</code> call</li>
            <li>Runs <code>tables sync</code> automatically to regenerate <code>app/base/*.php</code></li>
        </ol>

        <h2 id="safe-changes">What is safe and what is not</h2>

        <p>
            CTRX migrations are additive. Understanding what each
            change does helps you avoid accidents.
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Change</th>
                    <th>CTRX does</th>
                    <th>Data risk</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Add a new column</td>
                    <td><code>ALTER TABLE ADD COLUMN</code></td>
                    <td>None. Existing rows get the default</td>
                </tr>
                <tr>
                    <td>Change a column's length upward</td>
                    <td><code>ALTER TABLE MODIFY</code></td>
                    <td>None</td>
                </tr>
                <tr>
                    <td>Change a column's length downward</td>
                    <td><code>ALTER TABLE MODIFY</code></td>
                    <td>Values longer than the new length are truncated</td>
                </tr>
                <tr>
                    <td>Change a column's type</td>
                    <td><code>ALTER TABLE MODIFY</code></td>
                    <td>MySQL attempts conversion. May fail or lose data</td>
                </tr>
                <tr>
                    <td>Add a new table</td>
                    <td><code>CREATE TABLE</code></td>
                    <td>None. Existing tables are untouched</td>
                </tr>
                <tr>
                    <td>Remove a column from the array</td>
                    <td>Nothing</td>
                    <td>None. Column stays in the database</td>
                </tr>
                <tr>
                    <td>Remove a table from the file</td>
                    <td>Nothing</td>
                    <td>None. Table stays in the database</td>
                </tr>
            </tbody>
        </table>

        <div class="callout warn">
            <p>
                <strong>CTRX does not drop columns or tables.</strong>
                Removing them from <code>migration.php</code> makes CTRX
                ignore them. The database keeps them. If you need to
                drop a column, run <code>ALTER TABLE ... DROP COLUMN</code>
                manually. If you need to drop a table, use
                <code>DROP TABLE</code> manually.
            </p>
        </div>

        <h2 id="full-example">Full example</h2>

        <p>
            A small library app with three tables, showing every
            pattern you will use.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="php-tag">&lt;?php</span>
<span class="kw">use</span> Classes\Migration;

<span class="comment">// System table, no timestamps</span>
Migration::<span class="fn">table</span>(<span class="str">"logs"</span>, [
    <span class="str">"id"</span>      =&gt; <span class="str">"@primary"</span>,
    <span class="str">"message"</span> =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">800</span>],
    <span class="str">"status"</span>  =&gt; [<span class="str">"int"</span> =&gt; <span class="num">11</span>, <span class="str">"default"</span> =&gt; <span class="num">1</span>],
]);

<span class="comment">// Books, timestamps + active</span>
Migration::<span class="fn">table_ts</span>(<span class="str">"books"</span>, [
    <span class="str">"id"</span>       =&gt; PK,
    <span class="str">"title"</span>    =&gt; VARCHAR,
    <span class="str">"author"</span>   =&gt; VARCHAR,
    <span class="str">"isbn"</span>     =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">20</span>],
    <span class="str">"rating"</span>   =&gt; INTEGER,
    <span class="str">"notes"</span>    =&gt; [<span class="str">"varchar"</span> =&gt; <span class="num">1000</span>],
], <span class="kw">true</span>);

<span class="comment">// Members, timestamps + active</span>
Migration::<span class="fn">table_ts</span>(<span class="str">"members"</span>, [
    <span class="str">"id"</span>       =&gt; PK,
    <span class="str">"email"</span>    =&gt; VARCHAR,
    <span class="str">"password"</span> =&gt; VARCHAR,
    <span class="str">"name"</span>     =&gt; VARCHAR,
], <span class="kw">true</span>);

<span class="comment">// Loans, timestamps only</span>
Migration::<span class="fn">table_ts</span>(<span class="str">"loans"</span>, [
    <span class="str">"id"</span>       =&gt; PK,
    <span class="str">"book_id"</span>  =&gt; INTEGER,
    <span class="str">"user_id"</span>  =&gt; INTEGER,
    <span class="str">"due_date"</span> =&gt; DATE,
]);</code></pre>
        </div>

        <p>
            Run <code>php cli db:migrate</code>. Four tables are created,
            four model classes appear in <code>app/base/</code>, and the
            database is ready for your app.
        </p>

        <h2 id="checklist">Checklist</h2>

        <table class="docs-table">
            <thead>
                <tr><th>✓</th><th>Check</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>☐</td>
                    <td>Every new table is added to <code>app/config/migration.php</code></td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>The <code>database</code> key in <code>.env</code> is set</td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>Migration runs without errors: <code>php cli db:migrate</code></td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>Models are generated in <code>app/base/</code></td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>Tables are visible in your database client</td>
                </tr>
                <tr>
                    <td>☐</td>
                    <td>If you changed a column type, you backed up data first</td>
                </tr>
            </tbody>
        </table>

        <nav class="docs-pager">
            <a href="full-crud.html" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">Full CRUD</span>
            </a>
            <a href="login-flow.html" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">Login Flow</span>
            </a>
        </nav>

    </main>

</div>

<footer class="docs-footer">
    <p>
        CTRX by <a href="#">Tyrone Malocon</a>
        · <a href="https://github.com/YroDevGit/ctrx">GitHub</a>
        · <a href="https://packagist.org/packages/yrodevgit/ctrx">Packagist</a>
    </p>
</footer>

<script src="<?=pagedir('js/script.js')?>"></script>
</body>
</html>