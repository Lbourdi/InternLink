<x-layout>
    <h1>Offres de stage disponibles</h1>

    @foreach ($offers as $offer)
        <div>
            <h2>
                <a href="/offers/{{ $offer->id }}">
                    {{ $offer->title }}
                </a>
            </h2>
            <p>{{ $offer->company_name }}</p>
        </div>
        <hr>
    @endforeach
</x-layout>