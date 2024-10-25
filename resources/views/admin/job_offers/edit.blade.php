<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-4 text-center text-gray-800">Editar Oferta Laboral</h1>

            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <form action="{{ route('admin.job_offers.update', $jobOffer) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700">Título</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $jobOffer->title) }}" class="w-full border border-gray-300 p-2 rounded" required>
                        @error('title')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700">Descripción</label>
                        <textarea name="description" id="description" class="w-full border border-gray-300 p-2 rounded" required>{{ old('description', $jobOffer->description) }}</textarea>
                        @error('description')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="empresa_id" class="block text-gray-700">Empresa</label>
                        <select name="empresa_id" id="empresa_id" class="w-full border border-gray-300 p-2 rounded" required>
                            <option value="" disabled>Seleccione una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}" {{ $jobOffer->empresa_id == $empresa->id ? 'selected' : '' }}>
                                    {{ $empresa->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('empresa_id')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-gray-700">Ubicación</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $jobOffer->location) }}" class="w-full border border-gray-300 p-2 rounded">
                        @error('location')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="salary" class="block text-gray-700">Salario</label>
                        <input type="number" name="salary" id="salary" value="{{ old('salary', $jobOffer->salary) }}" class="w-full border border-gray-300 p-2 rounded" step="0.01">
                        @error('salary')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700">Imagen</label>
                        <input type="file" name="image" id="image" class="w-full border border-gray-300 p-2 rounded">
                        @error('image')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        @if($jobOffer->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $jobOffer->image) }}" alt="Imagen de la oferta" class="w-32 h-32 object-cover">
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-700">Fecha de Inicio</label>
                        <input type="date" name="start_date" id="start_date" 
                               value="{{ old('start_date', optional($jobOffer->start_date)->format('Y-m-d')) }}" 
                               class="w-full border border-gray-300 p-2 rounded" required>
                        @error('start_date')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-700">Fecha de Fin</label>
                        <input type="date" name="end_date" id="end_date" 
                               value="{{ old('end_date', optional($jobOffer->end_date)->format('Y-m-d')) }}" 
                               class="w-full border border-gray-300 p-2 rounded" required>
                        @error('end_date')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-4 py-2 rounded">Actualizar Oferta</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
