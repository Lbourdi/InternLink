<x-layout>
    <h1 class="text-2xl font-bold mb-4">Offres de stage disponibles</h1>

    <!-- Formulaire de filtres GET -->
    <form method="GET" action="{{ route('offers.index') }}" class="mb-6 flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Recherche par titre..." class="border rounded px-3 py-2 w-1/3">

        <select name="skills[]" multiple class="border rounded px-3 py-2 w-1/3">
            @foreach($allSkills as $skill)
                <option value="{{ $skill->id }}" @if(collect(request('skills'))->contains($skill->id)) selected @endif>{{ $skill->name }}</option>
            @endforeach
        </select>

        <select name="sort" class="border rounded px-3 py-2">
            <option value="">Trier</option>
            <option value="applications_desc" @if(request('sort')=='applications_desc') selected @endif>Plus de candidatures</option>
            <option value="applications_asc" @if(request('sort')=='applications_asc') selected @endif>Moins de candidatures</option>
            <option value="title_asc" @if(request('sort')=='title_asc') selected @endif>Nom A→Z</option>
            <option value="title_desc" @if(request('sort')=='title_desc') selected @endif>Nom Z→A</option>
        </select>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Filtrer</button>
    </form>

    @foreach ($offers as $offer)
        <div class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-lg font-semibold">
                <a href="/offers/{{ $offer->id }}">
                    {{ $offer->title }}
                </a>
            </h2>
            <p class="text-sm text-gray-600">{{ $offer->company_name }}</p>

            <!-- Badges skills -->
            <div class="mt-2">
                @foreach($offer->skills as $skill)
                    <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded mr-2">{{ $skill->name }}</span>
                @endforeach
            </div>

            <div class="mt-2 text-sm text-gray-500">Candidatures : {{ $offer->applications_count ?? 0 }}</div>
        </div>
    @endforeach

    <div class="mt-6">
        {{ $offers->links() }}
    </div>
</x-layout>
