/**
 * Preloader
 */

window.addEventListener('DOMContentLoaded', () => {


    document.querySelectorAll('form').forEach(form => {
        form.setAttribute('novalidate', '1')
        form.addEventListener("submit", function (event) {


            let password_element = form.querySelector("[name='password']");
            let confirm_element = form.querySelector("[name='confirm']");

            if (password_element && confirm_element) {

                validate_password_confirmation(password_element, confirm_element)

                if (!form.classList.contains('was-validated')) {
                    password_element.addEventListener('change', function () {
                        validate_password_confirmation(password_element, confirm_element)
                    })
                    confirm_element.addEventListener('change', function () {
                        validate_password_confirmation(password_element, confirm_element)
                    })
                }
            }


            form.classList.add("was-validated");

            if (!form.checkValidity()) {
                event.preventDefault();
            }
        }, false);
    })



});


/**
 *
 * @param password_element {HTMLInputElement}
 * @param confirm_element {HTMLInputElement}
 */
function validate_password_confirmation(password_element, confirm_element) {
    if (password_element.value !== confirm_element.value) {
        confirm_element.setCustomValidity('Les mots de passes ne correspondent pas')
    } else {
        confirm_element.setCustomValidity('');
    }
}

