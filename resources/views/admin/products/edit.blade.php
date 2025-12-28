@extends('admin.layout')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">← Retour aux produits</a>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">Éditer: {{ $product->name }}</h2>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" 
          class="bg-white rounded-xl shadow-sm border border-gray-100 p-8"
          x-data="{ features: {{ json_encode($product->features ?? ['']) }}, models: {{ json_encode($product->available_models ?? ['']) }} }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nom du produit</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Slug URL (Laissez tel quel pour ne pas changer)</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Prix (DA)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Description Courte</label>
                    <textarea name="short_description" rows="3" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('short_description', $product->short_description) }}</textarea>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Description Complète</label>
                    <textarea name="description" rows="10" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Image Principale (Laisser vide pour garder l'actuelle)</label>
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->main_image) }}" class="w-32 h-32 object-cover rounded-lg border" alt="">
                    </div>
                    <input type="file" name="main_image" class="w-full border rounded-lg px-4 py-2" accept="image/*">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Ajouter des Images Secondaires</label>
                    <div class="flex gap-2 mb-2 flex-wrap">
                        @if($product->secondary_images)
                            @foreach($product->secondary_images as $img)
                                <img src="{{ asset('storage/' . $img) }}" class="w-16 h-16 object-cover rounded border" alt="">
                            @endforeach
                        @endif
                    </div>
                    <input type="file" name="secondary_images[]" multiple class="w-full border rounded-lg px-4 py-2" accept="image/*">
                </div>
                
                <div class="border-t pt-6">
                    <label class="block text-gray-700 font-bold mb-2">Caractéristiques</label>
                    <div class="space-y-2">
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="flex gap-2">
                                <input type="text" :name="'features[' + index + ']'" x-model="features[index]"
                                       class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <button type="button" @click="features.splice(index, 1)" class="text-red-500 px-2" x-show="features.length > 1">×</button>
                            </div>
                        </template>
                        <button type="button" @click="features.push('')" class="text-blue-600 text-sm font-medium">+ Ajouter une ligne</button>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <label class="block text-gray-700 font-bold mb-2">Modèles Disponibles / Couleurs</label>
                    <div class="space-y-2">
                        <template x-for="(model, index) in models" :key="index">
                            <div class="flex gap-2">
                                <input type="text" :name="'available_models[' + index + ']'" x-model="models[index]" placeholder="Ex: Rouge, XL..."
                                       class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <button type="button" @click="models.splice(index, 1)" class="text-red-500 px-2" x-show="models.length > 1">×</button>
                            </div>
                        </template>
                        <button type="button" @click="models.push('')" class="text-indigo-600 text-sm font-medium">+ Ajouter un modèle</button>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <label class="flex items-center space-x-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="w-5 h-5 text-blue-600 rounded">
                        <span class="text-gray-700 font-medium">Produit Actif (Visible sur le site)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="border-t pt-6 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                Mettre à jour le produit
            </button>
        </div>
    </form>
@endsection
