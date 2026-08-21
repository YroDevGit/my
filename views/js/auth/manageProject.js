//Js file for auth/manageProject

import Ctr from "../../code/src/mods/ctr";
import Url from "../../code/src/mods/ctrx/url";
import TModal from "../../code/src/mods/modals/tmodal";
import Twal from "../../code/src/mods/twal";
import Tyrax from "../../code/src/tyrux/main";


let modal = TModal.init({
    id: "AddTaskModal",
    title: "Add new task",
    form_id: "AddTaskForm",
    form: {
        title: {type: "text", label: "Title:"},
        description: {type: "textarea", label: "Description:"},
        img: {type: "imagepicker", label: "Images:", config: {dir: "task", multiple:true}},
        prio: {type: "select", label: "Priority:", options: [{value: 1, label: "Low"}, {value: 1, label: "Midium"}, {value: 1, label: "High"}]},
        assign: {type: "select", options: []},
        deadline: {type: "calendar", label: "Deadline:"},
        remarks: {type: "textarea", label: "Remarks:"}
    }
})


Ctr.click(".addtaskbtn", function(){
    modal.openNew;
});

modal.form_submit(function(data,raw){
    Tyrax.post({
        url: "task/add",
        req: raw,
        params:{id: Url.get("q")},
        loading: {id: "AddTaskForm", size: 40},
        res: (send, code, message, data, errors)=>{
            if(code == 422){
                modal.displayErrors(errors);
                return;
            }
            if(code == 401){
                Twal.err(message);
                return;
            }
            if(code == 200){
                Twal.ok("New task added", true);
            }
        }
    })
});