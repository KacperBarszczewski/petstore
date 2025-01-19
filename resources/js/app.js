import './bootstrap';

setTimeout(() => {
    const alert = document.getElementById('alert');
    if (alert) {
        alert.classList.add('opacity-0');
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);

document.getElementById('add-tag').addEventListener('click', function() {
    var container = document.getElementById('tags-container');
    var inputCount = container.getElementsByTagName('input').length;
    var newInput = document.createElement('input');
    newInput.type = 'text';
    newInput.name = `tags[${inputCount}][name]`;
    newInput.classList.add('mt-1', 'block', 'w-full', 'border', 'border-gray-300', 'rounded-md', 'shadow-sm', 'focus:ring-blue-500', 'focus:border-blue-500', 'sm:text-sm', 'p-2');
    container.appendChild(newInput);
});