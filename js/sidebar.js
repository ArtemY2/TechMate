document.addEventListener("DOMContentLoaded", function() {
    var sidebarItems = document.getElementsByClassName("sidebar-menu-item");

    for (var i = 0; i < sidebarItems.length; i++) {
        sidebarItems[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var subMenu = this.querySelector(".sub-menu");
            if (subMenu) {
                subMenu.classList.toggle("collapsed");
            }
        });
    }
});
