    const form = document.querySelector('form');
    const usernameInput = form.username;
    const emailInput = form.email;
    const phoneInput = form.phone;
    const passwordInput = form.password;
    const confirmPasswordInput = form['confirm-password'];

    const usernameDesc = document.getElementById('username-desc');
    const emailDesc = document.getElementById('email-desc');
    const phoneDesc = document.getElementById('phone-desc');
    const passwordDesc = document.getElementById('password-desc');
    const confirmPasswordDesc = document.getElementById('confirm-password-desc');

    const validateUsername = () => {
      const valid = usernameInput.validity.valid;
      usernameDesc.style.display = valid ? 'none' : 'block';
      return valid;
    };

    const validateEmail = () => {
      const valid = emailInput.validity.valid;
      emailDesc.style.display = valid ? 'none' : 'block';
      return valid;
    };

    const validatePhone = () => {
      if (!phoneInput.value) {
        phoneDesc.style.display = 'none'; // optional field
        return true;
      }
      const valid = phoneInput.validity.valid;
      phoneDesc.style.display = valid ? 'none' : 'block';
      return valid;
    };

    const validatePassword = () => {
      const valid = passwordInput.validity.valid;
      passwordDesc.style.display = valid ? 'none' : 'block';
      return valid;
    };

    const validateConfirmPassword = () => {
      const match = confirmPasswordInput.value === passwordInput.value && confirmPasswordInput.value.length > 0;
      confirmPasswordDesc.style.display = match ? 'none' : 'block';
      return match;
    };

    usernameInput.addEventListener('input', validateUsername);
    emailInput.addEventListener('input', validateEmail);
    phoneInput.addEventListener('input', validatePhone);
    passwordInput.addEventListener('input', () => {
      validatePassword();
      validateConfirmPassword();
    });
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);

    form.addEventListener('submit', e => {
      e.preventDefault();
      const validUsername = validateUsername();
      const validEmail = validateEmail();
      const validPhone = validatePhone();
      const validPassword = validatePassword();
      const validConfirm = validateConfirmPassword();

      if (validUsername && validEmail && validPhone && validPassword && validConfirm) {
        alert('Registration successful!');
        form.reset();
        usernameDesc.style.display = 'none';
        emailDesc.style.display = 'none';
        phoneDesc.style.display = 'none';
        passwordDesc.style.display = 'none';
        confirmPasswordDesc.style.display = 'none';
      } else {
        if (!validUsername) usernameInput.focus();
        else if (!validEmail) emailInput.focus();
        else if (!validPhone) phoneInput.focus();
        else if (!validPassword) passwordInput.focus();
        else if (!validConfirm) confirmPasswordInput.focus();
      }
    });
