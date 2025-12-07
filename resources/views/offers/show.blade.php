<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $offer->title }} - InternLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-6">
        <a href="/" class="group flex items-center text-indigo-600 hover:text-indigo-900 font-medium transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour aux offres publiques
        </a>
        
        @auth
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                @if(Auth::user()->role === 'company')
                    🏢 Gérer mes offres
                @else
                    🎓 Mes candidatures
                @endif
            </a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 underline">
                Se connecter
            </a>
        @endauth
    </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h1 class="text-3xl font-bold leading-6 text-gray-900">
                    {{ $offer->title }}
                </h1>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Proposé par : <span class="font-semibold">{{ $offer->company_name }}</span>
                </p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Description du poste</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $offer->description }}
                        </dd>
                    </div>
                    
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Publié le</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $offer->created_at->format('d/m/Y à H:i') }}
                        </dd>
                    </div>
                </dl>
            </div>
            
            <div class="px-4 py-4 sm:px-6 bg-gray-50 text-right">
                @auth
                    @if(Auth::user()->role === 'student')
                        @if(Auth::user()->applications->contains('offer_id', $offer->id))
                            
                            <div class="inline-flex items-center px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-bold">Candidature envoyée</span>
                            </div>

                        {{-- B. Sinon, on affiche le bouton pour postuler --}}
                        @else
                            
                            @if(session('success'))
                                <div class="mb-4 text-green-600 font-bold">✅ {{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="mb-4 text-red-600 font-bold">⚠️ {{ session('error') }}</div>
                            @endif

                            <form method="POST" action="{{ route('offers.apply', $offer) }}">
                                @csrf 
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition shadow-lg flex items-center ml-auto">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Postuler maintenant
                                </button>
                            </form>

                        @endif

                    @elseif(Auth::user()->role === 'company')
                        <span class="text-sm text-gray-500 italic mr-4">
                            Compte Entreprise (Mode lecture)
                        </span>
                        <a href="{{ route('dashboard') }}" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
                            Gérer mes offres
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-indigo-600 underline">Connectez-vous pour postuler</a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>