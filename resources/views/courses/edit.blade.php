<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Curso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('courses.update', $course) }}">
                        @csrf
                        @method('PUT')

                        <!-- Título -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Título del Curso')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $course->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Slug -->
                        <div class="mb-4">
                            <x-input-label for="slug" :value="__('URL Amigable (slug)')" />
                            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug', $course->slug)" required />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $course->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Instructor -->
                        <div class="mb-4">
                            <x-input-label for="instructor" :value="__('Instructor')" />
                            <x-text-input id="instructor" class="block mt-1 w-full" type="text" name="instructor" :value="old('instructor', $course->instructor)" required />
                            <x-input-error :messages="$errors->get('instructor')" class="mt-2" />
                        </div>

                        <!-- Precio -->
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Precio ($)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price', $course->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Duración -->
                        <div class="mb-4">
                            <x-input-label for="duration" :value="__('Duración (horas)')" />
                            <x-text-input id="duration" class="block mt-1 w-full" type="number" name="duration" :value="old('duration', $course->duration)" required />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        </div>

                        <!-- Nivel -->
                        <div class="mb-4">
                            <x-input-label for="level" :value="__('Nivel')" />
                            <select id="level" name="level" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Seleccionar nivel</option>
                                <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Principiante</option>
                                <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermedio</option>
                                <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Avanzado</option>
                            </select>
                            <x-input-error :messages="$errors->get('level')" class="mt-2" />
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('dashboard') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar Curso') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Formulario de Eliminar -->
                    <form method="POST" action="{{ route('courses.destroy', $course) }}" class="mt-8 border-t pt-6">
                        @csrf
                        @method('DELETE')
                        <x-danger-button onclick="return confirm('¿Estás seguro de que quieres eliminar este curso?')">
                            {{ __('Eliminar Curso') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>