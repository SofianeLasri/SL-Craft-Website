@extends('layouts.layouts')

@section('head')
    <link rel="icon" type="image/svg+xml" href="{{ asset('/images/logo/favicon-blanc.svg') }}">
    <link rel="alternate icon" href="{{ asset('/images/logo/favicon-blanc.ico') }}">
    <link rel="mask-icon" href="{{ asset('/images/logo/favicon-blanc.svg') }}" color="#{{ config('app.meta_color') }}">
    <meta content="{{ config('app.name') }}" property="og:title" />
    <meta content="Rejoins-nous et découvre une communauté construite autour de l’amour pour la survie ! Récolte des
         ressources, vend les ou achètes-en pour toi aussi créer ton propre village!" property="og:description" />
    <meta content="{{ url('/') }}" property="og:url" />
    <meta content="{{ asset('/images/logo/favicon-color.png') }}" property="og:image" />
    <meta content="{{ config('app.meta_color') }}" name="theme-color"/>
@endsection



@section('body')
    <x-public.header></x-public.header>

    {{-- Je met la balise script ici car si je l'intègre avec un @push('scripts'), son insertion sur la page sera
     retardé. Cela résultera en une exécution retardée d'une à deux secondes sur la vitrine -> ça se voit avec les
     redimensionnements et la lecture vidéo. --}}
    <script type="text/javascript">
        // Constantes
        const websiteUrl = "{{ url('/') }}/";
        const vitrineIntroVideo = document.getElementById("vitrineIntroVideo");
        const introContainer = document.getElementsByClassName("intro-container")[0];
        const vitrineIntro = document.getElementsByClassName("vitrine-intro")[0];
        const vitrineBackgroundVideo = document.getElementById("vitrineBackgroundVideo");
        const introBackgroundTransition = document.getElementById("introBackgroundTransition");

        // On va regarder la correspondance en Média Query de l'écran pour afficher la vidéo appropriée
        window.mobileAndTabletCheck = function () {
            let check = false;
            (function (a) {
                if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
            })(navigator.userAgent || navigator.vendor || window.opera);
            return check;
        };

        const isMobileOrTablet = window.mobileAndTabletCheck();
        const screenWithouDPI = window.screen.width * window.devicePixelRatio;

        if((isMobileOrTablet && window.matchMedia("(min-width: 2500px)").matches) || (!isMobileOrTablet && screenWithouDPI > 2500)){
            vitrineIntroVideo.src = websiteUrl+"videos/1440p-h264-crf30.mp4";
        }else if((isMobileOrTablet && window.matchMedia("(min-width: 1900px)").matches) || (!isMobileOrTablet && screenWithouDPI > 1900)){
            vitrineIntroVideo.src = websiteUrl+"videos/1080p-h264-crf30.mp4";
        }else{
            vitrineIntroVideo.src = websiteUrl+"videos/720p-h264-crf30.mp4";
        }
        vitrineIntroVideo.play();

        // Cette fonction se charge d'adapter le contenu de la page selon la dimension de l'écran
        function vitrineCssMediaQueries(){
            // On redimensionne le container de la vitrine pour qu'il match parfaitement bien avec la hauteur de l'écran
            // vitrineIntro.style.height = "-webkit-fill-available";
            introContainer.style.height = window.innerHeight - document.getElementsByClassName("navbar")[0].offsetHeight + "px";
            vitrineBackgroundVideo.style.height = vitrineIntro.offsetHeight + introBackgroundTransition.offsetHeight + "px";
            let dev = document.getElementById("dev");

            vitrineBackgroundVideo.style.top = document.getElementsByClassName("navbar")[0].offsetHeight + "px";
        }
        // On l'éxecute une fois pour initialiser la page
        vitrineCssMediaQueries();

        // Et on ajoute l'event pour que ça s'éxécute à chaque fois que la fenêtre change de taille
        // Ne doit pas s'appliquer aux appareils mobiles en raison de l'entète du navigateur
        if(!isMobileOrTablet){
            window.addEventListener('resize', vitrineCssMediaQueries);
        }
    </script>
@endsection
