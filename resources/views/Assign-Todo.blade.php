<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <table class="w-full withespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="border px-6 py-4"> id </th>
                                <th class="border px-6 py-4">name</th>
                                <th class="border px-6 py-4">Description</th>
                                <th class="border px-6 py-4">Assign To</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key =>$val )
                                <tr>
                                    <x-table-column>{{$val["id"]}}</x-table-column>
                                    <x-table-column>{{$val["name"]}}</x-table-column>

                                    <x-table-column>{{$val["description"]}}</x-table-column>

                                    <x-table-column>{{$val["assignTo"]}}</x-table-column>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
