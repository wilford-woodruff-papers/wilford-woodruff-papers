@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50 rounded-md shadow-sm']) !!}></textarea>
