import './bootstrap';

const toggleMarkup = `
<svg class="icon-eye-open" viewBox="0 0 24 24" aria-hidden="true">
  <path d="M12 5C6.5 5 2.1 8.1 1 12c1.1 3.9 5.5 7 11 7s9.9-3.1 11-7c-1.1-3.9-5.5-7-11-7Zm0 12c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5Z"/>
  <circle cx="12" cy="12" r="2.6"/>
</svg>
<svg class="icon-eye-closed" viewBox="0 0 24 24" aria-hidden="true">
  <path d="M2.3 3.7 1 5l4.2 4.2C3.3 10.1 2 11.6 1 13c1.6 2.6 4.2 4.5 7.2 5.4l1.5 1.5 1.4-1.4 9.2 9.2 1.3-1.3L2.3 3.7Zm9.7 3.3c4.8 0 8.7 2.7 10 6-0.5 1.2-1.4 2.3-2.4 3.1l-1.5-1.5c0.6-0.8 0.9-1.7 0.9-2.6 0-2.8-2.2-5-5-5-0.9 0-1.8 0.2-2.6 0.7L9.8 6.1c0.7-0.1 1.4-0.1 2.2-0.1Zm0 3c1.1 0 2 0.9 2 2 0 0.2 0 0.4-0.1 0.6l-2.5-2.5c0.2-0.1 0.4-0.1 0.6-0.1Z"/>
  <path d="M7.1 11.6 5.6 10c-1 0.8-1.8 1.9-2.3 3 1.1 2.2 3.1 3.8 5.5 4.6l-1.3-1.3c-1.5-0.8-2.7-2-3.4-3.4 0.6-1 1.5-1.9 2.5-2.7Z"/>
</svg>
`;

const bindPasswordToggles = () => {
    const inputs = document.querySelectorAll('input[data-password-toggle="true"]');

    inputs.forEach((input) => {
        if (input.dataset.toggleBound === '1') {
            return;
        }

        input.dataset.toggleBound = '1';
        const wrapper = document.createElement('div');
        wrapper.className = 'password-field';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'password-toggle';
        button.setAttribute('aria-label', 'Show password');
        button.innerHTML = toggleMarkup;
        wrapper.appendChild(button);

        button.addEventListener('click', () => {
            const showing = input.type === 'password';
            input.type = showing ? 'text' : 'password';
            wrapper.classList.toggle('is-visible', showing);
            button.setAttribute('aria-label', showing ? 'Hide password' : 'Show password');
        });
    });
};

bindPasswordToggles();
