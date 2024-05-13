<x-app-layout>
    <div class="max-w-lg mx-auto p-6 bg-white dark:bg-gray-900 shadow-md rounded-lg">
        <form action="{{ route('establishments.update', $establishment->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="my-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name:</label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name', $establishment->name) }}"
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
            </div>

            <div class="my-4">
                <label for="description"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description:</label>
                <textarea name="description" id="description" required
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">{{ old('description', $establishment->description) }}</textarea>
            </div>

            <div class="my-4">
                <label for="location"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location:</label>
                <input type="text" name="location" id="location" required
                    value="{{ old('location', $establishment->location) }}"
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
            </div>

            <div class="my-4">
                <label for="category"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category:</label>
                <input type="text" name="category" id="category" required
                    value="{{ old('category', $establishment->category) }}"
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
            </div>

            <div class="my-4">
                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price each
                    night (€):</label>
                <input type="number" name="price" id="price" required step="0.01"
                    value="{{ old('price', $establishment->price) }}"
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                    placeholder="0.00">
            </div>

            <div class="my-4">
                @php $countImages = 0; @endphp
                @foreach ($establishment->images as $image)
                    <div class="flex items-center space-x-4 my-2">
                        <div>
                            <label for="images[{{ $loop->index }}]"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Replace image
                                {{ $loop->index + 1 }}:</label>
                            <input type="file" name="images[{{ $loop->index }}]"
                                class="shadow border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        </div>
                    </div>
                    @php $countImages++; @endphp
                @endforeach

                @for ($i = $countImages; $i < 3; $i++)
                    <div class="my-4">
                        <label for="images[{{ $i }}]"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Add new image:</label>
                        <input type="file" name="images[{{ $i }}]"
                            class="shadow border rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>
                @endfor
                <div class="my-4">
                    <button type="submit"
                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2">Update
                        Establishment</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
