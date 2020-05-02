let nav = $("#nav");
let navToggle = $("#navToggle");

navToggle.on("click", function (event) {
    event.preventDefault();// отмена действий браузера

    nav.toggleClass("show");

})