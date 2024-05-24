document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".btn-delete");
    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const itemId = this.getAttribute("data-id");
            Swal.fire({
                title: "You're sure?",
                text: "You won't be able to reverse this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${itemId}`).submit();
                }
            });
        });
    });
});
