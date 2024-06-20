document.addEventListener("DOMContentLoaded", function () {
    var scrollToTopBtn = document.getElementById("scrollToTopBtn");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 20) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    });

    scrollToTopBtn.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});