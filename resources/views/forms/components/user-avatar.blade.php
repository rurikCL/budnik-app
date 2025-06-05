<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }" class="flex">
        <!-- Interact with the `state` property in Alpine.js -->
        <div class="flex-1/2">
            <img src="/storage/{{ $getRecord()->aprobador->Foto }}" style="height: 2.5rem; width: 2.5rem;"
                 class="max-w-none object-cover object-center rounded-full ring-white dark:ring-gray-900">
        </div>
        <div class="flex pl-2">{{$getRecord()->aprobador->name}}</div>

    </div>
</x-dynamic-component>
