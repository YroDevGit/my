import Ctr from "../../code/src/mods/ctr";
import $$ from "../../code/src/mods/ctrx/ctrx";
import Tyrax from "../../code/src/tyrux/main";

// ===== DRAG & DROP SETUP =====
let draggedCard = null;
let dragSourceColumn = null;

// Get all draggable cards
const cards = document.querySelectorAll('.kanban-card');
const columns = document.querySelectorAll('.kanban-items');

// Make cards draggable
cards.forEach(card => {
    card.setAttribute('draggable', 'true');

    card.addEventListener('dragstart', function (e) {
        draggedCard = this;
        dragSourceColumn = this.parentElement;
        this.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', this.dataset.taskId);
        // Add a slight delay to show the drag ghost
        setTimeout(() => {
            this.style.opacity = '0.5';
        }, 0);
    });

    card.addEventListener('dragend', function (e) {
        this.classList.remove('dragging');
        this.style.opacity = '1';
        // Remove drag-over from all columns
        columns.forEach(col => col.classList.remove('drag-over'));
    });

    // Click to open detail modal
    card.addEventListener('click', function (e) {
        // Don't open modal if dragging
        if (this.classList.contains('dragging')) return;
        const modal = new bootstrap.Modal(document.getElementById('taskDetailModal'));
        modal.show();

        if(this.dataset.taskId){
            $$.set_attributes(".edittask",{"task-id":this.dataset.taskId});
        }

        // Update modal content with task data
        const taskTitle = this.querySelector('h6')?.textContent || 'Task';
        const description = this.querySelector(".text-truncate-3")?.textContent || "No description";
        document.querySelector('#taskDetailModal .fw-bold').textContent = taskTitle;
        document.querySelector('#taskDetailModal .task-descr').textContent = description;
    });
});

// Setup drop zones
columns.forEach(column => {
    column.addEventListener('dragover', function (e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        this.classList.add('drag-over');
    });

    column.addEventListener('dragenter', function (e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });

    column.addEventListener('dragleave', function (e) {
        // Only remove if leaving the column
        if (!this.contains(e.relatedTarget)) {
            this.classList.remove('drag-over');
        }
    });

    column.addEventListener('drop', function (e) {
        e.preventDefault();
        this.classList.remove('drag-over');

        if (!draggedCard) return;
        
        // Get the card being dragged
        const card = draggedCard;
        const sourceColumn = dragSourceColumn;
        const targetColumn = this;

        const id = card.dataset.taskId;

        // Don't do anything if dropped in same column
        if (sourceColumn === targetColumn) {
            return;
        }

        const targetId = targetColumn.dataset.id;

        Tyrax.put({
            url: "task/updateStatus",
            params: {status: targetId},
            data: {task: id},
        });

        // Move the card to the target column
        targetColumn.appendChild(card);

        // Update column counts
        updateColumnCounts();
        // Visual feedback - flash effect
        card.style.transition = 'transform 0.2s ease';
        card.style.transform = 'scale(0.95)';
        setTimeout(() => {
            card.style.transform = 'scale(1)';
        }, 200);

        // Reset dragged card
        draggedCard = null;
        dragSourceColumn = null;
    });
});

// Prevent default for entire page to allow drops
document.addEventListener('dragover', function (e) {
    e.preventDefault();
});

document.addEventListener('drop', function (e) {
    e.preventDefault();
});

// ===== UPDATE COLUMN COUNTS =====
function updateColumnCounts() {
    document.querySelectorAll('.kanban-items').forEach(items => {
        const count = items.querySelectorAll('.kanban-card').length;
        const column = items.closest('.kanban-column');
        if (column) {
            const badge = column.querySelector('.badge');
            if (badge) {
                badge.textContent = count;
            }

            // Show/hide empty state message
            const emptyMsg = column.querySelector('.empty-message');
            if (count === 0) {
                if (!emptyMsg) {
                    const msg = document.createElement('div');
                    msg.className = 'empty-message text-center text-secondary small py-3';
                    msg.textContent = 'Drop tasks here';
                    items.appendChild(msg);
                }
            } else {
                if (emptyMsg) {
                    emptyMsg.remove();
                }
            }
        }
    });
}

