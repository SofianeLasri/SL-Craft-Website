<!--[Component] HeadBar-->
<div id="headbar">
    <div class="icon-container">
        <div id="headbar-popup-button" data-open="false" class="img" style="background-image:url('{{ asset('/images/navbar/hamburger-icon.svg')}}')"><span class="img" style="background-image:url('{{ asset('/images/navbar/Horizontal-bar.svg')}}')"></span></div>
        <!--TODO: ajouter au boutton un js click event pour dérouler le menu -->
        <div class="img logo" style="background-image:url('{{ asset('/images/logo/large-blanc.svg')}}')"></div>
    </div>

    <div class="account-container" id="account-container" data-logged="true">
        <div class="not-logged">
            <div class="login-button" id="login-button">
                <p>Se connecter</p>
            </div>
        </div>
        <div class="logged">
            <div class="notification-container" id="notification-container" data-open="false">
                <div class="icon">
                    <i class="fas fa-bell" style="color:var(--white); width: 40%; height: 40%;"></i>
                    <div id="notificationsNumber" class="label">n</div>
                </div>
                <div class="notification-content"></div>
            </div>
            <div class="user-container" id="user-action-dropdown" data-open="false">
                <div class="user-infos">
                    <img class="head img" id="playerHead" src="{{ asset('/images/navbar/loader.svg')}}">
                    <div class="infos">
                        <p id="username">Username</p>
                        <p id="userclass">Player</p>
                    </div>
                </div>
                <div class="img arrow"></div>
                <div class="drop-action-container"></div>
            </div>
        </div>
    </div>


</div>

@push('scripts')
<script type="text/javascript">
</script>
@endpush
