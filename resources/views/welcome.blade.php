<x-main-layout :level="$level">
    <x-slot name="pageName">
        Dashboard
      </x-slot>
      @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
      @endif
      
      <livewire:dasboards />

</x-main-layout>
