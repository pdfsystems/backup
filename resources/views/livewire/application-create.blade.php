<div class="space-y-4">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item icon="home" :href="route('dashboard')" />
        <flux:breadcrumbs.item :href="route('ui.applications.index')">{{ __('Applications') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __('New') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form wire:submit.prevent="create" class="space-y-4">
        <flux:input wire:model="name" :label="__('Name')"/>
        <flux:input wire:model="url" :label="__('URL')"/>

        <flux:button type="submit"
                     variant="primary"
        >
            {{ __('Create') }}
        </flux:button>
    </form>
</div>
