//Js file for auth/projects

import Ctr from "../../code/src/mods/ctr";
import Url from "../../code/src/mods/ctrx/url";
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
        name: { type: "text", label: "Project name" },
        description: { type: "textarea", label: "Description" },
        client: { type: "select", label: "Client", options: clients, config: { value: "id", label: "name" } },
        date: { type: "calendar", label: "Date of appointment", attributes: { time: true } },
        type: { type: "select", label: "Type", options: inqtypes, config: { value: "id", label: "type" } }
    }
});

function displayForm() {
    tmodal.openNew;
}

Ctr.click(".addproject", displayForm);

tmodal.form_submit(formSubmit);

Ctr.click(".editbtn", (btn) => {
    let value_id = btn.id;
    Tyrax.get({
        url: "project/getById",
        req: {id: value_id},
        res: (send, code, message, data)=>{
            if(code == 200){
                alert("aw");
            }
        }
    });
    tmodal.setMeta({ id: value_id }).setTitle("Edit project").show({
        name: "tyrone"
    });
});

function formSubmit(form, data) {
    let id = tmodal.getMeta("id");
    if (id) {

    } else {
        Tyrax.post({
            url: "project/add",
            req: data,
            loading: { id: "prodjectForm", size: 40 },
            res: (send, code, message, data, errors) => {
                if (code == 422) {
                    tmodal.displayErrors(errors);
                    return;
                }
                if (code == 200) {
                    Twal.ok("Project added", true);
                }
            }
        });
    }
}

if (Url.get("type")) {
    Ctr.set_value(".ptypecb", Url.get("type"));
}


Ctr.change(".ptypecb", (selector) => {
    let val = selector.value;
    location.href = Url.set_params({ type: val });
});

Ctr.click(".deletebtn", (btn, attributes) => {
    let value = attributes["dataid"];
    Twal.ask("Are you sure to delete this project?").then(deleteThis);
    function deleteThis(click) {
        if (click.confirm) {
            Tyrax.delete({
                url: "project/delete",
                params: { "id": value },
                res: (send, code, message) => {
                    if (code == 422) {
                        Twal.err(message);
                        return;
                    }
                    if (code == 200) {
                        Twal.ok("Project deleted", true);
                    }
                }
            });
        }
    }
});

