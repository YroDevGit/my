//Js file for auth/people

import $$ from "../../code/src/mods/ctrx/ctrx";
import Url from "../../code/src/mods/ctrx/url";
import FormValidator from "../../code/src/mods/formValidator";
import Twal from "../../code/src/mods/twal";
import Tyrax from "../../code/src/tyrux/main";

$$.submit("#addEmployeeForm", (data, raw)=>{
    Tyrax.post({
        url: "user/add",
        loading: {element: "#addEmployeeForm", size: 33},
        data: raw,
        res: (send, code, message, data, errors)=>{
            if(code == 422){
                FormValidator.displayErrors(errors, "#addEmployeeForm");
                return;
            }
            if(code == 200){
                Twal.ok("Member added", true);
                return;
            }
        }
    });
});

$$.click(".searchbtn", ()=>{
    let nameSearch = $$.value("#nameSearch");
    let roleSearch = $$.value("#roleSearch");
    let newSearch = {};
    if(nameSearch){
        newSearch = {q: nameSearch};
    }
    if(roleSearch){
        newSearch = {...newSearch, role: roleSearch};
    }
    location.href = Url.set_params(newSearch);
});
