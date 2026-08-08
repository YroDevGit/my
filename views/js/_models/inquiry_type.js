import { Tyrax } from "../../code/src/tyrux/main";


export async function inquiryTypes(){
    let results = await Tyrax.async({
        url: "inquiry_type/get"
    });
    
    if(results.code == 200){
        return results.data ?? [];
    }
    return [];
}