const ACTIVATE_NOTIFICATIONS = true;
$(document).ready(function () {
    if (ACTIVATE_NOTIFICATIONS) {
        const pendingCounterUrl = document
            .querySelector('meta[name="pending-counter-url"]')
            .getAttribute("content");

        getPendingCounter(pendingCounterUrl)
        setInterval(getPendingCounter, 10_000, pendingCounterUrl);
    }
});

function getPendingCounter(pendingCounterUrl)
{
    fetch(pendingCounterUrl)
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            document.querySelector(
                "#payment_menu_id"
            ).children[0].children[1].children[0].innerHTML = data;
        });
}