@props(['type' => 'info', 'title' => '', 'message' => '', 'dismissible' => true])

@php
$classes = [
    'success' => 'bg-green-50 border-green-200 text-green-800',
    'error' => 'bg-red-50 border-red-200 text-red-800',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
    'info' => 'bg-blue-50 border-blue-200 text-blue-800'
];

$icons = [
    'success' => 'fas fa-check-circle text-green-400',
    'error' => 'fas fa-exclamation-circle text-red-400',
    'warning' => 'fas fa-exclamation-triangle text-yellow-400',
    'info' => 'fas fa-info-circle text-blue-400'
];
@endphp

<div {{ $attributes->merge(['class' => "border rounded-lg p-4 " . ($classes[$type] ?? $classes['info'])]) }}>
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="{{ $icons[$type] ?? $icons['info'] }} text-xl"></i>
        </div>
        <div class="ml-3 flex-1">
            @if($title)
            <h3 class="text-sm font-medium">{{ $title }}</h3>
            @endif
            <div class="text-sm {{ $title ? 'mt-1' : '' }}">
                {{ $message ?: $slot }}
            </div>
        </div>
        @if($dismissible)
        <div class="ml-auto pl-3">
            <button type="button" class="inline-flex rounded-md p-1.5 hover:bg-gray-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                <i class="fas fa-times text-gray-400"></i>
            </button>
        </div>
        @endif
    </div>
</div>