@props(['label', 'name', 'type' => 'text', 'value' => '', 'required' => false, 'placeholder' => '', 'errors' => null])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-600">*</span>
        @endif
    </label>
    
    @if($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" 
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors && $errors->has($name) ? 'border-red-500' : '' }}"
                  placeholder="{{ $placeholder }}" @if($required) required @endif>{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors && $errors->has($name) ? 'border-red-500' : '' }}"
                @if($required) required @endif>
            <option value="">{{ $placeholder ?: 'Sélectionner...' }}</option>
            {{ $slot }}
        </select>
    @else
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors && $errors->has($name) ? 'border-red-500' : '' }}"
               placeholder="{{ $placeholder }}" @if($required) required @endif>
    @endif
    
    @if($errors && $errors->has($name))
        <p class="text-red-500 text-xs mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>
