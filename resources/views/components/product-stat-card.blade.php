@props([
    'icon' => 'fas fa-cube',
    'number' => 0,
    'label' => 'Label',
    'bgColor' => 'bg-yellow-100',
    'iconColor' => 'text-yellow-600',
])

<div class="flex items-center gap-4 p-6 rounded-lg {{ $bgColor }} border border-neutral-200 dark:border-neutral-700">
    <div class="w-14 h-14 rounded-lg bg-white dark:bg-neutral-800 flex items-center justify-center shrink-0 shadow-sm">
        <i class="{{ $icon }} {{ $iconColor }} text-2xl"></i>
    </div>
    <div class="flex-1">
        <p class="text-sm text-neutral-600 dark:text-neutral-400">
            {{ $label }}
        </p>
        <p class="text-3xl font-bold text-neutral-900 dark:text-white">
            {{ $number }}
        </p>
    </div>
</div>
