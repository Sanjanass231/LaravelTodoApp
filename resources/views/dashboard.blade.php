<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Add New Todo Button with modal -->
                    <div class="mb-4">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#todoModal">
                            Add Todo
                        </button>
                    </div>
       
                    <!-- Bootstrap Table to render todo lists-->
                     @if ($todos->isEmpty())
                        <p class="text-center">No added tasks here.</p>
                    @else
                        <table class="table-info table w-full text-black rounded-semi">
                            <tbody>
                                @foreach ($todos as $todo)
                                    <tr>
                                        <td>{{ $todo->message }}</td>
                                        <td>{{ $todo->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                      <!-- Delete Button -->
                                               <form action="{{ route('todos.destroy', $todo->id) }}" method="POST">
                                                   @csrf
                                              @method('DELETE')
                                              <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                        </td>
                                         <td>
                                       <!-- Update Button to trigger modal -->
                                           <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateTodoModal-{{ $todo->id }}">
                                                 Update
                                          </button>
                                       </td>
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <!-- Modal for Adding Todo -->
                    <div class="modal fade" id="todoModal" tabindex="-1" aria-labelledby="todoModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="todoModalLabel">Add New Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('todos.store') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="task-details" class="col-form-label">Task Details:</label>
                                            <textarea class="form-control" id="task-details" name="task_details" required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Task</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->
                     <!-- modal for updating todo -->
                      @foreach ($todos as $todo)
    <!-- Update Todo Modal -->
    <div class="modal fade" id="updateTodoModal-{{ $todo->id }}" tabindex="-1" aria-labelledby="updateTodoModalLabel-{{ $todo->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTodoModalLabel-{{ $todo->id }}">Update Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('todos.update', $todo->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="task-details-{{ $todo->id }}" class="col-form-label">Task Details:</label>
                            <textarea class="form-control" id="task-details-{{ $todo->id }}" name="task_details" required>{{ $todo->message }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
