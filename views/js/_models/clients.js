import Tyrax from "../../code/src/tyrux/main";

export async function getAllClients(){
    return await Tyrax.async({
        url: "client/get",
        dataOnly: true
    });
}