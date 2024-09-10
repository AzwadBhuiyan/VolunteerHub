<textarea
    name="{{ $name }}"
    id="{{ $id }}"
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ' . $class]) }}
>{{ $slot }}

</textarea>