<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if (Auth::user()->role === 'student')
                    {{ __('Mes Candidatures') }}
                @else
                    {{ __('Gestion des Offres') }}
                @endif
            </h2>

            @can('create-offer')
                <a href="{{ route('offers.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    + Nouvelle offre
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Vue étudiant --}}
                    @if (Auth::user()->role === 'student')

                        @if (isset($applications) && $applications->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Offre postulée</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entreprise</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Date d'envoi</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($applications as $app)
                                        <tr>
                                            <td class="px-6 py-4 font-bold text-indigo-600">
                                                <a href="{{ route('offers.show', $app->offer->id) }}" class="hover:underline">
                                                    {{ $app->offer->title }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4">{{ $app->offer->company_name }}</td>
                                            <td class="px-6 py-4 text-right text-sm text-gray-500">
                                                {{ $app->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Envoyée</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-10">
                                <p class="text-gray-500 mb-4">Vous n'avez pas encore postulé à des offres.</p>
                                <a href="/" class="text-indigo-600 underline">Voir les offres disponibles</a>
                            </div>
                        @endif

                    {{-- Vue entreprise --}}
                    @else

                        {{-- Barre de filtres pour l'entreprise --}}
                        <form method="GET" action="{{ route('dashboard') }}" class="mb-6 flex gap-2">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Recherche par titre..." class="border rounded px-3 py-2 w-1/3">

                            <select name="skills[]" multiple class="border rounded px-3 py-2 w-1/3">
                                @foreach ($allSkills as $skill)
                                    <option value="{{ $skill->id }}" @if (collect(request('skills'))->contains($skill->id)) selected @endif>{{ $skill->name }}</option>
                                @endforeach
                            </select>

                            <select name="sort" class="border rounded px-3 py-2">
                                <option value="">Trier</option>
                                <option value="applications_desc" @selected(request('sort') == 'applications_desc')>Plus de candidatures</option>
                                <option value="applications_asc" @selected(request('sort') == 'applications_asc')>Moins de candidatures</option>
                                <option value="title_asc" @selected(request('sort') == 'title_asc')>Nom A→Z</option>
                                <option value="title_desc" @selected(request('sort') == 'title_desc')>Nom Z→A</option>
                            </select>

                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Filtrer</button>
                        </form>

                        @if (isset($offers) && $offers->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entreprise</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Compétences</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Candidatures</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($offers as $offer)
                                        <tr>
                                            <td class="px-6 py-4 font-bold">{{ $offer->title }}</td>
                                            <td class="px-6 py-4">{{ $offer->company_name }}</td>
                                            <td class="px-6 py-4">
                                                @foreach ($offer->skills as $skill)
                                                    <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded mr-2">{{ $skill->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 text-right">{{ $offer->applications_count }}</td>
                                            <td class="px-6 py-4 text-right text-sm font-medium">
                                                <a href="{{ route('offers.edit', $offer) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Modifier</a>
                                                <form action="{{ route('offers.destroy', $offer) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination si disponible --}}
                            @if (method_exists($offers, 'links'))
                                <div class="mt-4">{{ $offers->links() }}</div>
                            @endif

                        @else
                            <div class="text-center py-10">
                                <p class="text-gray-500 mb-4">Vous n'avez publié aucune offre.</p>
                                <a href="{{ route('offers.create') }}" class="text-indigo-600 underline">Créer votre première offre</a>
                            </div>
                        @endif

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

