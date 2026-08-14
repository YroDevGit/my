import { Tyrax } from "../../code/src/tyrux/main";

export async function noteCategories(){
    let result = await Tyrax.async({
        url: "note/get",
        dataOnly: true
    });
    return result;
}