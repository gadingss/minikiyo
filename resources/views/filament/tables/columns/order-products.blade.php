<ul class="list-disc pl-4">
    @foreach ($getState() as $item)
        <li>{{ $item->product?->name }} <strong>(x{{ $item->quantity }})</strong></li>
    @endforeach
</ul>
