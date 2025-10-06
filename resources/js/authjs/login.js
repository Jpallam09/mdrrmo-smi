const form = document.querySelector('form');
if (!form) throw new Error("Form not found");

const emailInput = form.email;
const passwordInput = form.password;
const emailDesc = document.getElementById('email-desc');
const passwordDesc = document.getElementById('password-desc');

if (!emailInput || !passwordInput || !emailDesc || !passwordDesc) {
  throw new Error("Required form elements not found");
}

// Validate email format
const validateEmail = () => {
  const valid = emailInput.validity.valid;
  emailDesc.style.display = valid ? 'none' : 'block';
  return valid;
};

// Validate password length
const validatePassword = () => {
  const valid = passwordInput.validity.valid;
  passwordDesc.style.display = valid ? 'none' : 'block';
  return valid;
};

// Event listeners for live validation
emailInput.addEventListener('input', validateEmail);
passwordInput.addEventListener('input', validatePassword);

// Form submit handler
form.addEventListener('submit', e => {
  const validEmail = validateEmail();
  const validPassword = validatePassword();

  // Block form submission if any field is invalid
  if (!validEmail || !validPassword) {
    e.preventDefault(); // only prevent when there’s an error
    if (!validEmail) {
      emailInput.focus();
    } else if (!validPassword) {
      passwordInput.focus();
    }
  }
});
