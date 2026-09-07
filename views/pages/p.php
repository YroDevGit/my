<!DOCTYPE html>
<html>
<head>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        
        .editor-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            padding: 10px;
            background: #fafafa;
            border-bottom: 1px solid #e0e0e0;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .toolbar button {
            padding: 6px 12px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s;
        }
        
        .toolbar button:hover {
            background: #e3f2fd;
            border-color: #2196f3;
        }
        
        .toolbar button.active {
            background: #2196f3;
            color: white;
            border-color: #2196f3;
        }
        
        .toolbar .separator {
            width: 1px;
            background: #ddd;
            margin: 0 4px;
        }
        
        #editor {
            padding: 20px;
            min-height: 400px;
            outline: none;
            line-height: 1.6;
            font-size: 16px;
        }
        
        #editor p {
            margin: 0 0 12px 0;
        }
        
        #editor table {
            border-collapse: collapse;
            width: 100%;
            margin: 12px 0;
            position: relative;
        }
        
        #editor table td,
        #editor table th {
            border: 1px solid #ccc;
            padding: 8px 12px;
            min-width: 60px;
            position: relative;
            transition: background 0.2s;
        }
        
        #editor table th {
            background: #f0f0f0;
            font-weight: bold;
        }
        
        #editor table tr.highlighted-row td,
        #editor table tr.highlighted-row th {
            background: #fff3e0 !important;
        }
        
        #editor table .highlighted-col {
            background: #e3f2fd !important;
        }
        
        #editor table tr.highlighted-row .highlighted-col {
            background: #ffccbc !important;
        }
        
        #editor table .row-delete-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            border: none;
            background: #f44336;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s, transform 0.2s;
            z-index: 5;
            padding: 0;
            line-height: 1;
        }
        
        #editor table tr:hover .row-delete-btn {
            display: flex;
            opacity: 1;
        }
        
        #editor table .row-delete-btn:hover {
            background: #d32f2f;
            transform: translateY(-50%) scale(1.1);
        }
        
        #editor table .col-delete-btn {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 24px;
            border: none;
            background: #f44336;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s, transform 0.2s;
            z-index: 5;
            padding: 0;
            line-height: 1;
        }
        
        #editor table th:hover .col-delete-btn,
        #editor table td:hover .col-delete-btn {
            display: flex;
            opacity: 1;
        }
        
        #editor table .col-delete-btn:hover {
            background: #d32f2f;
            transform: translateX(-50%) scale(1.1);
        }
        
        .mention {
            background: #e3f2fd;
            color: #1565c0;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            display: inline-block;
        }
        
        .mention::before {
            content: '@';
        }
        
        .mention-dropdown {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            max-height: 150px;
            overflow-y: auto;
            display: none;
            min-width: 150px;
            z-index: 100;
        }
        
        .mention-dropdown .item {
            padding: 8px 16px;
            cursor: pointer;
        }
        
        .mention-dropdown .item:hover,
        .mention-dropdown .item.selected {
            background: #e3f2fd;
        }
        
        #editor img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin: 8px 0;
            display: block;
        }
        
        #editor .file-attachment {
            display: inline-block;
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            margin: 4px 0;
            text-decoration: none;
            color: #2196f3;
        }
        
        #editor .file-attachment:hover {
            background: #e3f2fd;
        }
        
        #editor .file-attachment .file-icon {
            margin-right: 8px;
        }
        
        .file-input-hidden {
            display: none;
        }
    </style>
</head>
<body>

