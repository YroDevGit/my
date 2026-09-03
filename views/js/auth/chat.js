//Js file for auth/chat

import $$ from "../../code/src/mods/ctrx/ctrx";
import Tyrax from "../../code/src/tyrux/main";

$$.click(".sendbtn", ()=>{
    let message = $$.value("#msg");
    if(! message) return;

    Tyrax.post({
        url: "chat/send",
        data: {message: message},
    })
});