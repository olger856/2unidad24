<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Detalles de la Postulación') }}
        </h2>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-5xl w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 lg:p-10 space-y-10">

                <!-- Información del Postulante -->
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-300 dark:border-gray-700">Información del Postulante</h3>
                    <div class="flex flex-col items-center">
                        <img src="{{ $application->postulante->profile_photo_path ? asset('storage/' . $application->postulante->profile_photo_path) : asset('images/default-profile.png') }}"
                             alt="Imagen del Postulante"
                             class="w-32 h-32 rounded-full border-4 border-blue-500 mb-4 shadow-lg">
                        <p class="text-xl text-gray-900 dark:text-white font-semibold">{{ $application->postulante->name }}</p>
                        <p class="text-md text-gray-600 dark:text-gray-400">{{ $application->postulante->email }}</p>
                        <p class="text-md text-gray-600 dark:text-gray-400"><strong>DNI:</strong> {{ $application->postulante->dni }}</p>
                        <p class="text-md text-gray-600 dark:text-gray-400"><strong>Celular:</strong> {{ $application->postulante->celular }}</p>
                    </div>
                </div>

                <!-- Información de la Oferta Laboral -->
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-300 dark:border-gray-700">Información de la Oferta Laboral</h3>
                    <div class="space-y-4 text-gray-800 dark:text-gray-200">
                        <p><strong>Título:</strong> {{ $application->jobOffer->title }}</p>
                        <p><strong>Descripción:</strong> {{ $application->jobOffer->description }}</p>
                        <p><strong>Ubicación:</strong> {{ $application->jobOffer->location }}</p>
                        <p><strong>Salario:</strong> <span class="text-blue-600 dark:text-blue-400">S/{{ number_format($application->jobOffer->salary, 2) }}</span></p>
                    </div>
                </div>

                <!-- Estado de la Postulación con botón desplegable -->
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-300 dark:border-gray-700">Estado de la Postulación</h3>
                    <div class="relative inline-block text-left">
                        <button id="menu-button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" aria-expanded="true" aria-haspopup="true">
                            Cambiar Estado
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="menu" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <form action="{{ route('postulacion.updateStatus', ['application' => $application->id, 'status' => 2]) }}" method="POST" class="status-form">
                                    @csrf
                                    <button type="submit" class="block px-4 py-2 text-sm text-green-700 dark:text-green-400 hover:bg-gray-100 dark:hover:bg-gray-600">Aprobar</button>
                                </form>
                                <form action="{{ route('postulacion.updateStatus', ['application' => $application->id, 'status' => 3]) }}" method="POST" class="status-form">
                                    @csrf
                                    <button type="submit" class="block px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">Rechazar</button>
                                </form>
                                <form action="{{ route('postulacion.updateStatus', ['application' => $application->id, 'status' => 1]) }}" method="POST" class="status-form">
                                    @csrf
                                    <button type="submit" class="block px-4 py-2 text-sm text-yellow-700 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-gray-600">Pendiente</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón para rechazar a todos los postulantes pendientes -->
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-300 dark:border-gray-700">Acciones Masivas</h3>
                    <form action="{{ route('postulacion.rejectAllPending', ['jobOffer' => $application->jobOffer->id]) }}" method="POST" class="reject-all-form">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-8 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800">
                            Rechazar a Todos los Postulantes Pendientes
                        </button>
                    </form>
                </div>

                <!-- CV del Postulante -->
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-300 dark:border-gray-700">CV del Postulante</h3>
                    @if ($application->postulante->archivo_cv)
                        <a href="{{ asset('storage/' . $application->postulante->archivo_cv) }}"
                           class="text-blue-500 dark:text-blue-400 hover:underline font-semibold"
                           target="_blank">
                            Ver CV del Postulante
                        </a>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No hay CV disponible.</p>
                    @endif
                </div>

                <!-- Botón de Volver -->
                <div class="flex justify-center">
                    <a href="{{ route('postulaciones.index') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-8 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                        Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar librería SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Mostrar/Ocultar el menú desplegable
        const button = document.getElementById('menu-button');
        const menu = document.getElementById('menu');

        button.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Confirmación de envío de formularios
        document.querySelectorAll('.status-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Evitar el envío automático

                Swal.fire({
                    title: '¿Estás seguro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Enviar el formulario si el usuario confirma
                    }
                });
            });
        });

        document.querySelector('.reject-all-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Evitar el envío automático

            Swal.fire({
                title: '¿Estás seguro de rechazar a todos los postulantes pendientes?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Enviar el formulario si el usuario confirma
                }
            });
        });

        // Cerrar el menú al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (!button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden'); // Ocultar el menú si se hace clic fuera
            }
        });
    </script>
</x-app-layout>
