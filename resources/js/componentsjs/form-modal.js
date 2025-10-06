// --------- Typing animation ---------
document.addEventListener('DOMContentLoaded', () => {
  const typingText = document.getElementById('typing-text');
  if (!typingText) return;

  const phrases = [
    "Report incidents quickly and securely.",
    "Safeguard your community through timely reporting.",
    "Ensure transparency with every report submitted.",
    "Building safer communities through accountability."
  ];
  const typingSpeed = 50;  // ms per character
  const deletingSpeed = 10; // ms per character when deleting
  const pauseDelay = 1000;  // pause after typing full phrase
  const pauseBetween = 300; // pause after deleting before typing next phrase

  let phraseIndex = 0;
  let charIndex = 0;
  let isDeleting = false;

  function type() {
    const currentPhrase = phrases[phraseIndex];
    if (!isDeleting) {
      typingText.textContent = currentPhrase.substring(0, charIndex + 1);
      charIndex++;
      if (charIndex === currentPhrase.length) {
        setTimeout(() => {
          isDeleting = true;
          type();
        }, pauseDelay);
      } else {
        setTimeout(type, typingSpeed);
      }
    } else {
      typingText.textContent = currentPhrase.substring(0, charIndex - 1);
      charIndex--;
      if (charIndex === 0) {
        isDeleting = false;
        phraseIndex = (phraseIndex + 1) % phrases.length;
        setTimeout(type, pauseBetween);
      } else {
        setTimeout(type, deletingSpeed);
      }
    }
  }

  type();
});