<div class="editor-wrapper">
    <div class="toolbar">
        <button data-command="bold" title="Bold (Ctrl+B)"><b>B</b></button>
        <button data-command="italic" title="Italic (Ctrl+I)"><i>I</i></button>
        <button data-command="underline" title="Underline (Ctrl+U)"><u>U</u></button>
        
        <div class="separator"></div>
        
        <button data-command="insertParagraph">¶ Paragraph</button>
        <button data-command="insertHeading">H1 Heading</button>
        
        <div class="separator"></div>
        
        <button data-command="insertTable">📊 Table</button>
        <button data-command="insertRow">⬇ Add Row</button>
        <button data-command="insertCol">➡ Add Col</button>
        
        <div class="separator"></div>
        
        <button data-command="createLink">🔗 Link</button>
        <button data-command="unlink">🔗 Unlink</button>
        
        <div class="separator"></div>
        
        <button data-command="mention">@ Mention</button>
        <button data-command="attachFile">📎 File</button>
        <button data-command="attachImage">🖼 Image</button>
        
        <div class="separator"></div>
        
        <button data-command="undo">↩ Undo</button>
        <button data-command="redo">↪ Redo</button>
    </div>
    
    <div id="editor" contenteditable="true">
        <p>Welcome to your <b>native</b> editor with visual table controls!</p>
        <p>Click a cell to highlight the row and column, then use the toolbar buttons to add/remove.</p>
        
        <table>
            <thead>
                <tr>
                    <th>Header 1</th>
                    <th>Header 2</th>
                    <th>Header 3</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cell 1,1</td>
                    <td>Cell 1,2</td>
                    <td>Cell 1,3</td>
                </tr>
                <tr>
                    <td>Cell 2,1</td>
                    <td>Cell 2,2</td>
                    <td>Cell 2,3</td>
                </tr>
                <tr>
                    <td>Cell 3,1</td>
                    <td>Cell 3,2</td>
                    <td>Cell 3,3</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<input type="file" id="fileInput" class="file-input-hidden" multiple>
<input type="file" id="imageInput" class="file-input-hidden" accept="image/*" multiple>

<div class="mention-dropdown" id="mentionDropdown"></div>

<script>
const editor = document.getElementById('editor');
const dropdown = document.getElementById('mentionDropdown');
const fileInput = document.getElementById('fileInput');
const imageInput = document.getElementById('imageInput');

const users = ['Alice Johnson', 'Bob Smith', 'Carol Davis', 'Dave Wilson', 'Eve Brown'];
let mentionStartIndex = -1;
let selectedMentionIndex = 0;
let isMentioning = false;
let mentionTextNode = null;

let highlightedRowElement = null;
let highlightedColIndex = -1;
let highlightedTableElement = null;

let undoStack = [];
let redoStack = [];
const MAX_STACK = 50;

function saveState() {
    undoStack.push(editor.innerHTML);
    if (undoStack.length > MAX_STACK) undoStack.shift();
    redoStack = [];
}

function undo() {
    if (undoStack.length === 0) return;
    redoStack.push(editor.innerHTML);
    editor.innerHTML = undoStack.pop();
    editor.focus();
    refreshAllTableControls();
    highlightedRowElement = null;
    highlightedColIndex = -1;
    highlightedTableElement = null;
}

function redo() {
    if (redoStack.length === 0) return;
    undoStack.push(editor.innerHTML);
    editor.innerHTML = redoStack.pop();
    editor.focus();
    refreshAllTableControls();
    highlightedRowElement = null;
    highlightedColIndex = -1;
    highlightedTableElement = null;
}

editor.addEventListener('input', saveState);
editor.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.key === 'z') { e.preventDefault(); undo(); }
    if (e.ctrlKey && e.key === 'y') { e.preventDefault(); redo(); }
});

function exec(cmd, value = null) {
    saveState();
    document.execCommand(cmd, false, value);
    editor.focus();
    updateToolbar();
    refreshAllTableControls();
}

function insertParagraph() {
    saveState();
    const sel = window.getSelection();
    if (!sel.rangeCount) return;
    
    const range = sel.getRangeAt(0);
    const parent = range.startContainer.parentElement;
    
    if (parent.tagName === 'P') {
        document.execCommand('insertParagraph', false, null);
        return;
    }
    
    const p = document.createElement('p');
    p.textContent = 'New paragraph';
    const block = parent.closest('p, div, li, td') || parent;
    block.parentNode.insertBefore(p, block.nextSibling);
    
    const newRange = document.createRange();
    newRange.setStart(p, 0);
    sel.removeAllRanges();
    sel.addRange(newRange);
    editor.focus();
    refreshAllTableControls();
}

function insertHeading() {
    saveState();
    const sel = window.getSelection();
    if (!sel.rangeCount) return;
    
    const range = sel.getRangeAt(0);
    const parent = range.startContainer.parentElement;
    
    if (parent.tagName === 'P' || parent.tagName === 'DIV') {
        const h1 = document.createElement('h1');
        h1.textContent = parent.textContent || 'Heading';
        parent.parentNode.replaceChild(h1, parent);
        
        const newRange = document.createRange();
        newRange.setStart(h1, 0);
        sel.removeAllRanges();
        sel.addRange(newRange);
    } else {
        const h1 = document.createElement('h1');
        h1.textContent = 'Heading';
        const block = parent.closest('p, div, li, td') || parent;
        block.parentNode.insertBefore(h1, block.nextSibling);
        
        const newRange = document.createRange();
        newRange.setStart(h1, 0);
        sel.removeAllRanges();
        sel.addRange(newRange);
    }
    editor.focus();
    refreshAllTableControls();
}

