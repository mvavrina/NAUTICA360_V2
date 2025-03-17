<div>
    <!-- Label -->
    <label for="{{ $model }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    
    <!-- Input field -->
    <input 
        type="text" 
        name="{{ $name }}"
        id="{{ $name }}"
        class="w-[200px] bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
        placeholder="{{ $placeholder }}"
    >
</div>
