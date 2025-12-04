@props(['id' => 'confirmModal'])

<div id="{{ $id }}" class="justify-center items-center flex fixed hidden inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 px-4">
    <div class="relative mx-auto p-4 sm:p-5 border w-full max-w-xs sm:max-w-sm md:w-96 shadow-lg rounded-md bg-white">
        <div class="mt-2 sm:mt-3">
 
            {{-- Popup title --}}
            <h3 class="text-base sm:text-lg font-medium text-gray-900 text-center mt-3 sm:mt-4" id="{{ $id }}Title">
                Confirm Action
            </h3>
            
            {{-- message --}}
            <p class="text-xs sm:text-sm text-gray-500 text-center mt-2 px-2" id="{{ $id }}Message">
                Are you sure you want to proceed?
            </p>
            
            {{-- buttons --}}
            <div class="flex flex-col-reverse sm:flex-row gap-2 sm:gap-4 mt-4 sm:mt-6">
                <button type="button" id="{{ $id }}Cancel" 
                        class="text-xs sm:text-sm flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 sm:py-2 px-4 rounded">
                    Cancel
                </button>
                <button type="button" id="{{ $id }}Confirm" 
                        class="text-xs sm:text-sm flex-1 bg-red-500 hover:bg-red-700 text-white font-semibold py-2.5 sm:py-2 px-4 rounded">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>