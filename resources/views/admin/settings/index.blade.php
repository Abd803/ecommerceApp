@extends('admin.layout')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Paramètres du Site</h2>
        <p class="text-gray-500">Configuration générale de la boutique.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
        @csrf
        
        <div class="space-y-8">
            <!-- General Info -->
            <div>
                <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Informations Générales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nom du Site</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Ma Boutique' }}" class="w-full border rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Téléphone de Contact</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full border rounded-lg px-4 py-2">
                    </div>
                </div>
            </div>

            <!-- Integrations -->
            <div>
                <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Intégrations</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Facebook Pixel ID</label>
                        <input type="text" name="facebook_pixel_id" value="{{ $settings['facebook_pixel_id'] ?? '' }}" class="w-full border rounded-lg px-4 py-2 font-mono text-sm" placeholder="Ex: 1234567890">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Google Sheets Spreadsheet ID</label>
                        <input type="text" name="google_spreadsheet_id" value="{{ $settings['google_spreadsheet_id'] ?? '' }}" class="w-full border rounded-lg px-4 py-2 font-mono text-sm" placeholder="ID de la feuille de calcul">
                        <p class="text-xs text-gray-500 mt-1">L'ID se trouve dans l'URL de votre Google Sheet.</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    Sauvegarder les paramètres
                </button>
            </div>
        </div>
    </form>
@endsection
