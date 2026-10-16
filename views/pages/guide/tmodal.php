<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>TModal. CTRX Documentation</title>
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
            <span>TModal</span>
        </nav>

        <h1>TModal</h1>
        <p class="lead">
            TModal is CTRX's declarative form-modal library. Instead of
            writing HTML for every form, you describe the fields in JS.
            TModal builds the modal, wires the inputs, handles
            validation display, and calls your submit handler.
        </p>

        <h2 id="import">Import</h2>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">import</span> TModal <span class="kw">from</span> <span class="str">"../../code/src/mods/modals/tmodal.js"</span>;</code></pre>
        </div>

        <h2 id="quick-start">Quick start</h2>

        <p>
            A modal form in four steps:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// 1. Build the modal with a field schema</span>
<span class="kw">let</span> modal_x = TModal.<span class="fn">init</span>({
    id: <span class="str">"AddTask"</span>,
    title: <span class="str">"Add new task"</span>,
    form_id: <span class="str">"AddTaskForm"</span>,
    form: {
        title:    { type: <span class="str">"text"</span>,     label: <span class="str">"Title:"</span> },
        prio:     { type: <span class="str">"select"</span>,   label: <span class="str">"Priority:"</span>, options: [
            { value: <span class="num">1</span>, label: <span class="str">"Low"</span> },
            { value: <span class="num">2</span>, label: <span class="str">"Medium"</span> },
            { value: <span class="num">3</span>, label: <span class="str">"High"</span> }
        ]},
        deadline: { type: <span class="str">"calendar"</span>, label: <span class="str">"Deadline:"</span> },
        remarks:  { type: <span class="str">"textarea"</span>, label: <span class="str">"Remarks:"</span> }
    }
});

<span class="comment">// 2. Open it when a button is clicked</span>
Ctr.<span class="fn">click</span>(<span class="str">".addtaskbtn"</span>, () <span class="kw">=&gt;</span> modal_x.openNew);

