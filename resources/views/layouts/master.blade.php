<!-- Nemesus World User Control Panel (GTA5 - RageMP) -->
<!-- Das UCP wurde von https://nemesus.de erstellt -->
<!-- Download: https://nemesus-world.de -->
<!-- Discord: https://discord.nemesus.de -->
<!-- Bei Fragen gerne an info@nemesus.de wenden! -->

<!DOCTYPE html>
<html lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nemesus World | User Control Panel by Nemesus.de</title>
    <link rel="icon" type="image/png" href="{{asset('images/favicon.ico')}}" />
    @include('layouts.template-parts.head-scripts')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper" style="visibility: hidden" name="showDarkmode" id="showDarkmode">
        @include('layouts.template-parts.navbar')
        @include('layouts.template-parts.sidebar')
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('layouts.template-parts.footer')
    </div>
    @include('layouts.template-parts.footer-scripts')
    @stack('scripts')
</body>
</html>
<script>
var currentTheme = getCookie('nemesusworlducp_theme');
var mainHeader = document.querySelector('.main-header');
if (currentTheme) {
    if (currentTheme === 'dark') {
        if (!document.body.classList.contains('dark-mode')) {
            document.body.classList.add("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-light')) {
            mainHeader.classList.add('navbar-dark');
            mainHeader.classList.remove('navbar-light');
        }
    }
}

function switchTheme() {
    if (getCookie('nemesusworlducp_theme') == 'light') {
        if (!document.body.classList.contains('dark-mode')) {
            document.body.classList.add("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-light')) {
            mainHeader.classList.add('navbar-dark');
            mainHeader.classList.remove('navbar-light');
        }
    } else {
        if (document.body.classList.contains('dark-mode')) {
            document.body.classList.remove("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-dark')) {
            mainHeader.classList.add('navbar-light');
            mainHeader.classList.remove('navbar-dark');
        }
    }
}

document.getElementById("showDarkmode").style.visibility = "visible";
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
</script>
