const container = document.getElementById('ct');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

if (registerBtn) {
    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
        localStorage.setItem('action', 'login')
    });
}
if (loginBtn) {
    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
        localStorage.setItem('action', 'register')
    });
}

if (registerBtn && loginBtn) {
    //Affichage du formulaire par chargé dernièrement
    let action = localStorage.getItem('action');
    if (action === 'login') {
        registerBtn.click();
    }

}

//Affiche du message du cache

const toastElement = document.getElementById('liveToast')
const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastElement)

let message = localStorage.getItem('message');
let type = localStorage.getItem('type');
if (message && type) {
    toastElement.querySelector('#message').innerText = message
    toastElement.querySelector('#message').classList.add(`text-${type}`)
    toastBootstrap.show()
    localStorage.removeItem('message')
    localStorage.removeItem('type')
}