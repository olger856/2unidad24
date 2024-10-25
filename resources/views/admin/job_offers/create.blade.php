<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-center text-gray-800">{{ isset($job_offer) ? 'Editar Oferta Laboral' : 'Crear Nueva Oferta Laboral' }}</h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <form action="{{ isset($job_offer) ? route('admin.job_offers.update', $job_offer->id) : route('admin.job_offers.store') }}" method="POST">
                    @csrf
                    @if(isset($job_offer))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="empresa_id" class="block text-gray-700">Empresa</label>
                        <select name="empresa_id" id="empresa_id" class="w-full border border-gray-300 p-2 rounded" required>
                            <option value="" disabled {{ !isset($job_offer) ? 'selected' : '' }}>Seleccione una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}" {{ isset($job_offer) && $job_offer->empresa_id == $empresa->id ? 'selected' : '' }}>
                                    {{ $empresa->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('empresa_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700">Título</label>
                        <input type="text" name="title" id="title" class="w-full border border-gray-300 p-2 rounded" value="{{ old('title', $job_offer->title ?? '') }}" required>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700">Descripción</label>
                        <textarea name="description" id="description" class="w-full border border-gray-300 p-2 rounded" required>{{ old('description', $job_offer->description ?? '') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-gray-700">Ubicación</label>
                        <input type="text" name="location" id="location" class="w-full border border-gray-300 p-2 rounded" value="{{ old('location', $job_offer->location ?? '') }}" required>
                        @error('location')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="salary" class="block text-gray-700">Salario</label>
                        <input type="number" step="0.01" name="salary" id="salary" class="w-full border border-gray-300 p-2 rounded" value="{{ old('salary', $job_offer->salary ?? '') }}">
                        @error('salary')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-700">Fecha de Inicio</label>
                        <input type="datetime-local" name="start_date" id="start_date" class="w-full border border-gray-300 p-2 rounded" value="{{ old('start_date', isset($job_offer) ? $job_offer->start_date->format('Y-m-d\TH:i') : '') }}">
                        @error('start_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-700">Fecha de Fin</label>
                        <input type="datetime-local" name="end_date" id="end_date" class="w-full border border-gray-300 p-2 rounded" value="{{ old('end_date', isset($job_offer) ? $job_offer->end_date->format('Y-m-d\TH:i') : '') }}">
                        @error('end_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 text-center">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ isset($job_offer) ? 'Actualizar' : 'Crear' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
