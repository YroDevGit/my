//Js file for auth/inquiries

import Ctr from "../../code/src/mods/ctr.js";
import Twal from "../../code/src/mods/twal.js";
import Tyrax from "../../code/src/tyrux/main.js";

Ctr.click(".msgpop", (ele) => {
   let msg = ele.getAttribute('msg');
   Twal.info({
      title: "Message",
      text: msg
   });
});

Ctr.click(".action-del", (elem) => {
   Twal.ask("Proceed deleting this inquiry?").then((click) => {
      if (click.confirm) {
         let id = elem.dataset.id;
         Tyrax.delete({
            url: "inquiries/delete",
            req: { id: id },
            res: (send, code, message) => {
               if (code == 200) {
                  Twal.ok("Inquiry deleted", true);
               }
               if (code == 401) {
                  Twal.err(message);
               }
            }
         });
      }
   });
});