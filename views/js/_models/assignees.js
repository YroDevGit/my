import Tyrax from "../../code/src/tyrux/main.js";

export async function getAssignees(){
    return await Tyrax.async({
        url: "user/getG1",
        dataOnly: true
    });
}