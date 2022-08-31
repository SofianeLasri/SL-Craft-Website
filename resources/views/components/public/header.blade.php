<!-- Navbar -->
<div id="desktopNavbar" class="navbar">
    <!-- Cette partie est résrvée à l'affichage du profil utilisateur -->
    <div class="upperPart">
        <nav class="container">
            <a class="nav-link" href="#">Se connecter</a>
        </nav>
    </div>

    <!-- Cette partie est résrvée à l'affichage des liens du site -->
    <div class="lowerPart">
        <div class="container">
            <button id="mobileNavButton" type="button">
                <img src="{{ asset('/images/navbar/hamburger-icon.png') }}" alt="Menu"/>
            </button>
            <div class="siteLogo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('/images/logo/large-blanc.svg') }}" alt="Logo">
                </a>
            </div>

            <div class="desktopNavLinksContainer">
                <ul>
                    <li navLinkWithIcon="menu-buy">
                        <a href="https://live.mc.sl-projects.com/" class="nav-link" target="_blank">
                            <i class="nav-icon">
                                <img src="{{ asset('/images/navbar/menu-buy.png') }}" alt="Join icon">
                            </i>
                            Carte du monde
                        </a>
                    </li>
                    <li navLinkWithIcon="menu-comm">
                        <a href="https://discord.gg/9PYvGFDmDt" class="nav-link" target="_blank">
                            <i class="nav-icon">
                                <img src="{{ asset('/images/navbar/menu-comm.svg') }}" alt="Community icon">
                            </i>
                            Communauté
                        </a>
                    </li>
                    <li navLinkWithIcon="menu-store">
                        <a href="{{ url('/') }}/shop" class="nav-link">
                            <i class="nav-icon">
                                <img src="{{ asset('/images/navbar/menu-store.svg') }}" alt="Community icon">
                            </i>
                            Liste des magasins
                        </a>
                    </li>
                    <li navLinkWithIcon="menu-support">
                        <a href="{{ url('/') }}/staff" class="nav-link">
                            <i class="nav-icon">
                                <img src="{{ asset('/images/navbar/menu-support.svg') }}" alt="Staff icon">
                            </i>
                            Obtenir de l'aide
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Navbar -->

@push('scripts')
<script type="text/javascript">
    // Ne doit s'exécuter que sur les pc
    if(window.matchMedia("(min-width: 1024px)").matches){
        // Ici on va ajouter les évènements d'entrée et sortie de la souris sur les liens de la navbar
        const navLinksWithIcon = document.querySelectorAll('[navLinkWithIcon]');

        // On les parcours pour ajouter les évènements
        navLinksWithIcon.forEach(function(navLinkWithIcon) {
            navLinkWithIcon.addEventListener('mouseenter', function() {
                navLinkWithIcon.getElementsByTagName('img')[0].src =
                    "{{ url('/') }}/images/navbar/" + navLinkWithIcon.getAttribute('navLinkWithIcon') + ".gif";
            });
            navLinkWithIcon.addEventListener('mouseleave', function() {
                navLinkWithIcon.getElementsByTagName('img')[0].src =
                    "{{ url('/') }}/images/navbar/" + navLinkWithIcon.getAttribute('navLinkWithIcon') + "--reversed.gif";
            });
        });
    }
</script>
@endpush
