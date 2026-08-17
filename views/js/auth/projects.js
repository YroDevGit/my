//Js file for auth/projects

import Ctr from "../../code/src/mods/ctr";
import TModal from "../../code/src/mods/modals/tmodal";
import Twal from "../../code/src/mods/twal";
import Tyrax from "../../code/src/tyrux/main";
import { getAllClients } from "../_models/clients";
import { inquiryTypes } from "../_models/inquiry_type";

let inqtypes = await inquiryTypes();
let clients = await getAllClients();

let tmodal = TModal.init({
   title: "Add new project",
   id: "pr_id",
   form_id: "prodjectForm",
   form: {
        name: {type: "text", label: "Project name"},
        description: {type: "textarea", label: "Description"},
        client: {type: "select", label: "Client", options: clients, config: {value: "id", label: "name"}},
        date: {type: "calendar", label: "Date of appointment", attributes: {time: true}},
        type: {type: "select", label: "Type", options: inqtypes, config: {value: "id", label: "type"}}
   }
});

function displayForm(){
    tmodal.open;
}

Ctr.click(".addproject", displayForm);

tmodal.form_submit(formSubmit);

function formSubmit(form, data){
    Tyrax.post({
        url: "project/add",
        req: data,
        loading: {id: "prodjectForm", size: 40},
        res: (send, code, message, data, errors)=>{
            if(code == 422){
                tmodal.displayErrors(errors);
                return;
            }
            if(code == 200){
                Twal.ok("Project added", true);
            }
        }
    })
}

