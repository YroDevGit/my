import Ctr from "../../code/src/mods/ctr";
import TModal from "../../code/src/mods/modals/tmodal";
import { Twal } from "../../code/src/mods/twal";
import { Tyrax } from "../../code/src/tyrux/main";
import { noteCategories } from "../_models/note_category";


let resCategories = await noteCategories();

let addNoteModal = TModal.init({
    id: "addNoteModal",
    form_id: "addNoteForm",
    title: "Add note",
    form: {
        category: {tag: "select", options: resCategories, config:{value: "id", label: "name"}},
        title: {type: "text", label: "Title"},
        desc: {tag: "textarea", label: "Description"},
        date: {tag: "calendar", label: "Date"}
    }
});

addNoteModal.form_submit((data, raw)=>{
    Tyrax.post({
        url: "note/add",
        data: raw,
        loading: {id: "#addNoteForm", size: 40},
        res: (send, code, message, data, errors) =>{
            if(code == 422){
                addNoteModal.displayErrors(errors);
                return;
            }
            if(code == 200){
                Twal.ok("Note added", true);
                return;
            }
        }
    })
});

Ctr.click("#addnote", ()=>{
    addNoteModal.show();
});