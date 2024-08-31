<x-main-layout>
    <x-slot name="pageName">
        Dashboard
      </x-slot>

      @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
      @endif
      
      <livewire:dashboard />

</x-main-layout>
