<div class="space-y-4">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item icon="home" :href="route('dashboard')" />
        <flux:breadcrumbs.item>{{ __('Applications') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:table :paginate="$this->applications">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">{{ __('Name') }}</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'url'" :direction="$sortDirection" wire:click="sort('url')">{{ __('URL') }}</flux:table.column>
            <flux:table.column />
        </flux:table.columns>
        <flux:table.rows>
            @foreach($this->applications as $app)
                <flux:table.row>
                    <flux:table.cell>{{ $app->name }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:link :href="$app->url">
                            {{ $app->url }}
                        </flux:link>
                    </flux:table.cell>
                    <flux:table.cell>
                        @can('update', $app)
                            <flux:button icon="pencil"
                                         :href="route('ui.applications.edit', $app)"
                                         size="sm"
                            />
                        @endcan
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:button :href="route('ui.applications.create')"
                 icon="plus"
                 variant="primary"
    >
        {{ __('Add New') }}
    </flux:button>
</div>
