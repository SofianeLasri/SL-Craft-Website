function SetupSidebar() {
    const closeButton = document.getElementById("SidebarcloseButton");
    const mainContainer = document.getElementById("Container");


    closeButton.addEventListener("click", () => {
        var opened = mainContainer.dataset.Sidebaropen;
        mainContainer.dataset.Sidebaropen = (opened == "true" ? false : true);
    })

}

SetupSidebar()