function getCurrentCell() {
    const sel = window.getSelection();
    if (!sel.rangeCount) return null;
    
    let node = sel.rangeAt(0).startContainer;
    if (node.nodeType === Node.TEXT_NODE) {
        node = node.parentElement;
    }
    return node.closest?.('td, th') || null;
}

function getCurrentRow() {
    const cell = getCurrentCell();
    return cell ? cell.closest('tr') : null;
}

function getCurrentTable() {
    const row = getCurrentRow();
    return row ? row.closest('table') : null;
}

function getColumnIndex(cell) {
    const row = cell.closest('tr');
    return Array.from(row.children).indexOf(cell);
}

function getColumnCount(table) {
    const firstRow = table.querySelector('tr');
    if (!firstRow) return 0;
    return firstRow.children.length;
}

function clearHighlights(table) {
    if (!table) return;
    
    table.querySelectorAll('tr').forEach(tr => {
        tr.classList.remove('highlighted-row');
    });
    table.querySelectorAll('td, th').forEach(cell => {
        cell.classList.remove('highlighted-col');
    });
}

function highlightRow(tr) {
    const table = tr.closest('table');
    clearHighlights(table);
    tr.classList.add('highlighted-row');
    highlightedRowElement = tr;
    highlightedTableElement = table;
}

function highlightColumn(cell) {
    const table = cell.closest('table');
    const colIndex = getColumnIndex(cell);
    clearHighlights(table);
    
    table.querySelectorAll('tr').forEach(row => {
        const children = row.children;
        if (children[colIndex]) {
            children[colIndex].classList.add('highlighted-col');
        }
    });
    highlightedColIndex = colIndex;
    highlightedTableElement = table;
}

function refreshAllTableControls() {
    const tables = editor.querySelectorAll('table');
    tables.forEach(table => {
        table.dataset.hasControls = 'false';
    });
    addTableControls();
}

function addTableControls() {
    const tables = editor.querySelectorAll('table');
    
    tables.forEach(table => {
        if (table.dataset.hasControls === 'true') {
            return;
        }
        table.dataset.hasControls = 'true';
        
        table.querySelectorAll('tr').forEach(tr => {
            if (tr.querySelector('.row-delete-btn')) return;
            
            const btn = document.createElement('button');
            btn.className = 'row-delete-btn';
            btn.innerHTML = '×';
            btn.title = 'Delete this row';
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();
                deleteRow(tr);
            });
            tr.style.position = 'relative';
            tr.appendChild(btn);
        });
        
        const headerRow = table.querySelector('thead tr');
        if (headerRow) {
            headerRow.querySelectorAll('th').forEach(th => {
                if (th.querySelector('.col-delete-btn')) return;
                
                const btn = document.createElement('button');
                btn.className = 'col-delete-btn';
                btn.innerHTML = '×';
                btn.title = 'Delete this column';
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    e.preventDefault();
                    deleteColumn(th);
                });
                th.style.position = 'relative';
                th.appendChild(btn);
            });
        } else {
            const firstRow = table.querySelector('tbody tr');
            if (firstRow) {
                firstRow.querySelectorAll('td').forEach(td => {
                    if (td.querySelector('.col-delete-btn')) return;
                    
                    const btn = document.createElement('button');
                    btn.className = 'col-delete-btn';
                    btn.innerHTML = '×';
                    btn.title = 'Delete this column';
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        e.preventDefault();
                        deleteColumn(td);
                    });
                    td.style.position = 'relative';
                    td.appendChild(btn);
                });
            }
        }
        
        table.querySelectorAll('td, th').forEach(cell => {
            cell.addEventListener('click', (e) => {
                if (e.target.closest('button')) return;
                
                const tr = cell.closest('tr');
                highlightRow(tr);
                highlightColumn(cell);
            });
        });
    });
}

function deleteRow(tr) {
    saveState();
    const tbody = tr.closest('tbody');
    if (!tbody) {
        alert('Cannot delete header row');
        return;
    }
    
    if (tbody.children.length <= 1) {
        alert('Cannot delete the last row. Delete the table instead.');
        return;
    }
    
    tr.remove();
    highlightedRowElement = null;
    editor.focus();
    refreshAllTableControls();
}

