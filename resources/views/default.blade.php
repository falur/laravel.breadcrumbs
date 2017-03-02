<ul class="breadcrumb">
    @foreach ($crumbs as $crumb)
        <li>
            @if ($crumb->url)
                <a href="{{ $crumb->url }}">
                    {{ $crumb->name }}
                </a>
            @else
                <span>
                    {{ $crumb->name }}
                </span>
            @endif
        </li>
    @endforeach
</ul>