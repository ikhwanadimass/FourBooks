@props([
    'icon' => 'fas fa-box',
    'number' => 0,
    'label' => 'Label',
    'bgColor' => 'bg-blue-100',
    'iconColor' => 'text-blue-500',
])

<div class="bg-white dark:bg-neutral-800 rounded-lg p-6 shadow-sm border border-neutral-200 dark:border-neutral-700">
    <div class="flex items-start gap-4">
        <div class="w-16 h-16 {{ $bgColor }} rounded-lg flex items-center justify-center shrink-0">
            <i class="{{ $icon }} {{ $iconColor }} text-2xl"></i>
        </div>
        <div class="flex-1">
            <div class="text-3xl font-bold text-neutral-900 dark:text-white">
                {{ $number }}
            </div>
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                {{ $label }}
            </p>
        </div>
    </div>
</div>
