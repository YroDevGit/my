import $$ from "../../code/src/mods/ctrx/ctrx.js";
import Twal from "../../code/src/mods/twal.js";
import Tyrax from "../../code/src/tyrux/main.js";
import { getStatus } from "./status.js";

export function showComments(id){
    Tyrax.get({
        url: "task/getRoute",
        loading: {element: "#commentArea", size: 30},
        params: {id: id},
        res: (send, code, message, data, errors)=>{
            $$.set_html("#commentArea", null);
            let myId = send.my;
            if(data){
                data.forEach(column => {
                    if(column.type == 0){
                        $$.add_html("#commentArea", `
                    <div class="d-flex gap-3 mb-3">
                        <span class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; font-weight: 600; color: #1b3a6b; font-size: 0.75rem;">JD</span>
                        <div>
                            <div class="fw-semibold small">${column.byname} <span class="text-secondary fw-normal">· ${CtrDATE.timeDif(column.created_at)}</span></div>
                            <p class="text-secondary small mb-0">Change Status to <b class='text-${getStatus(column.status).color}'>${getStatus(column.status).text}</b>.</p>
                        </div>
                    </div>`);
                    return;
                    }

                    if(column.type == 1){
                        $$.add_html("#commentArea", `
                    <div class="d-flex gap-3 mb-3">
                        <span class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; font-weight: 600; color: #1b3a6b; font-size: 0.75rem;">JD</span>
                        <div>
                            <div class="fw-semibold small">${column.byname} <span class="text-secondary fw-normal">· ${CtrDATE.timeDif(column.created_at)}</span></div>
                            <p class="text-secondary small mb-0">Assigned to <b>${$$.val(column.assignee, "None")}</b>.</p>
                        </div>
                    </div>`);
                    return;
                    }

                    if(column.type == 2){
                        let trash =``;
                        if(myId == column.by){
                            trash = `<small class='fas fa-trash-can text-danger ms-1 deleteComment' taskcode="${id}" trashcode="${column.id}"></small>`;
                        }

                        $$.add_html("#commentArea", `
                    <div class="d-flex gap-3 mb-3">
                        <span class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; font-weight: 600; color: #1b3a6b; font-size: 0.75rem;">JD</span>
                        <div>
                            <div class="fw-semibold small">${column.byname} <span class="text-secondary fw-normal">· ${CtrDATE.timeDif(column.created_at)}</span>${trash}</div>
                            <p class="text-secondary small mb-0">${column.comment}</p>
                        </div>
                    </div>`);
                    return;
                    }

                    if(column.type == 3){
                        $$.add_html("#commentArea", `
                    <div class="d-flex gap-3 mb-3">
                        <span class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; font-weight: 600; color: #1b3a6b; font-size: 0.75rem;">JD</span>
                        <div>
                            <div class="fw-semibold small">${column.byname} <span class="text-secondary fw-normal">· ${CtrDATE.timeDif(column.created_at)}</span></div>
                            <p class="text-secondary small mb-0"><b class='text-primary'>Created this task</b>.</p>
                        </div>
                    </div>`);
                    return;
                    }
                });
                $$.click(".deleteComment", (ele, attr)=>{
                    Twal.ask("Are you sure to delete this comment?", ()=>{
                        Tyrax.delete({
                            url: "task/deleteComment",
                            params: {id : attr.trashcode},
                            res: (send, code)=>{
                                showComments(attr.taskcode);
                            }
                        })
                    })
                });

                $$.element_auto_scroll_bottom("#commentArea");
            }
        }
    });
}