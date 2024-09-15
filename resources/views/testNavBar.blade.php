<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <a class="navbar-brand text-white" href="/home">CMS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse pr-5" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto text-center nav-ul  pl-4">
            <li class="nav-item text-center">
                <a class="nav-link text-white" href="/home"><i class="bi bi-house-fill nav-icon-size"></i><br>Home <span
                        class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/notification"><i
                        class="bi bi-bell-fill nav-icon-size"></i><br>Notification</a>
            </li>
  
            @if(auth()->check())
            <li class="nav-item text-center">
                <a class="nav-link text-white" href="/profile"><i class="bi bi-person-fill nav-icon-size"></i><br>Profile<span
                        class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item text-center">
                <a class="nav-link text-white" href="/logout"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right  nav-icon-size"></i><br>Sign out<span
                    class="sr-only">(current)</span></a>
            @else
            <li class="nav-item">
                <a class="nav-link text-white" href="/login"><i
                        class="bi bi-box-arrow-right nav-icon-size"></i> Sign in</a>
            </li>
            @endif
        </ul>
        <ul class="navbar-nav d-none d-lg-block">
            <li class="nav-item">
                <span class="nav-link text-white text-right">Signed in as <br>{{ auth()->user()->user_name }}
                </span>
            </li>
        </ul>
    </div>
  </nav>
  
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  