//Js file for auth/chat

import $$ from "../../code/src/mods/ctrx/ctrx";
import CtrDATE from "../../code/src/mods/date";
import Secure from "../../code/src/mods/secure";
import Twal from "../../code/src/mods/twal";
import Tyrax from "../../code/src/tyrux/main";

$$.click(".sendbtn", ()=>{
    let message = $$.value("#msg");
    if(! message) return;

    Tyrax.post({
        url: "chat/send",
        loading: {element: ".sendbtn", size: 20},
        data: {message: message},
        res: ()=>{
            receivedChat(true);
        }
    });
});

setInterval(() => {
    receivedChat();
}, 10000);

function receivedChat(clearChat = false){
    Tyrax.get({
        url: "chat/recieve",
        res: (send, code, message, data)=>{
            $$.set_html("#chatContainer", ``);
            data.forEach(column => {
                let img = column.img;
                if(img){
                    img = `<img style="border-radius:50%;" height="30" width="30" src="${img}" alt="">`
                }else{
                    img = `<div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" 
                                style="width: 36px; height: 36px; font-weight: 700; color: #065f46; font-size: 0.7rem;">
                            ${column.avatar}
                            </div>`;
                }
                if(column.owner == "yes"){
                    $$.add_html("#chatContainer", `
                    <div class="d-flex gap-1 mb-3 justify-content-end">
                    <small class='fa fa-trash-can text-danger user-name-small pt-2 delete-comment' dt=${Secure.encrypt(column.id)}></small>
                <div class="text-end">
                
                  <div class="bg-primary text-white p-1 shadow-sm" style="max-width: 100%; text-align:left;border-radius:5px;margin-bottom:-8px;">
                    <p class="mb-0 small">${column.message}</p>
                  </div>
                  <span class="text-secondary small" style="font-size: 0.6rem;">${CtrDATE.timeDif(column.created_at)}</span>
                </div>
                ${img}
              </div>
                    `);
                }else{
                    $$.add_html("#chatContainer", `
                    <div class="d-flex gap-1 mb-3 d-flex-vcenter">
                ${img}
                <div>
                <b><small class='user-name-small'>${column.sender}</small></b>
                  <div class="bg-white rounded-4 p-1 shadow-sm" style="max-width: 100%; margin-bottom:-8px;">
                    <p class="mb-0 small">${column.message}</p>
                  </div>
                  <span class="text-secondary small" style="font-size: 0.6rem;">${CtrDATE.timeDif(column.created_at)}</span>
                </div>
              </div>
                    `);
                }
            });

            if(clearChat){
                $$.set_value("#msg", null);
            }
            setTimeout(() => {
                if(clearChat){
                    $$.element_auto_scroll_bottom("#chatContainer", -500);
                    $$.scroll_to_bottom();
                }
                $$.click(".delete-comment", (btn, attr)=>{
                    Twal.ask("Do you want to delete this comment?", function(){
                        Tyrax.delete({
                            url: "chat/delete",
                            params: {id: Secure.decrypt(attr.dt)},
                            res: (send, code)=>{
                                if(code == 200){
                                    receivedChat(true);
                                }
                            }
                        })
                    });
                });
            }, 500);
        }
    });
}

receivedChat(true);