<span class="comment">// 3. Handle the submit</span>
modal_x.<span class="fn">form_submit</span>((data, raw) <span class="kw">=&gt;</span> {
    Tyrax.<span class="fn">post</span>({
        url: <span class="str">"task/add"</span>,
        req: raw,
        res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) modal_x.<span class="fn">displayErrors</span>(errors);
            <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) Twal.<span class="fn">ok</span>(<span class="str">"Task added"</span>, <span class="kw">true</span>);
        }
    });
});</code></pre>
        </div>

        <p>
            No HTML form. No manual DOM wiring. The modal builds itself
            from your schema, and validation errors are displayed with a
            single call.
        </p>

        <h2 id="init-options">TModal.init() options</h2>

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
                    <td><code>id</code></td>
                    <td>string</td>
                    <td>Unique ID for the modal</td>
                </tr>
                <tr>
                    <td><code>title</code></td>
                    <td>string</td>
                    <td>Modal heading</td>
                </tr>
                <tr>
                    <td><code>form_id</code></td>
                    <td>string</td>
                    <td>ID given to the internal form element</td>
                </tr>
                <tr>
                    <td><code>form</code></td>
                    <td>object</td>
                    <td>Field schema (see below)</td>
                </tr>
            </tbody>
        </table>

        <h2 id="field-types">Field types</h2>

        <p>
            Each key in the <code>form</code> object becomes a field. The
            value describes its type, label, and behavior.
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Renders</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>text</code></td>
                    <td>Single-line text input</td>
                </tr>
                <tr>
                    <td><code>textarea</code></td>
                    <td>Multi-line text input</td>
                </tr>
                <tr>
                    <td><code>select</code></td>
                    <td>Dropdown</td>
                </tr>
                <tr>
                    <td><code>calendar</code></td>
                    <td>Date picker</td>
                </tr>
                <tr>
                    <td><code>imagepicker</code></td>
                    <td>Image upload / picker</td>
                </tr>
            </tbody>
        </table>

        <h2 id="field-config">Field configuration</h2>

        <p>
            Every field accepts at least <code>type</code> and
            <code>label</code>. Some types support additional
            <code>config</code> options.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>form: {
    <span class="comment">// Simple text field</span>
    title: { type: <span class="str">"text"</span>, label: <span class="str">"Title:"</span> },

    <span class="comment">// Multi-line</span>
    description: { type: <span class="str">"textarea"</span>, label: <span class="str">"Description:"</span> },

    <span class="comment">// Static option list</span>
    prio: {
        type: <span class="str">"select"</span>,
        label: <span class="str">"Priority:"</span>,
        options: [
            { value: <span class="num">1</span>, label: <span class="str">"Low"</span> },
            { value: <span class="num">2</span>, label: <span class="str">"Medium"</span> },
            { value: <span class="num">3</span>, label: <span class="str">"High"</span> }
        ]
    },

    <span class="comment">// Options from a data source (key/value mapping)</span>
    assign: {
        type: <span class="str">"select"</span>,
        label: <span class="str">"Assign to:"</span>,
        options: assignees,   <span class="comment">// array of objects</span>
        config: { value: <span class="str">"id"</span>, label: <span class="str">"fullname"</span> }
    },

    <span class="comment">// Date picker</span>
    deadline: { type: <span class="str">"calendar"</span>, label: <span class="str">"Deadline:"</span> },

    <span class="comment">// Image upload (multiple files, custom directory)</span>
    img: {
        type: <span class="str">"imagepicker"</span>,
        label: <span class="str">"Images:"</span>,
        config: { dir: <span class="str">"task"</span>, multiple: <span class="kw">true</span> }
    },

    <span class="comment">// Longer remarks</span>
    remarks: { type: <span class="str">"textarea"</span>, label: <span class="str">"Remarks:"</span> }
}</code></pre>
        </div>

        <h3>Options format</h3>

        <p>
            The <code>options</code> array can be either:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Form</th>
                    <th>Example</th>
                    <th>When to use</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Static array</td>
                    <td><code>[{value: 1, label: "Low"}]</code></td>
                    <td>Fixed list of choices</td>
                </tr>
                <tr>
                    <td>Data array + config</td>
                    <td><code>options: assignees, config: {value: "id", label: "fullname"}</code></td>
                    <td>List from a backend query</td>
                </tr>
            </tbody>
        </table>

        <p>
            When you pass a data array, <code>config.value</code> tells
            TModal which property to use as the option's value, and
            <code>config.label</code> tells it which property to display.
        </p>

        <h2 id="modal-methods">Modal methods</h2>

        <p>
            The <code>init()</code> call returns a modal instance with
            these methods:
        </p>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Method / Property</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>modal_x.openNew</code></td>
                    <td>Open the modal in "new record" mode</td>
                </tr>
                <tr>
                    <td><code>modal_x.edit(data, id, title)</code></td>
                    <td>Open with pre-filled data and an edit context</td>
                </tr>
                <tr>
                    <td><code>modal_x.form_submit(callback)</code></td>
                    <td>Bind a submit handler <code>(data, raw) =&gt; {}</code></td>
                </tr>
                <tr>
                    <td><code>modal_x.getMeta()</code></td>
                    <td>Get the current mode's ID (truthy in edit, falsy in new)</td>
                </tr>
                <tr>
                    <td><code>modal_x.displayErrors(errors)</code></td>
                    <td>Paint server-side validation errors onto the fields</td>
                </tr>
            </tbody>
        </table>

        <h2 id="edit-mode">Edit mode</h2>

        <p>
            The same modal handles both <strong>create</strong> and
            <strong>update</strong>. The pattern is:
        </p>

        <ol>
            <li>
                Bind a click handler to the edit button
            </li>
            <li>
                Fetch the record from the API
            </li>
            <li>
                Call <code>modal_x.edit(data, id, "Edit task")</code> with
                the returned data
            </li>
            <li>
                In your submit handler, check
                <code>modal_x.getMeta()</code>. if truthy, it's an
                update; otherwise it's a create
            </li>
        </ol>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Bind the edit button</span>
