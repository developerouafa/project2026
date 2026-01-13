<div>
    <!-- زر لفتح المودال -->
    <button wire:click="openModal" class="px-4 py-2 bg-blue-500 text-white rounded">Open Modal</button>

    <!-- المودال -->
    @if($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h2 class="text-lg font-bold mb-4">Contact Form</h2>

                <form wire:submit.prevent="submit">
                    <div class="mb-3">
                        <label for="name" class="block mb-1">Name</label>
                        <input type="text" id="name" wire:model="name" class="w-full border px-2 py-1 rounded">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="block mb-1">Email</label>
                        <input type="email" id="email" wire:model="email" class="w-full border px-2 py-1 rounded">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Send</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
