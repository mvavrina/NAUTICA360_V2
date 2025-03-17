@props(['name', 'label'])

<div class="inline-flex items-center ml-3.5">
    <label for="{{$name}}" class="flex items-center cursor-pointer relative">
        <input type="checkbox"
            id="{{$name}}"
            class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-blue-600 checked:border-blue-800"
        />
        <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></span>
    </label>
    <label for="{{$name}}" class="cursor-pointer ml-3 text-slate-600 text-sm select-none">{{$label}}</label>
</div>
