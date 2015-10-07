<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="{{route('checkout.index')}}">Point Of Sale</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{App\Services::isActive(Route::Current(), 'checkout')}}"><a href="{{route('checkout.index')}}">Checkout</a></li>

                @can('index', new App\Product())
                <li class="{{App\Services::isActive(Route::Current(), 'product')}}"><a href="{{route('product.index')}}">Products</a></li>
                @endcan
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(auth()->check())
                    <li><a href="{{route('logout')}}">Logout</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>