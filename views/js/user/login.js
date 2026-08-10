//Js file for user/login

import Ctr from "../../code/src/mods/ctr";
import FormValidator from "../../code/src/mods/formValidator";
import ImageSelector from "../../code/src/mods/picker/imageselector";
import { Twal } from "../../code/src/mods/twal";
import { Tyrax } from "../../code/src/tyrux/main";


Ctr.submit("#loginForm", (data, raw) => {
    Tyrax.post({
        url: "user/login",
        req: raw,
        loading: { id: "loginForm", size: 35 },
        res: (send, code, message, data, errors) => {
            if (code == 400) {
                FormValidator.displayErrors(errors, "#loginForm");
            }
            if(code == 401){
                Twal.err(message);
            }
            if(code == 200){
                Twal.ok("You are now logged in", true);
            }
        }
    });
});


Ctr.click("#togglePass", ()=>{
    togglePassword();
});

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}