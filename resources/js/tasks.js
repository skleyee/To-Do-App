let delete_buttons = document.getElementsByClassName('remove');
let is_complete_checkboxes = document.getElementsByClassName('is_complete');
document.addEventListener('DOMContentLoaded', function () {
    const csrf_token = document.querySelector('input[name="_token"]').value;

    for(let elem of delete_buttons)
    {
        elem.addEventListener('click', function()
        {
            axios.post('delete_task', {'task_id' : elem.id}, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf_token,
                }
            })
                .then(function (response) {
                    if (response.data.redirect) {
                        window.location.href = response.data.redirect;
                    }
                })
                .catch(function (error) {
                    alert(error.message);
                });
        })
    }
    for (let checkbox of is_complete_checkboxes)
    {
        checkbox.addEventListener('click', function () {
            console.log(checkbox.checked);
            axios.post('complete_task', {'task_id' : checkbox.id, 'is_complete' : checkbox.checked}, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf_token,
                }
            })
                .then(function (response) {
                    let liElem = checkbox.parentNode.parentNode.parentNode;
                    checkbox.checked === true ? liElem.classList.add('completed') : liElem.classList.remove('completed');
                })
                .catch(function (error) {
                    console.log('error')
                })
        });
    }
});



