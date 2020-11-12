document.addEventListener('DOMContentLoaded', () => {
    const dropdowns = document.querySelectorAll('#dropdown');

    dropdowns.forEach((dropdown) => {
        setupDropdown(dropdown);
    });
});

/**
 * @param {Element} dropdown
 */
function setupDropdown(dropdown) {
    const button = dropdown.querySelector('#button');
    const panel = dropdown.querySelector('#panel');

    button.addEventListener('click', (event) => {
        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');

            return;
        }

        panel.classList.add('hidden');
    });
}