$$.<span class="fn">click</span>(<span class="str">".edittask"</span>, <span class="kw">function</span> (btn) {
    <span class="kw">let</span> id = $$.<span class="fn">get_attribute</span>(btn, <span class="str">"task-id"</span>);

    Tyrax.<span class="fn">get</span>({
        url: <span class="str">"task/getById"</span>,
        params: { id: id },
        loading: <span class="kw">true</span>,
        res: (send, code, message, data) <span class="kw">=&gt;</span> {
            <span class="kw">if</span> (code <span class="op">!==</span> <span class="num">200</span>) {
                Twal.<span class="fn">err</span>(message);
                <span class="kw">return</span>;
            }
            modal_x.<span class="fn">edit</span>(data, id, <span class="str">"Edit task"</span>);
        }
    });
});

<span class="comment">// One submit handler for both modes</span>
modal_x.<span class="fn">form_submit</span>(<span class="kw">function</span> (data, raw) {
    <span class="kw">if</span> (modal_x.<span class="fn">getMeta</span>()) {
        <span class="comment">// EDIT mode</span>
        Tyrax.<span class="fn">put</span>({
            url: <span class="str">"task/update"</span>,
            params: { id: modal_x.<span class="fn">getMeta</span>() },
            data: raw,
            loading: { id: <span class="str">"AddTaskForm"</span>, size: <span class="num">40</span> },
            res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) { modal_x.<span class="fn">displayErrors</span>(errors); <span class="kw">return</span>; }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">421</span>) { Twal.<span class="fn">err</span>(message); <span class="kw">return</span>; }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) { Twal.<span class="fn">ok</span>(<span class="str">"Task details updated"</span>, <span class="kw">true</span>); }
            }
        });
    } <span class="kw">else</span> {
        <span class="comment">// CREATE mode</span>
        Tyrax.<span class="fn">post</span>({
            url: <span class="str">"task/add"</span>,
            req: raw,
            params: { id: Url.<span class="fn">get</span>(<span class="str">"q"</span>) },
            loading: { id: <span class="str">"AddTaskForm"</span>, size: <span class="num">40</span> },
            res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) { modal_x.<span class="fn">displayErrors</span>(errors); <span class="kw">return</span>; }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">401</span>) { Twal.<span class="fn">err</span>(message); <span class="kw">return</span>; }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) { Twal.<span class="fn">ok</span>(<span class="str">"New task added"</span>, <span class="kw">true</span>); }
            }
        });
    }
});</code></pre>
        </div>

        <p>
            <code>modal_x.getMeta()</code> is the switch. It returns
            whatever was passed as the ID when <code>.edit()</code> was
            called. or <code>undefined</code> in new mode.
        </p>

        <div class="callout">
            <p>
                <strong>One modal, two operations.</strong> You don't need
                separate modals for "add" and "edit." The same
                <code>init()</code> config serves both. This is why
                TModal pairs so well with the CRUD pattern.
            </p>
        </div>

        <h2 id="submit-callback">The submit callback</h2>

        <p>
            <code>modal_x.form_submit(callback)</code> receives two
            arguments, just like <code>Ctr.submit</code>:
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
                    <td><code>data</code></td>
                    <td>FormData</td>
                    <td>Native FormData object. use for file uploads</td>
                </tr>
                <tr>
                    <td><code>raw</code></td>
                    <td>Object</td>
                    <td>Serialized plain object. use for JSON APIs</td>
                </tr>
            </tbody>
        </table>

        <p>
            For most API calls, use <code>raw</code>. Pass it to
            TYRAX as <code>req</code> or <code>data</code> and the
            modal's values are sent as JSON.
        </p>

        <h2 id="validation-errors">Displaying validation errors</h2>

        <p>
            When the server responds with <code>code: 422</code> and an
            <code>errors</code> object, call:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>modal_x.<span class="fn">displayErrors</span>(errors);</code></pre>
        </div>

        <p>
            This paints each error message directly under the matching
            field. The keys in <code>errors</code> must match the field
            names in your <code>form</code> schema:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="comment">// Server returns:</span>
{
    <span class="str">"code"</span>: <span class="num">422</span>,
    <span class="str">"errors"</span>: {
        <span class="str">"title"</span>: <span class="str">"Title is required"</span>,
        <span class="str">"description"</span>: <span class="str">"Description must be at least 50 characters"</span>,
        <span class="str">"prio"</span>: <span class="str">"Priority must be one of 1, 2, 3"</span>
    }
}