function deleteColumn(cell) {
    saveState();
    const table = cell.closest('table');
    const colIndex = getColumnIndex(cell);
    
    const firstRow = table.querySelector('tr');
    if (firstRow && firstRow.children.length <= 1) {
        alert('Cannot delete the last column. Delete the table instead.');
        return;
    }
    
    table.querySelectorAll('tr').forEach(row => {
        const children = row.children;
        if (children[colIndex]) {
            children[colIndex].remove();
        }
    });
    
    highlightedColIndex = -1;
    editor.focus();
    refreshAllTableControls();
}

function insertRow() {
    saveState();
    
    let targetRow = null;
    
    if (highlightedRowElement && document.body.contains(highlightedRowElement)) {
        targetRow = highlightedRowElement;
    } else {
        targetRow = getCurrentRow();
        if (targetRow) {
            highlightRow(targetRow);
        }
    }
    
    if (!targetRow) {
        alert('Please click a cell to select a row first.');
        return;
    }
    
    const tbody = targetRow.closest('tbody');
    if (!tbody) {
        alert('Cannot add row to header section.');
        return;
    }
    
    const table = targetRow.closest('table');
    const colCount = getColumnCount(table)-1;
    
    const newRow = document.createElement('tr');
    
    for (let i = 0; i < colCount; i++) {
        const newCell = document.createElement('td');
        newCell.contentEditable = 'true';
        newCell.textContent = 'New cell';
        newRow.appendChild(newCell);
    }
    
    targetRow.parentNode.insertBefore(newRow, targetRow.nextSibling);
    highlightRow(newRow);
    
    const firstCell = newRow.querySelector('td');
    if (firstCell) {
        const sel = window.getSelection();
        const range = document.createRange();
        range.setStart(firstCell, 0);
        sel.removeAllRanges();
        sel.addRange(range);
    }
    
    editor.focus();
    refreshAllTableControls();
    saveState();
}

function insertCol() {
    saveState();
    
    let targetCell = null;
    let targetColIdx = -1;
    let table = null;
    
    if (highlightedColIndex !== -1 && highlightedTableElement && document.body.contains(highlightedTableElement)) {
        table = highlightedTableElement;
        targetColIdx = highlightedColIndex;
        const firstRow = table.querySelector('tr');
        if (firstRow && firstRow.children[targetColIdx]) {
            targetCell = firstRow.children[targetColIdx];
        }
    }
    
    if (!targetCell) {
        targetCell = getCurrentCell();
        if (targetCell) {
            table = targetCell.closest('table');
            targetColIdx = getColumnIndex(targetCell);
            highlightColumn(targetCell);
        }
    }
    
    if (!targetCell || !table) {
        alert('Please click a cell to select a column first.');
        return;
    }
    
    const insertPosition = targetColIdx + 1;
    
    table.querySelectorAll('tr').forEach(row => {
        const newCell = document.createElement(row.closest('thead') ? 'th' : 'td');
        newCell.contentEditable = 'true';
        newCell.textContent = 'New';
        const cells = row.children;
        
        if (insertPosition < cells.length) {
            row.insertBefore(newCell, cells[insertPosition]);
        } else {
            row.appendChild(newCell);
        }
    });
    
    highlightedColIndex = insertPosition;
    
    table.querySelectorAll('tr').forEach(row => {
        const children = row.children;
        if (children[highlightedColIndex]) {
            children[highlightedColIndex].classList.add('highlighted-col');
        }
    });
    
    const firstRow = table.querySelector('tr');
    if (firstRow && firstRow.children[highlightedColIndex]) {
        const cell = firstRow.children[highlightedColIndex];
        const sel = window.getSelection();
        const range = document.createRange();
        range.setStart(cell, 0);
        sel.removeAllRanges();
        sel.addRange(range);
    }
    
    editor.focus();
    refreshAllTableControls();
    saveState();
}

function insertTable() {
    saveState();
    const table = document.createElement('table');
    const rows = 3;
    const cols = 3;
    
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    for (let i = 0; i < cols; i++) {
        const th = document.createElement('th');
        th.textContent = `Header ${i+1}`;
        headerRow.appendChild(th);
    }
    thead.appendChild(headerRow);
    table.appendChild(thead);
    
    const tbody = document.createElement('tbody');
    for (let r = 0; r < rows; r++) {
        const tr = document.createElement('tr');
        for (let c = 0; c < cols; c++) {
            const td = document.createElement('td');
            td.textContent = `Cell ${r+1},${c+1}`;
            td.contentEditable = 'true';
            tr.appendChild(td);
        }
        tbody.appendChild(tr);
    }
    table.appendChild(tbody);
    
    const sel = window.getSelection();
    if (sel.rangeCount) {
        const range = sel.getRangeAt(0);
        range.insertNode(table);
        
        const firstCell = table.querySelector('td');
        if (firstCell) {
            const newRange = document.createRange();
            newRange.setStart(firstCell, 0);
            sel.removeAllRanges();
            sel.addRange(newRange);
        }
    }
    editor.focus();
    refreshAllTableControls();
}

