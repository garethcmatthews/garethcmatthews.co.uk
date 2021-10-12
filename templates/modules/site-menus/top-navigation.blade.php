<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">{{ $title }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#links-nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-1 text-right" id="links-nav">
            <ul class="navbar-nav ms-auto flex-nowrap">
                @foreach ($menu as $rootItem)
                    <div class="topnav-item-wrapper">
                        <li class="nav-item">
                            <a class="nav-link @if (request()->is($rootItem['routename'])) active @endif" href="{{ route($rootItem['routename'], [$rootItem['parameters']]) }}">{{ $rootItem['title'] }}</a>
                        </li>
                    </div>
                    @if ($rootItem['routename'] === Route::currentRouteName())
                        @isset($rootItem['children'])
                            @foreach ($rootItem['children'] as $secondaryItem)
                                @if ($secondaryItem['children'] === null)
                                    <li class="nav-item">
                                        <a class="nav-link @if (request()->is($secondaryItem['routename'])) active @endif" href="{{ route($secondaryItem['routename'], [$secondaryItem['parameters']]) }}">{{ $secondaryItem['title'] }}</a>
                                    </li>
                                @else
                                    <li class="nav-item dropdown">
                                        <a class="nav-link @if (request()->is($secondaryItem['routename'] . '/' . strtok($secondaryItem['parameters'], '-') . '*')) active @endif" href="{{ route($secondaryItem['routename'], [$secondaryItem['parameters']]) }}" data-bs-toggle="dropdown">{{ $secondaryItem['title'] }}</a>
                                        <ul class="dropdown-menu shadow-lg dropdown-menu-dark dropdown-menu-end dropdown-menu-lg-start">
                                            <a class="dropdown-item" href="{{ route($secondaryItem['routename'], [$secondaryItem['parameters']]) }}">{{ $secondaryItem['title'] }}</a>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            @isset($secondaryItem['children'])
                                                @foreach ($secondaryItem['children'] as $tertiaryItem)
                                                    <li><a class="dropdown-item @if (request()->is(trim(route($tertiaryItem['routename'],[$tertiaryItem['parameters']], false) , '/'))) active @endif" href="{{ route($tertiaryItem['routename'], [$tertiaryItem['parameters']]) }}">{{ $tertiaryItem['title'] }}</a>
                                                    </li>
                                                @endforeach
                                            @endisset
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        @endisset
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
