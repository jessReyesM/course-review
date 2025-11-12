<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todos los Cursos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Botón para crear curso (solo para autenticados) -->
            @auth
            <div class="mb-6 flex justify-end">
                <x-primary-button onclick="location.href='{{ route('courses.create') }}'">
                    {{ __('Crear Nuevo Curso') }}
                </x-primary-button>
            </div>
            @endauth

            <!-- Lista de Cursos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses as $course)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            <a href="{{ route('courses.show', $course) }}" class="hover:text-indigo-600">
                                {{ $course->title }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                            <span class="font-medium">{{ $course->instructor }}</span>
                            <span class="text-green-600 font-bold">${{ number_format($course->price, 2) }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <span>{{ $course->duration }} horas</span>
                            <span class="capitalize">{{ $course->level }}</span>
                        </div>

                        <!-- Estadísticas del curso -->
                        <div class="mt-3 flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="text-yellow-500">⭐</span>
                                <span class="text-sm text-gray-600 ml-1">
                                    {{ number_format($course->averageRating(), 1) }} ({{ $course->totalReviews() }} reseñas)
                                </span>
                            </div>
                            <x-secondary-button onclick="location.href='{{ route('courses.show', $course) }}'">
                                Ver Curso
                            </x-secondary-button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No hay cursos disponibles.</p>
                    @auth
                    <x-primary-button class="mt-4" onclick="location.href='{{ route('courses.create') }}'">
                        Crear el Primer Curso
                    </x-primary-button>
                    @endauth
                </div>
                @endforelse
            </div>

            <!-- Paginación -->
            @if($courses->hasPages())
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>