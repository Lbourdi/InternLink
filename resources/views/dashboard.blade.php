<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(Auth::user()->role === 'student')
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
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- ========================================== --}}
                    {{-- PARTIE 1 : VUE ÉTUDIANT --}}
                    {{-- ========================================== --}}
                    @if(Auth::user()->role === 'student')
                        
                        @if(isset($applications) && $applications->count() > 0)
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
                                    @foreach($applications as $app)
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
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Envoyée
                                            </span>
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

                    {{-- ========================================== --}}
                    {{-- PARTIE 2 : VUE ENTREPRISE --}}
                    {{-- ========================================== --}}
                    @else
                        
                        @if(Auth::user()->offers->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entreprise</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(Auth::user()->offers as $offer)
                                    <tr>
                                        <td class="px-6 py-4 font-bold">{{ $offer->title }}</td>
                                        <td class="px-6 py-4">{{ $offer->company_name }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <a href="{{ route('offers.edit', $offer) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Modifier</a>
                                            <form action="{{ route('offers.destroy', $offer) }}" method="POST" class="inline-block">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="px-6 py-2 border-b mb-4">
                                            <div class="text-sm text-gray-700">
                                                <strong>Candidatures ({{ $offer->applications->count() }}) :</strong>
                                                
                                                @if($offer->applications->count() > 0)
                                                    <ul class="list-none ml-4 mt-2 space-y-1">
                                                        @foreach($offer->applications as $app)
                                                            <li class="flex items-center">
                                                                <span class="mr-2">• {{ $app->user->name }}</span>
                                                                <span class="text-gray-500 text-xs mr-2">({{ $app->user->email }})</span>
                                                                
                                                                @if($app->user->cv_path)
                                                                    <a href="{{ asset('storage/' . $app->user->cv_path) }}" target="_blank" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 hover:bg-red-200 transition">
                                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                                        CV PDF
                                                                    </a>
                                                                @else
                                                                    <span class="text-gray-400 text-xs italic">(Pas de CV)</span>
                                                                @endif

                                                                <span class="text-xs text-gray-400 ml-auto">Reçu le {{ $app->created_at->format('d/m/Y') }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-gray-400 italic text-xs ml-2">Aucun candidat pour le moment.</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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