function attachFile() {
    fileInput.click();
}

function attachImage() {
    imageInput.click();
}

fileInput.addEventListener('change', function(e) {
    const files = this.files;
    for (let file of files) {
        const reader = new FileReader();
        reader.onload = function(event) {
            saveState();
            const url = event.target.result;
            const fileName = file.name;
            const fileSize = (file.size / 1024).toFixed(1);
            
            const link = document.createElement('a');
            link.className = 'file-attachment';
            link.href = url;
            link.download = fileName;
            link.innerHTML = `<span class="file-icon">📎</span> ${fileName} (${fileSize} KB)`;
            
            const sel = window.getSelection();
            if (sel.rangeCount) {
                const range = sel.getRangeAt(0);
                range.insertNode(link);
                
                const space = document.createTextNode(' ');
                range.setStartAfter(link);
                range.insertNode(space);
                
                const newRange = document.createRange();
                newRange.setStartAfter(space);
                sel.removeAllRanges();
                sel.addRange(newRange);
            }
            editor.focus();
        };
        reader.readAsDataURL(file);
    }
    this.value = '';
});

imageInput.addEventListener('change', function(e) {
    const files = this.files;
    for (let file of files) {
        const reader = new FileReader();
        reader.onload = function(event) {
            saveState();
            const img = document.createElement('img');
            img.src = event.target.result;
            img.alt = file.name;
            img.title = file.name;
            img.style.maxWidth = '100%';
            img.style.height = 'auto';
            
            const sel = window.getSelection();
            if (sel.rangeCount) {
                const range = sel.getRangeAt(0);
                range.insertNode(img);
                
                const space = document.createTextNode(' ');
                range.setStartAfter(img);
                range.insertNode(space);
                
                const newRange = document.createRange();
                newRange.setStartAfter(space);
                sel.removeAllRanges();
                sel.addRange(newRange);
            }
            editor.focus();
        };
        reader.readAsDataURL(file);
    }
    this.value = '';
});

function handleMentionInput(e) {
    const sel = window.getSelection();
    if (!sel.rangeCount) return;
    
    const range = sel.getRangeAt(0);
    const node = range.startContainer;
    
    if (node.nodeType !== Node.TEXT_NODE) return;
    
    const text = node.textContent || '';
    const cursorPos = range.startOffset;
    const beforeCursor = text.substring(0, cursorPos);
    const atIndex = beforeCursor.lastIndexOf('@');
    
    if (atIndex !== -1) {
        const query = beforeCursor.substring(atIndex + 1);
        
        if (query.length <= 30) {
            const rect = range.getClientRects()[0];
            
            if (rect) {
                dropdown.style.display = 'block';
                dropdown.style.left = rect.left + 'px';
                dropdown.style.top = (rect.bottom + window.scrollY + 5) + 'px';
                
                const filtered = users.filter(u => 
                    u.toLowerCase().includes(query.toLowerCase())
                );
                
                dropdown.innerHTML = filtered.length > 0 
                    ? filtered.map((user, i) => 
                        `<div class="item ${i === selectedMentionIndex ? 'selected' : ''}" 
                              data-user="${user}">${user}</div>`
                      ).join('')
                    : '<div class="item" style="color:#999;">No users found</div>';
                
                dropdown.querySelectorAll('.item[data-user]').forEach(el => {
                    el.onclick = () => {
                        insertMention(el.dataset.user, node, atIndex);
                    };
                });
                
                isMentioning = true;
                mentionStartIndex = atIndex;
                mentionTextNode = node;
                selectedMentionIndex = 0;
            }
        } else {
            dropdown.style.display = 'none';
            isMentioning = false;
        }
    } else {
        dropdown.style.display = 'none';
        isMentioning = false;
    }
}

