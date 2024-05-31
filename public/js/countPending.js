const ACTIVATE_NOTIFICATIONS = true;
$(document).ready(function () {
    if (ACTIVATE_NOTIFICATIONS) {
        const loanCount = document
            .querySelector('meta[name="loan-count"]')
            .getAttribute("content");
        const pendingCounterUrl = document
            .querySelector('meta[name="pending-counter-url"]')
            .getAttribute("content");
        document.querySelector(
            "#payment_menu_id"
        ).children[0].children[1].children[0].innerHTML = loanCount;
        setInterval(() => {
            fetch(pendingCounterUrl)
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    document.querySelector(
                        "#payment_menu_id"
                    ).children[0].children[1].children[0].innerHTML = data;
                });
        }, 10_000);
    }
});
