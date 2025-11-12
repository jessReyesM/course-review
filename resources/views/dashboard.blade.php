<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Botones de Acción -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-primary-button onclick="location.href='{{ route('courses.create') }}'" class="py-4 text-center">
                    <div class="flex flex-col items-center">
                        <span class="text-2xl">📚</span>
                        <span class="mt-2">Crear Nuevo Curso</span>
                    </div>
                </x-primary-button>
                
                <x-secondary-button class="py-4 text-center">
                    <div class="flex flex-col items-center">
                        <span class="text-2xl">⭐</span>
                        <span class="mt-2">Mis Reseñas</span>
                    </div>
                </x-secondary-button>
                
                <x-secondary-button onclick="location.href='{{ route('home') }}'" class="py-4 text-center">
                    <div class="flex flex-col items-center">
                        <span class="text-2xl">🏠</span>
                        <span class="mt-2">Ver Todos los Cursos</span>
                    </div>
                </x-secondary-button>
            </div>

            <!-- Lista de Cursos Recientes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Todos los Cursos Disponibles</h3>
                    
                    @if($courses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($courses as $course)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-lg mb-2">
                                <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:text-indigo-800">
                                    {{ $course->title }}
                                </a>
                            </h4>
                            
                            <p class="text-gray-600 text-sm mb-3">
                                {{ Str::limit($course->description, 80) }}
                            </p>
                            
                            <div class="flex justify-between items-center text-sm text-gray-500 mb-2">
                                <span>{{ $course->instructor }}</span>
                                <span class="font-bold text-green-600">${{ number_format($course->price, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center text-xs text-gray-400 mb-3">
                                <span>{{ $course->duration }}h</span>
                                <span class="capitalize">{{ $course->level }}</span>
                            </div>

                            <!-- Calificación y Botones -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-yellow-500">⭐</span>
                                    <span class="text-sm text-gray-600 ml-1">
                                        {{ number_format($course->averageRating(), 1) }} ({{ $course->totalReviews() }})
                                    </span>
                                </div>
                                
                                <!-- Botón para dejar reseña -->
                                <x-primary-button 
                                    onclick="location.href='{{ route('courses.show', $course) }}#reviews'"
                                    class="text-xs py-1 px-2">
                                    Calificar
                                </x-primary-button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No hay cursos disponibles.</p>
                        <x-primary-button class="mt-4" onclick="location.href='{{ route('courses.create') }}'">
                            Crear el Primer Curso
                        </x-primary-button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>