function insertMention(username, textNode, startIndex) {
    saveState();
    
    const sel = window.getSelection();
    if (!sel.rangeCount) return;
    
    const range = sel.getRangeAt(0);
    const fullText = textNode.textContent;
    const cursorPos = range.startOffset;
    
    const before = fullText.substring(0, startIndex);
    const after = fullText.substring(cursorPos);
    
    const mentionSpan = document.createElement('span');
    mentionSpan.className = 'mention';
    mentionSpan.contentEditable = 'false';
    mentionSpan.textContent = username;
    
    const space = document.createTextNode(' ');
    
    textNode.textContent = before;
    
    const parent = textNode.parentNode;
    const fragment = document.createDocumentFragment();
    fragment.appendChild(mentionSpan);
    fragment.appendChild(space);
    
    if (textNode.nextSibling) {
        parent.insertBefore(fragment, textNode.nextSibling);
    } else {
        parent.appendChild(fragment);
    }
    
    const newRange = document.createRange();
    newRange.setStartAfter(space);
    sel.removeAllRanges();
    sel.addRange(newRange);
    
    dropdown.style.display = 'none';
    isMentioning = false;
    mentionTextNode = null;
    
    editor.focus();
    updateToolbar();
}

editor.addEventListener('keydown', (e) => {
    if (!isMentioning) return;
    
    const items = dropdown.querySelectorAll('.item[data-user]');
    if (items.length === 0) return;
    
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        selectedMentionIndex = (selectedMentionIndex + 1) % items.length;
        updateMentionSelection(items);
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        selectedMentionIndex = (selectedMentionIndex - 1 + items.length) % items.length;
        updateMentionSelection(items);
    } else if (e.key === 'Enter' || e.key === 'Tab') {
        e.preventDefault();
        const selected = items[selectedMentionIndex];
        if (selected && mentionTextNode) {
            insertMention(selected.dataset.user, mentionTextNode, mentionStartIndex);
        }
    } else if (e.key === 'Escape') {
        dropdown.style.display = 'none';
        isMentioning = false;
        mentionTextNode = null;
    }
});

function updateMentionSelection(items) {
    items.forEach((el, i) => {
        el.classList.toggle('selected', i === selectedMentionIndex);
    });
}

let mentionTimeout;
editor.addEventListener('input', (e) => {
    clearTimeout(mentionTimeout);
    mentionTimeout = setTimeout(() => {
        handleMentionInput(e);
    }, 50);
});

function updateToolbar() {
    document.querySelectorAll('[data-command]').forEach(btn => {
        const cmd = btn.dataset.command;
        if (['bold', 'italic', 'underline'].includes(cmd)) {
            try {
                btn.classList.toggle('active', document.queryCommandState(cmd));
            } catch(e) {}
        }
    });
}

editor.addEventListener('mouseup', updateToolbar);
editor.addEventListener('keyup', updateToolbar);

document.querySelectorAll('[data-command]').forEach(btn => {
    btn.addEventListener('click', () => {
        const cmd = btn.dataset.command;
        
        switch(cmd) {
            case 'bold':
            case 'italic':
            case 'underline':
                exec(cmd);
                break;
            case 'insertParagraph':
                insertParagraph();
                break;
            case 'insertHeading':
                insertHeading();
                break;
            case 'insertTable':
                insertTable();
                break;
            case 'insertRow':
                insertRow();
                break;
            case 'insertCol':
                insertCol();
                break;
            case 'createLink':
                const url = prompt('Enter URL:', 'https://');
                if (url) exec('createLink', url);
                break;
            case 'unlink':
                exec('unlink');
                break;
            case 'mention':
                exec('insertText', '@');
                break;
            case 'attachFile':
                attachFile();
                break;
            case 'attachImage':
                attachImage();
                break;
            case 'undo':
                undo();
                break;
            case 'redo':
                redo();
                break;
        }
    });
});

document.addEventListener('click', (e) => {
    if (!dropdown.contains(e.target) && e.target !== editor) {
        dropdown.style.display = 'none';
        isMentioning = false;
        mentionTextNode = null;
    }
});

saveState();
updateToolbar();
refreshAllTableControls();

console.log('✅ Native editor ready!');
console.log('Features:');
console.log('  - Click cell → highlights row (orange) and column (blue)');
console.log('  - Hover row → × button to delete row');
console.log('  - Hover column header → × button to delete column');
console.log('  - Add Row/Col buttons work with highlighting');
console.log('  - Attach files and images');
console.log('  - Bold, Italic, Underline, Paragraphs, Headings');
console.log('  - Mentions with @ symbol');
console.log('  - Undo/Redo (Ctrl+Z / Ctrl+Y)');
</script>

</body>
</html>