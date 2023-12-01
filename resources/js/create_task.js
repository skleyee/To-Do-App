document.addEventListener('DOMContentLoaded', function () {

    let categorySelect = document.getElementById('category');
    let newCategoryInput = document.getElementById('newCategory');

    categorySelect.addEventListener('change', function () {
        newCategoryInput.disabled = (categorySelect.value !== 'new');
    });
    newCategoryInput.addEventListener('input', function () {
        categorySelect.disabled = newCategoryInput.value.trim() !== '';
    });
});
