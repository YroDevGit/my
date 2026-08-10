import Ctr from "../../code/src/mods/ctr";
import { Twal } from "../../code/src/mods/twal";

Ctr.click(".logout-btn", ()=>{
    Twal.ask("Do you want to log out?", "/ctrx/logout");
});