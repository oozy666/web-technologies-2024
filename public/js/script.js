document.addEventListener('DOMContentLoaded', () => {
    const triggers = document.querySelectorAll('[data-toggle]');
    triggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            const parent = trigger.closest('[data-parent-node]');
            if (parent) {
                parent.classList.toggle('tree-node_open');
            }
        });
    });
});
