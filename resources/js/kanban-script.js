document.addEventListener("DOMContentLoaded", function () {
    console.log("NiceAdmin Single Task Kanban System Clean Asset Ready.");

    const sendButtons = document.querySelectorAll('.btn-send-comment');
    sendButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const inputField = this.closest('.d-flex').querySelector('.text-comment-input');
            if (inputField && inputField.value.trim() !== "") {
                alert("Comment Log Saved: " + inputField.value);
                inputField.value = "";
            }
        });
    });
});