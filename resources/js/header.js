function SetupHeader() {
    const notificationContainer = document.getElementById("notification-container");
    const popupButton = document.getElementById("headbar-popup-button");
    const accountContainer = document.getElementById("account-container");
    const loginButton = document.getElementById("login-button");
    const userActionDropdown = document.getElementById("user-action-dropdown")

    /*Left popup button*/
    popupButton.addEventListener("click", () => {
        const opened = popupButton.dataset.open;
        SetSideBar(opened !== "true");
    })



    /*Account*/
    /*TODO: connecter le systeme de compte pour récup les informations*/

    const isLogged = true;
    accountContainer.dataset.logged = isLogged;
    if (isLogged) {
        /**Setup Player data*/
        const user = {
            name: "gagafeee",
            notification: {0:0,0:0,0:0,0:0}
        }

        const playerHead = document.getElementById("playerHead");
        playerHead.src = "https://mc-heads.net/avatar/" + user.name;
        /**/
        /*Notification dropdown*/

        if(Object.keys(user.notification).length > 0){
            document.getElementById("notificationsNumber").innerHTML = Object.keys(user.notification).length;
        }else{
            document.getElementById("notificationsNumber").style.display = "none";
        }

        notificationContainer.addEventListener("click", () => {
            const opened = notificationContainer.dataset.open;
            if (opened === "true") {
                    notificationContainer.dataset.open = false;
                } else {
                    /*LoadNotification()*/
                    notificationContainer.dataset.open = true;
                    userActionDropdown.dataset.open = false;
                }
            })
            /**User action Dropdown */
            userActionDropdown.addEventListener("click", () => {
                const opened = userActionDropdown.dataset.open;
                if (opened === "true") {
                userActionDropdown.dataset.open = false;
            } else {
                userActionDropdown.dataset.open = true;
                notificationContainer.dataset.open = false;
            }
        })
    } else {
        loginButton.addEventListener("click", () => {
            window.location.href = "/login.html"
        })
    }



}



function SetSideBar(newPosition) {
    newPosition = (newPosition === true || newPosition === false ? newPosition : false);
    const popupButton = document.getElementById("headbar-popup-button");
    const sideMenu = document.getElementById("Sidemenu");
    sideMenu.dataset.open = newPosition;
    popupButton.dataset.open = newPosition;
}

SetupHeader();