<span class="comment">// Field names in the schema:</span>
form: {
    title: { ... },        <span class="comment">// matches errors.title</span>
    description: { ... },  <span class="comment">// matches errors.description</span>
    prio: { ... },         <span class="comment">// matches errors.prio</span>
    ...
}</code></pre>
        </div>

        <h2 id="loading">Loading state</h2>

        <p>
            When you pass <code>loading: { id: "AddTaskForm", size: 40 }</code>
            to TYRAX, the spinner attaches to the form identified by
            <code>form_id</code>. So the loading indicator naturally
            covers the modal's form while the request is in flight.
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code>Tyrax.<span class="fn">post</span>({
    url: <span class="str">"task/add"</span>,
    req: raw,
    loading: { id: <span class="str">"AddTaskForm"</span>, size: <span class="num">40</span> },   <span class="comment">// matches form_id</span>
    res: (send, code, message, data, errors) <span class="kw">=&gt;</span> { ... }
});</code></pre>
        </div>

        <h2 id="full-example">Full example</h2>

        <p>
            A complete TModal setup. schema, edit binding, submit
            handler, and error display:
        </p>

        <div class="code-block">
            <button class="copy-btn" data-copy>Copy</button>
            <pre><code><span class="kw">import</span> $$ <span class="kw">from</span> <span class="str">"../../code/src/mods/ctrx/ctrx.js"</span>;
<span class="kw">import</span> TModal <span class="kw">from</span> <span class="str">"../../code/src/mods/modals/tmodal.js"</span>;
<span class="kw">import</span> Twal <span class="kw">from</span> <span class="str">"../../code/src/mods/twal.js"</span>;
<span class="kw">import</span> Tyrax <span class="kw">from</span> <span class="str">"../../code/src/tyrux/main.js"</span>;
<span class="kw">import</span> Url <span class="kw">from</span> <span class="str">"../../code/src/mods/ctrx/url.js"</span>;
<span class="kw">import</span> { getAssignees } <span class="kw">from</span> <span class="str">"../_models/assignees.js"</span>;

<span class="comment">// Load options from the backend first</span>
<span class="kw">let</span> assignees = <span class="kw">await</span> <span class="fn">getAssignees</span>();

<span class="comment">// Build the modal</span>
<span class="kw">let</span> modal_x = TModal.<span class="fn">init</span>({
    id: <span class="str">"AddTask"</span>,
    title: <span class="str">"Add new task"</span>,
    form_id: <span class="str">"AddTaskForm"</span>,
    form: {
        title:       { type: <span class="str">"text"</span>,     label: <span class="str">"Title:"</span> },
        description: { type: <span class="str">"textarea"</span>, label: <span class="str">"Description:"</span> },
        img:         { type: <span class="str">"imagepicker"</span>, label: <span class="str">"Images:"</span>, config: { dir: <span class="str">"task"</span>, multiple: <span class="kw">true</span> } },
        prio:        { type: <span class="str">"select"</span>,   label: <span class="str">"Priority:"</span>, options: [
            { value: <span class="num">1</span>, label: <span class="str">"Low"</span> },
            { value: <span class="num">2</span>, label: <span class="str">"Medium"</span> },
            { value: <span class="num">3</span>, label: <span class="str">"High"</span> }
        ]},
        assign:      { type: <span class="str">"select"</span>,   label: <span class="str">"Assign to:"</span>, options: assignees, config: { value: <span class="str">"id"</span>, label: <span class="str">"fullname"</span> } },
        deadline:    { type: <span class="str">"calendar"</span>, label: <span class="str">"Deadline:"</span> },
        remarks:     { type: <span class="str">"textarea"</span>, label: <span class="str">"Remarks:"</span> }
    }
});

<span class="comment">// Open for new record</span>
Ctr.<span class="fn">click</span>(<span class="str">".addtaskbtn"</span>, () <span class="kw">=&gt;</span> modal_x.openNew);

