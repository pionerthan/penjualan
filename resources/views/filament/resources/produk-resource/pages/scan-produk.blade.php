<x-filament::page>
    <form wire:submit.prevent="simpanProduk" class="space-y-4">
        <x-filament::input.wrapper>
            <x-filament::input
                type="text"
                wire:model="barcode"
                autofocus
                placeholder="Scan barcode di sini..."
            />
        </x-filament::input.wrapper>

        <x-filament::button type="submit">
            Simpan
        </x-filament::button>
    </form>
</x-filament::page>
