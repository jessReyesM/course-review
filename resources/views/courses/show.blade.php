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
                <div class="p-6 bg-white border-b border-gray-200">
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
                                    {{ number_format($course->reviews->avg('rating') ?? 0, 1) }} ({{ $course->reviews->count() }} reseñas)
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
                <div class="p-6 bg-white border-b border-gray-200">
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
                                                    <span class="text-yellow-500 text-lg">★</span>
                                                @else
                                                    <span class="text-gray-300 text-lg">★</span>
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
                                <div class="mb-6">
                                    <label class="block text-gray-700 font-medium mb-3">Tu Calificación</label>
                                    <div class="flex space-x-1" id="rating-container">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="rating" value="{{ $i }}" 
                                                       class="hidden star-input"
                                                       {{ old('rating') == $i ? 'checked' : '' }}>
                                                <span class="text-4xl text-gray-300 hover:text-yellow-400 star" data-value="{{ $i }}">★</span>
                                            </label>
                                        @endfor
                                    </div>
                                    @error('rating')
                                        <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Comentario --}}
                                <div class="mb-6">
                                    <label for="comment" class="block text-gray-700 font-medium mb-2">Tu Comentario</label>
                                    <textarea 
                                        name="comment" 
                                        id="comment" 
                                        rows="5" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Comparte tu experiencia con este curso... ¿Qué te pareció? ¿Recomendarías este curso a otros?"
                                    >{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- BOTÓN CON ESTILOS EXPLÍCITOS --}}
                                <div class="flex justify-end">
                                    <button 
                                        type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md border-0 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        style="background-color: #2563eb; color: white;"
                                    >
                                        📝 Publicar Reseña
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        {{-- USUARIO NO AUTENTICADO --}}
                        <div class="mt-6 text-center border-t pt-6">
                            <p class="text-gray-500 text-lg">
                                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-semibold underline">Inicia sesión</a> 
                                para dejar una reseña
                            </p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript MEJORADO --}}
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const inputs = document.querySelectorAll('.star-input');
            
            // Función para actualizar estrellas
            function updateStars(selectedValue) {
                stars.forEach(star => {
                    const starValue = parseInt(star.getAttribute('data-value'));
                    if (starValue <= selectedValue) {
                        star.style.color = '#eab308'; // Amarillo
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-500');
                    } else {
                        star.style.color = '#d1d5db'; // Gris
                        star.classList.remove('text-yellow-500');
                        star.classList.add('text-gray-300');
                    }
                });
            }
            
            // Evento click en estrellas
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    
                    // Marcar el input correspondiente
                    inputs.forEach(input => {
                        input.checked = (input.value === value);
                    });
                    
                    // Actualizar visualización
                    updateStars(value);
                });
                
                // Efecto hover
                star.addEventListener('mouseenter', function() {
                    const hoverValue = this.getAttribute('data-value');
                    stars.forEach(s => {
                        const sValue = parseInt(s.getAttribute('data-value'));
                        if (sValue <= hoverValue) {
                            s.style.color = '#fbbf24'; // Amarillo claro
                        }
                    });
                });
                
                star.addEventListener('mouseleave', function() {
                    const checkedInput = document.querySelector('.star-input:checked');
                    if (checkedInput) {
                        updateStars(checkedInput.value);
                    } else {
                        stars.forEach(s => {
                            s.style.color = '#d1d5db'; // Gris
                        });
                    }
                });
            });
            
            // Inicializar con valor existente
            const checkedInput = document.querySelector('.star-input:checked');
            if (checkedInput) {
                updateStars(checkedInput.value);
            } else {
                // Inicializar todas como grises
                stars.forEach(star => {
                    star.style.color = '#d1d5db';
                });
            }
        });
    </script>
    @endauth

    {{-- ESTILOS CSS DE RESPALDO --}}
    <style>
        .star {
            transition: color 0.2s ease-in-out;
            cursor: pointer;
        }
        .star:hover {
            transform: scale(1.1);
        }
        /* Estilos explícitos para el botón */
        .btn-resena {
            background-color: #2563eb !important;
            color: white !important;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-resena:hover {
            background-color: #1d4ed8 !important;
        }
    </style>
</x-app-layout>