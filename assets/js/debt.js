document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('click', function (event) {
        const target = event.target;
        if (target.matches('.js-debt-delete')) {
            const deleteUrl      = target.dataset.url;
            const debtPersonName = target.dataset.personName;
            const debtAmount     = target.dataset.amount;

            if (confirm(`Do you really want to delete ${debtAmount} debt from ${debtPersonName}?`)) {
                deleteDebt(deleteUrl)
                    .then(() => location.reload())
                    .catch(error => console.error(error));
            }
        }
    });
});

function deleteDebt(url = '') {
    return fetch(url, {
        method: 'DELETE',
    }).then(response => response.json());
}
