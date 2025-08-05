@php
    $segments = Request::segments(); 
@endphp

<nav class="text-gray-700 text-sm mb-4">
    <ol class="list-reset flex">
        <li>
            <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Home</a>
        </li>
        @foreach ($segments as $index => $segment)
            <li><span class="mx-2">/</span></li>
            <li>
                @php
                    $link = url(implode('/', array_slice($segments, 0, $index + 1)));
                    $name = ucwords(str_replace('-', ' ', $segment));
                @endphp

                @if ($loop->last)
                    <span class="text-gray-500">{{ $name }}</span>
                @else
                    <a href="{{ $link }}" class="text-blue-600 hover:underline">{{ $name }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
