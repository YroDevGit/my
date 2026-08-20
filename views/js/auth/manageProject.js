//Js file for auth/manageProject

import Ctr from "../../code/src/mods/ctr";
import TModal from "../../code/src/mods/modals/tmodal";


let modal = TModal.init({
    id: "AddTaskModal",
    title: "Add new task",
    form_id: "AddTaskForm",
    form: {
        title: {type: "text", label: "Title"},
        description: {type: "textarea", label: "Description"},
        
    }
})


Ctr.click(".addtaskbtn", function(){
    modal.openNew;
});