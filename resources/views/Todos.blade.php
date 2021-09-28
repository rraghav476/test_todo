<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Todo') }}
            </h2>
            <a href="{{url('todo/create')}}">
                <button class=" btn btn-primary leading-tight px-6 py-3 bg-blue-600 text-white-100 rounded-full  shadow">
                   {{ __('+') }}
                </button>
                
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($op == 1 && $errors)
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="{{ route('create-todo') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-label for="name" :value="__('Todo')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <div>
                            <x-label for="name mt-2" :value="__('Todo Description')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autofocus />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>
                    @elseif($op == 2 && $errors)
                    @elseif($op == 3 && $errors)
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="{{ url('assign-todo') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-label for="name" :value="__('Assign To')" />
                            <select name="assign_to" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                @foreach ($data as $val)
                                <option value="{{$val->id}}">{{$val->name}}</option>
                                @endforeach ()
                            </select>
                        </div>

                        <div>
                            <x-label for="name mt-2" :value="__('Completion Date')" />

                            <x-input id="name" class="block mt-1 w-full" type="date" name="completion_time" :value="old('description')" required autofocus />
                        </div>

                        <div>
                            <!-- <x-label for="name mt-2" :value="__('Completion Date')" /> -->

                            <x-input id="name" class="block mt-1 w-full" type="hidden" name="todo_id" :value="$id"  required autofocus />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Assign') }}
                            </x-button>
                        </div>
                    </form>
                    @elseif($op == 4 && $errors)
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="{{ route('update-todo') }}">
                        @csrf
                        <div>
                            <x-label for="name" :value="__('Todo')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$data->name" required autofocus />
                        </div>

                        <div>
                            <x-label for="name mt-2" :value="__('Todo Description')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="description" :value="$data->description" required autofocus />
                        </div>

                        <div>
                            <!-- <x-label for="name mt-2" :value="__('Todo Description')" /> -->
                            <x-input id="name" class="block mt-1 w-full" type="hidden" name="id" :value="$data->id" hidden required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                    @else
                    <table class="w-full withespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="border px-6 py-4"> id </th>
                                <th class="border px-6 py-4">name</th>
                                <th class="border px-6 py-4">Description</th>
                                <th class="border px-6 py-4">Create By</th>
                                <th class="border px-6 py-4">Delete/Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key =>$val)
                            <tr>
                                <x-table-column>{{$val["id"]}}</x-table-column>
                                <x-table-column>{{$val["name"]}}</x-table-column>

                                <x-table-column>{{$val["description"]}}</x-table-column>

                                <x-table-column>{{$val["created_by"]}}</x-table-column>
                                <x-table-column><a href="edit-todo/{{$val['id']}}">Edit</a>/
                                <a href="assign-todo/{{$val['id']}}">AssignTo</a>    
                                /<a href="todo/delete/{{$val['id']}}">Delete</a>
                                </x-table-column>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>