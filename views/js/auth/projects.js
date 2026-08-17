//Js file for auth/projects

import Ctr from "../../code/src/mods/ctr";
import TModal from "../../code/src/mods/modals/tmodal";
import Tyrax from "../../code/src/tyrux/main";
import { inquiryTypes } from "../_models/inquiry_type";

let inqtypes = await inquiryTypes();

let tmodal = TModal.init({
   title: "Add new project",
   id: "pr_id",
   form_id: "prodjectForm",
   form: {
        name: {type: "text", label: "Project name"},
        description: {type: "textarea", label: "Description"},
        client: {type: "select", label: "Client", options: []},
        date: {type: "calendar", label: "Date of appointment"},
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
            }
        }
    })
}

