import Ctr from "../../code/src/mods/ctr.js";
import Twal from "../../code/src/mods/twal.js";

Ctr.click(".logout-btn", ()=>{
    Twal.ask("Do you want to log out?", "/ctrx/logout");
});