//Js file for auth/manageProject

import Ctr from "../../code/src/mods/ctr";
import $$ from "../../code/src/mods/ctrx/ctrx";
import Url from "../../code/src/mods/ctrx/url";
import TModal from "../../code/src/mods/modals/tmodal";
import Twal from "../../code/src/mods/twal";
import Tyrax from "../../code/src/tyrux/main";

$$.scroll_to_element("#projectTabContent", 80);

$$.modal_unfocus("#taskDetailModal");

let modal_x = TModal.init({
    id: "Addtsk",
    title: "Add new task",
    form_id: "AddTaskForm",
    form: {
        title: { type: "text", label: "Title:" },
        description: { type: "textarea", label: "Description:" },
        img: { type: "imagepicker", label: "Images:", config: { dir: "task", multiple: true } },
        prio: { type: "select", label: "Priority:", options: [{ value: 1, label: "Low" }, { value: 2, label: "Medium" }, { value: 3, label: "High" }] },
        assign: { type: "select", options: [] },
        deadline: { type: "calendar", label: "Deadline:" },
        remarks: { type: "textarea", label: "Remarks:" }
    }
})

$$.click(".deletetask", (btn) => {

    Twal.ask("Are you sure to delete", deleteTask);

    function deleteTask() {
        let id = $$.get_attribute(btn, "task-id");
        Tyrax.delete({
            url: "task/delete",
            params: { task: id },
            res: (send, code, message) => {
                if (code == 200) {
                    Twal.ok("Task deleted", ()=>$$.reload());
                    
                } else {
                    Twal.err(message);
                }
            }
        });
    }
});

$$.click(".edittask", function (btn) {
    let id = $$.get_attribute(btn, "task-id");
    
    Tyrax.get({
        url: "task/getById",
        params: { id: id },
        loading: true,
        res: (send, code, message, data) => {
            if (code != 200) {
                Twal.err(message);
                return;
            }
            if (code == 200) {
                modal_x.edit(data, id, "Edit task");
            }
        }
    });
});

Ctr.click(".addtaskbtn", function () {
    modal_x.openNew;
});

modal_x.form_submit(function (data, raw) {
    if(modal_x.getMeta()){
        
    }else{
        Tyrax.post({
            url: "task/add",
            req: raw,
            params: { id: Url.get("q") },
            loading: { id: "AddTaskForm", size: 40 },
            res: (send, code, message, data, errors) => {
                if (code == 422) {
                    modal_x.displayErrors(errors);
                    return;
                }
                if (code == 401) {
                    Twal.err(message);
                    return;
                }
                if (code == 200) {
                    Twal.ok("New task added", true);
                }
            }
        });
    }
});