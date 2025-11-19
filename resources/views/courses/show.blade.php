<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Información del Curso -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
                            <p class="text-lg text-gray-600 mt-2">{{ $course->instructor }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600">${{ number_format($course->price, 2) }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-yellow-500">⭐</span>
                                <span class="text-sm text-gray-600 ml-1">
                                    {{ number_format($course->averageRating(), 1) }} ({{ $course->totalReviews() }} reseñas)
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="font-medium">Duración:</span>
                            <span class="ml-2">{{ $course->duration }} horas</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium">Nivel:</span>
                            <span class="ml-2 capitalize">{{ $course->level }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium">Instructor:</span>
                            <span class="ml-2">{{ $course->instructor }}</span>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <h3 class="text-lg font-semibold mb-2">Descripción del Curso</h3>
                        <p class="text-gray-700">{{ $course->description }}</p>
                    </div>

                    @auth
                    <div class="mt-6 flex space-x-4">
                        <x-primary-button onclick="location.href='{{ route('courses.edit', $course) }}'">
                            {{ __('Editar Curso') }}
                        </x-primary-button>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Sección de Reseñas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Reseñas ({{ $course->reviews->count() }})</h3>

                    {{-- Mensaje de éxito --}}
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($course->reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($course->reviews as $review)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-900">{{ $review->user->name }}</span>
                                        <div class="flex items-center ml-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <span class="text-yellow-500">★</span>
                                                @else
                                                    <span class="text-gray-300">★</span>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                </div>
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Este curso aún no tiene reseñas.</p>
                            @auth
                            <p class="text-sm text-gray-400 mt-2">Sé el primero en dejar una reseña.</p>
                            @endauth
                        </div>
                    @endif

                    {{-- FORMULARIO PARA DEJAR RESEÑA --}}
                    @auth
                        <div class="mt-8 border-t pt-6">
                            <h4 class="text-lg font-semibold mb-4">Dejar tu Reseña</h4>
                            
                            <form action="{{ route('reviews.store', $course) }}" method="POST">
                                @csrf
                                
                                {{-- Calificación --}}
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-medium mb-2">Tu Calificación</label>
                                    <div class="flex space-x-2" id="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer transform hover:scale-110 transition">
                                                <input type="radio" name="rating" value="{{ $i }}" 
                                                       class="hidden rating-input" 
                                                       {{ old('rating') == $i ? 'checked' : '' }}>
                                                <span class="text-3xl text-gray-300 hover:text-yellow-400 rating-star">★</span>
                                            </label>
                                        @endfor
                                    </div>
                                    @error('rating')
                                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Comentario --}}
                                <div class="mb-4">
                                    <label for="comment" class="block text-gray-700 font-medium mb-2">Tu Comentario</label>
                                    <textarea 
                                        name="comment" 
                                        id="comment" 
                                        rows="4" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Comparte tu experiencia con este curso... ¿Qué te pareció? ¿Recomendarías este curso a otros?"
                                    >{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button 
                                        type="submit" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-medium"
                                    >
                                        Publicar Reseña
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        {{-- USUARIO NO AUTENTICADO --}}
                        <div class="mt-6 text-center border-t pt-6">
                            <p class="text-gray-500">
                                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Inicia sesión</a> 
                                para dejar una reseña
                            </p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Script para las estrellas interactivas --}}
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingStars = document.querySelectorAll('.rating-star');
            const ratingInputs = document.querySelectorAll('.rating-input');
            
            ratingStars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    const ratingValue = index + 1;
                    
                    // Actualizar inputs
                    ratingInputs.forEach((input, i) => {
                        input.checked = (i + 1) === ratingValue;
                    });
                    
                    // Actualizar estrellas visualmente
                    ratingStars.forEach((s, i) => {
                        if (i < ratingValue) {
                            s.classList.remove('text-gray-300');
                            s.classList.add('text-yellow-500');
                        } else {
                            s.classList.remove('text-yellow-500');
                            s.classList.add('text-gray-300');
                        }
                    });
                });
            });

            // Inicializar estrellas basado en valores antiguos (si hay error de validación)
            const checkedInput = document.querySelector('.rating-input:checked');
            if (checkedInput) {
                const ratingValue = parseInt(checkedInput.value);
                ratingStars.forEach((star, index) => {
                    if (index < ratingValue) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-500');
                    }
                });
            }
        });
    </script>
    @endauth
</x-app-layout>