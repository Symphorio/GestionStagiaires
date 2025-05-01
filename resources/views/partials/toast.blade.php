@if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
        {{ session('success') }}
    </div>
@endif