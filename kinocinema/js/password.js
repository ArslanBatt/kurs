function togglePasswordVisibility(element) {
    const passwordInput = element.previousElementSibling;
    if (!passwordInput || passwordInput.tagName.toLowerCase() !== 'input') return;

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        element.innerHTML = '<img src="../img/icon/open.png">';
    } else {
        passwordInput.type = "password";
        element.innerHTML = '<img src="../img/icon/close.png">';
    }
}
