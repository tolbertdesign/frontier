<div class="overlay"></div>

<!-- Sidebar -->
<nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
    <ul class="nav sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                Home
            </a>
        </li>
        <li>
            <a href="#">Pledges &amp; Sponsors</a>
        </li>
        <li>
            <a href="#">Go Fundraise</a>
        </li>
        <li>
            <a href="#">Add New Student</a>
        </li>
        <li>
            <a href="#">Enter Teacher Code</a>
        </li>
        <li class="dropdown">
            <a id="my-account-button" href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="dropdown-header"></li>
                <li><a href="#">Inbox</a></li>
                <li><a href="#">Help</a></li>
                <li><a id="logout-button" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                </li>
                <li></li>
            </ul>
        </li>
        <li>
            <a target="_blank" href="https://s3.amazonaws.com/funrun-prod/assets/pdf/spanish_guide_2017.pdf">¿Habla español?</a>
        </li>
    </ul>
</nav>
<!-- /#sidebar-wrapper -->
<button id="menu-button" type="button" class="hamburger is-closed" data-toggle="offcanvas">
    <span class="hamb-top"></span>
    <span class="hamb-middle"></span>
    <span class="hamb-bottom"></span>
</button>
