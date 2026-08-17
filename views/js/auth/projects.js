//Js file for auth/projects

import Ctr from "../../code/src/mods/ctr";
import TModal from "../../code/src/mods/modals/tmodal";

let tmodal = TModal.init({
   title: "Add new project",
   id: "pr_id",
   form_id: "prodjectForm",
   form: {
        name: {type: "text", label: "Project name"},
        description: {type: "textarea", label: "Description"},
        client: {tag: "select", label: "Client", options: []}
   }
});

function displayForm(){
    tmodal.open;
}

Ctr.click(".addproject", displayForm);


