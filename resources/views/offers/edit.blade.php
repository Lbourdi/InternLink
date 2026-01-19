<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier l'offre</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('offers.update', $offer) }}">
                    @csrf
                    @method('PATCH') <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Titre du poste</label>
                        <input type="text" name="title" value="{{ $offer->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nom de l'entreprise</label>
                        <input type="text" name="company_name" value="{{ $offer->company_name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>{{ $offer->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Compétences requises</label>
                        <select name="skills[]" multiple class="border rounded w-full py-2 px-3">
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" @if($offer->skills->contains('id', $skill->id)) selected @endif>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                            Mettre à jour
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
