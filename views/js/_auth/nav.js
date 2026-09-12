import $$ from "../../code/src/mods/ctrx/ctrx.js";
import TModal from "../../code/src/mods/modals/tmodal.js";
import Twal from "../../code/src/mods/twal.js";
import Tyrax from "../../code/src/tyrux/main.js";

let profileModal = TModal.init({
    id: "profileModal",
    form_id: "profileModalForm",
    title: "Edit profile",
    form:{
        email: {label: "Email (read only)", attributes: {readonly: true}},
        fname: {label: "First name", group: "g1"},
        lname: {label: "Last name", group: "g1"},
        img: {type: "cimage", label: "Photo", config: {quality:30}},
        password: {type: "password", label: "Password"},
        repassword: {type: "password", label: "Re-enter Password"},
    }
});

profileModal.form_submit((data,raw)=>{
    console.log(data.get("img") instanceof File);
    Tyrax.post({
        url: "user/update",
        data: data,
        loading: {element: "#profileModalForm", size: 40},
        res: (send, code, message, data, errors)=>{
            if(code == 422){
                profileModal.displayErrors(errors);
                return;
            }
            if(code == 421){
                Twal.err(message);
                return;
            }
            if(code == 200){
                Twal.ok("User profile updated", true);
            }
        }
    })
});


$$.click(".my-profile", ()=>{
    Tyrax.get({
        url: "user/getById",
        loading: true,
        res: (send, code, message, data)=>{
            profileModal.show({
                fname: data.fname,
                lname: data.lname,
                email: data.email,
                img: data.img
            });
        }
    });
});

Tyrax.get({
    url: "user/getById",
    res: (send, code, message, data)=>{
        if(data.img){
            $$.set_html(".navatar", `<img src="${data.img}" alt="" height="35" width="35" style="border-radius: 50%;">`)
        }
    }
});