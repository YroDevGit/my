//Js file for auth/manageProject

import Ctr from "../../code/src/mods/ctr";
import TModal from "../../code/src/mods/modals/tmodal";


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