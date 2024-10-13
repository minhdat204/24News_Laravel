<x-content>
    <x-slot name="slotLeft">
        @include('client.partials.shared.news-content.news')
    </x-slot>
    <x-slot name="slotRight">
        @include('client.partials.shared.news-content.tags')
        @include('client.partials.shared.news-content.mostpopular')
    </x-slot>
    <x-slot name="slotUp">
        @include('client.partials.shared.news-content.pagination')
    </x-slot>
</x-content>