// ===== SEARCH FUNCTIONALITY =====
const searchInput = document.querySelector('.navbar-search');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase().trim();
        const allCards = document.querySelectorAll('.kanban-card');

        allCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            if (searchTerm === '' || text.includes(searchTerm)) {
                card.style.display = '';
                card.style.opacity = '1';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

// ===== ADD TASK FUNCTIONALITY =====
const addTaskForm = document.querySelector('#addTaskModal form');
if (addTaskForm) {
    addTaskForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const title = this.querySelector('input[placeholder="Enter task title"]')?.value || 'New Task';
        const description = this.querySelector('textarea')?.value || '';
        const priority = this.querySelector('select:first-of-type')?.value || 'medium';
        const deadline = this.querySelector('input[type="date"]')?.value || '';
        const assignee = this.querySelector('select:last-of-type')?.value || '';
        const column = this.querySelector('select:last-of-type')?.value || 'pending';

        // Create new task card
        const newCard = document.createElement('div');
        newCard.className = 'kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-secondary';
        newCard.setAttribute('draggable', 'true');
        newCard.dataset.taskId = Date.now();

        // Priority color
        let priorityColor = 'secondary';
        let priorityLabel = 'Not';
        if (priority === 'high') {
            priorityColor = 'danger';
            priorityLabel = 'High';
        } else if (priority === 'medium') {
            priorityColor = 'warning';
            priorityLabel = 'Medium';
        }

        // Assignee initials
        const assigneeMap = {
            '1': {
                name: 'John Doe',
                initials: 'JD',
                color: 'primary'
            },
            '2': {
                name: 'Sarah Mitchell',
                initials: 'SM',
                color: 'success'
            },
            '3': {
                name: 'Mike Rodriguez',
                initials: 'MR',
                color: 'warning'
            },
            '4': {
                name: 'Alex Chen',
                initials: 'AC',
                color: 'danger'
            },
            '5': {
                name: 'Emma Wilson',
                initials: 'EW',
                color: 'info'
            }
        };
        const assigned = assigneeMap[assignee] || {
            name: 'Unassigned',
            initials: 'U',
            color: 'secondary'
        };

        newCard.innerHTML = `
  <div class="d-flex justify-content-between align-items-start mb-1">
    <h6 class="fw-bold small mb-0">${title}</h6>
    <span class="badge bg-${priorityColor} bg-opacity-10 text-${priorityColor} rounded-pill px-2" style="font-size: 0.6rem;">${priorityLabel}</span>
  </div>
  <p class="text-secondary small mb-2" style="font-size: 0.7rem;">${description || 'No description'}</p>
  <div class="d-flex justify-content-between align-items-center">
    <span class="rounded-circle bg-${assigned.color} bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #1b3a6b; font-size: 0.6rem;">${assigned.initials}</span>
    <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>${deadline || 'No deadline'}</span>
  </div>
`;

        // Add drag events to new card
        newCard.addEventListener('dragstart', function (e) {
            draggedCard = this;
            dragSourceColumn = this.parentElement;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', this.dataset.taskId);
            setTimeout(() => {
                this.style.opacity = '0.5';
            }, 0);
        });

        newCard.addEventListener('dragend', function (e) {
            this.classList.remove('dragging');
            this.style.opacity = '1';
            columns.forEach(col => col.classList.remove('drag-over'));
        });

        newCard.addEventListener('click', function (e) {
            if (this.classList.contains('dragging')) return;
            const modal = new bootstrap.Modal(document.getElementById('taskDetailModal'));
            modal.show();
            document.querySelector('#taskDetailModal .fw-bold').textContent = this.querySelector('h6')?.textContent || 'Task';
        });

        // Find the target column
        const targetColumn = document.querySelector(`.kanban-items[data-column="${column}"]`);
        if (targetColumn) {
            targetColumn.appendChild(newCard);
        } else {
            // Default to pending
            document.querySelector('.kanban-items[data-column="pending"]')?.appendChild(newCard);
        }

        // Update counts
        updateColumnCounts();

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
        if (modal) modal.hide();

        // Reset form
        this.reset();
    });
}

// ===== INITIALIZE =====
updateColumnCounts();