<span class="comment">// Open for editing</span>
$$.<span class="fn">click</span>(<span class="str">".edittask"</span>, <span class="kw">function</span> (btn) {
    <span class="kw">let</span> id = $$.<span class="fn">get_attribute</span>(btn, <span class="str">"task-id"</span>);

    Tyrax.<span class="fn">get</span>({
        url: <span class="str">"task/getById"</span>,
        params: { id: id },
        loading: <span class="kw">true</span>,
        res: (send, code, message, data) <span class="kw">=&gt;</span> {
            <span class="kw">if</span> (code <span class="op">!==</span> <span class="num">200</span>) {
                Twal.<span class="fn">err</span>(message);
                <span class="kw">return</span>;
            }
            modal_x.<span class="fn">edit</span>(data, id, <span class="str">"Edit task"</span>);
        }
    });
});

<span class="comment">// Submit. handles both create and edit</span>
modal_x.<span class="fn">form_submit</span>(<span class="kw">function</span> (data, raw) {
    <span class="kw">if</span> (modal_x.<span class="fn">getMeta</span>()) {
        Tyrax.<span class="fn">put</span>({
            url: <span class="str">"task/update"</span>,
            params: { id: modal_x.<span class="fn">getMeta</span>() },
            data: raw,
            loading: { id: <span class="str">"AddTaskForm"</span>, size: <span class="num">40</span> },
            res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) { modal_x.<span class="fn">displayErrors</span>(errors); <span class="kw">return</span>; }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">421</span>) { Twal.<span class="fn">err</span>(message); <span class="kw">return</span>; }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) { Twal.<span class="fn">ok</span>(<span class="str">"Task details updated"</span>, <span class="kw">true</span>); }
            }
        });
    } <span class="kw">else</span> {
        Tyrax.<span class="fn">post</span>({
            url: <span class="str">"task/add"</span>,
            req: raw,
            params: { id: Url.<span class="fn">get</span>(<span class="str">"q"</span>) },
            loading: { id: <span class="str">"AddTaskForm"</span>, size: <span class="num">40</span> },
            res: (send, code, message, data, errors) <span class="kw">=&gt;</span> {
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">422</span>) { modal_x.<span class="fn">displayErrors</span>(errors); <span class="kw">return</span>; }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">401</span>) { Twal.<span class="fn">err</span>(message); <span class="kw">return</span>; }
                <span class="kw">if</span> (code <span class="op">===</span> <span class="num">200</span>) { Twal.<span class="fn">ok</span>(<span class="str">"New task added"</span>, <span class="kw">true</span>); }
            }
        });
    }
});</code></pre>
        </div>

        <h2 id="quick-reference">Quick reference</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Call</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>TModal.init({...})</code></td>
                    <td>Create a modal from a schema</td>
                </tr>
                <tr>
                    <td><code>modal_x.openNew</code></td>
                    <td>Open in create mode</td>
                </tr>
                <tr>
                    <td><code>modal_x.edit(data, id, title)</code></td>
                    <td>Open in edit mode with pre-filled data</td>
                </tr>
                <tr>
                    <td><code>modal_x.form_submit(fn)</code></td>
                    <td>Bind the submit handler</td>
                </tr>
                <tr>
                    <td><code>modal_x.getMeta()</code></td>
                    <td>Check current mode (truthy = edit)</td>
                </tr>
                <tr>
                    <td><code>modal_x.displayErrors(errors)</code></td>
                    <td>Paint 422 errors onto fields</td>
                </tr>
            </tbody>
        </table>

        <h2 id="field-type-reference">Field type reference</h2>

        <table class="docs-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Extra options</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>text</code></td>
                    <td>—</td>
                </tr>
                <tr>
                    <td><code>textarea</code></td>
                    <td>—</td>
                </tr>
                <tr>
                    <td><code>select</code></td>
                    <td>
                        <code>options</code> (array),
                        <code>config</code> ({ value, label })
                    </td>
                </tr>
                <tr>
                    <td><code>calendar</code></td>
                    <td>—</td>
                </tr>
                <tr>
                    <td><code>imagepicker</code></td>
                    <td>
                        <code>config</code>
                        ({ dir, multiple })
                    </td>
                </tr>
            </tbody>
        </table>

        <nav class="docs-pager">
            <a href="twal" class="prev">
                <span class="pager-label">Previous</span>
                <span class="pager-title">← TWal</span>
            </a>
            <a href="tyrax" class="next">
                <span class="pager-label">Next</span>
                <span class="pager-title">TYRAX →</span>
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