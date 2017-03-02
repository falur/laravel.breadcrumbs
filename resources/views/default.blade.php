<ul class="breadcrumb">
    @foreach ($crumbs as $crumb)
    <li>
        @if ($crumb->url)
        <a href="{{ $crumb->url }}">
            {{ $crumb->title }}
        </a>
        @else
        <span>
            {{ $crumb->title }}
        </span>
        @endif
    </li>
    @endforeach
</ul>