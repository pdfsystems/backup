<div class="space-y-4">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item icon="home" :href="route('dashboard')" />
        <flux:breadcrumbs.item>{{ __('Backups') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:table :paginate="$this->backups">
        <flux:table.columns>
            <flux:table.column>{{ __('Application') }}</flux:table.column>
            <flux:table.column>{{ __('Filename') }}</flux:table.column>
            <flux:table.column>{{ __('Type') }}</flux:table.column>
            <flux:table.column>{{ __('Size') }}</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">{{ __('Timestamp') }}</flux:table.column>
            <flux:table.column />
        </flux:table.columns>
        <flux:table.rows>
            @foreach($this->backups as $backup)
                <flux:table.row>
                    <flux:table.cell>{{ $backup->application->name }}</flux:table.cell>
                    <flux:table.cell>{{ $backup->filename }}</flux:table.cell>
                    <flux:table.cell>{{ $backup->type }}</flux:table.cell>
                    <flux:table.cell>{{ \Illuminate\Support\Number::fileSize($backup->size) }}</flux:table.cell>
                    <flux:table.cell>{{ $backup->created_at->format('M j, Y g:ia') }}</flux:table.cell>
                    <flux:table.cell>
                        @can('download', $backup)
                            <flux:button variant="primary"
                                         :href="route('ui.backups.download', $backup)"
                                         icon="arrow-down-tray"
                                         size="sm"
                            />
                        @endcan
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
