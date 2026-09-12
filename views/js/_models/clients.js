import Tyrax from "../../code/src/tyrux/main.js";

export async function getAllClients(){
    return await Tyrax.async({
        url: "client/get",
        dataOnly: true
    });
}