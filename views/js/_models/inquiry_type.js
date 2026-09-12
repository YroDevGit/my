import { Tyrux } from "../../code/src/tyrux/lib/tyrux.js";
import Tyrax from "../../code/src/tyrux/main.js";


export async function inquiryTypes(){
    let results = await Tyrax.async({
        url: "inquiry_type/get",
    });
    
    if(results.code == 200){
        return results.data ?? [];
    }
    return [];
}
