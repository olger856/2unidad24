<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            Ofertas Laborales
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="mb-4 flex items-center justify-between">
                    <a href="{{ route('admin.job_offers.create') }}" class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded transition duration-200">Crear Nueva Oferta</a>

                    <input type="text" id="search" class="border rounded p-2 w-1/3" placeholder="Buscar por título o empresa...">

                    <div class="relative inline-block text-left">
                        <div>
                            <button type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200" id="export-all-menu-button" aria-haspopup="true" onclick="toggleDropdown('export-all-menu')">
                                Exportar Todas
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m0 0l-4-4m4 4l4-4" />
                                </svg>
                            </button>
                        </div>

                        <div id="export-all-menu" class="absolute right-0 z-10 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden" role="menu" aria-orientation="vertical" aria-labelledby="export-all-menu-button">
                            <div class="py-1" role="none">
                                <a href="{{ route('admin.job_offers.export_all', ['format' => 'pdf']) }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100">Exportar a PDF</a>
                                <a href="{{ route('admin.job_offers.export_all', ['format' => 'csv']) }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100">Exportar a CSV</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="job-offers-list">
                    @forelse($job_offers as $offer)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $offer->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ Str::limit($offer->description, 100) }}</p>
                        <div class="mt-2">
                            <span class="text-gray-500 dark:text-gray-300">Empresa: {{ $offer->user ? $offer->user->name : 'Sin Empresa' }}</span><br>
                            <span class="text-gray-500 dark:text-gray-300">Ubicación: {{ $offer->location }}</span><br>
                            <span class="text-gray-500 dark:text-gray-300">Salario: {{ $offer->salary ? '$' . number_format($offer->salary, 2) : 'No especificado' }}</span><br>
                            <span class="text-gray-500 dark:text-gray-300">Fecha Inicio: {{ $offer->start_date ? \Carbon\Carbon::parse($offer->start_date)->format('d/m/Y H:i') : 'No definida' }}</span><br>
                            <span class="text-gray-500 dark:text-gray-300">Fecha Fin: {{ $offer->end_date ? \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y H:i') : 'No definida' }}</span><br>
                            <span class="text-gray-500 dark:text-gray-300">Postulantes: {{ $offer->jobApplications->count() }}</span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.job_offers.edit', $offer->id) }}" class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-1 px-2 rounded transition duration-200">Editar</a>
                                <form action="{{ route('admin.job_offers.destroy', $offer->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-1 px-2 rounded delete-button transition duration-200">Eliminar</button>
                                </form>
                            </div>
                            <a href="{{ route('admin.job_offers.export', ['id' => $offer->id, 'format' => 'pdf']) }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">Exportar a PDF</a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-1 bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 text-center text-gray-500">
                        No hay ofertas laborales disponibles.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const jobOffersList = document.getElementById('job-offers-list');
            const jobOffersCards = jobOffersList.querySelectorAll('div');

            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();

                jobOffersCards.forEach(card => {
                    const empresa = card.querySelector('span').textContent.toLowerCase();
                    const titulo = card.querySelector('h2').textContent.toLowerCase();

                    card.style.display = (empresa.includes(searchTerm) || titulo.includes(searchTerm)) ? '' : 'none';
                });
            });

            document.querySelectorAll('.delete-button').forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción eliminará la oferta laboral.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        // Cerrar todos los dropdowns si se hace clic fuera de ellos
        window.addEventListener('click', function(event) {
            const allDropdown = document.getElementById('export-all-menu');
            const allButton = document.getElementById('export-all-menu-button');
            if (!allButton.contains(event.target) && !allDropdown.contains(event.target)) {
                allDropdown.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
