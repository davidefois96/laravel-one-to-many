
    <nav class="navbar text-bg-dark py-4 px-4">
        <div class="container-fluid">

            <a href="{{route('home')}}" target="_blank" class=" text-decoration-none me-3 btn btn-outline-light">Vai al sito</a>


            <form action="{{route('logout')}}" method="POST" class="d-flex">
                @csrf
                <p class="me-3 my-auto ">{{Auth::user()->name}}</p>
                <button class="btn btn-danger text-white" type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
            </form>
        </div>
      </nav>




