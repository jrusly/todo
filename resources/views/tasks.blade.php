@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <!-- Display Validation Errors -->
            @include('common.errors')

            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- New Task Form -->
                    <form action="{{ url('task')}}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Task</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>

                        <!-- Task Date -->
                        <div class="form-group">
                            <label for="task-date" class="col-sm-3 control-label">Date</label>

                            <div class="col-sm-6">
                                <input type="date" name="date" id="task-date" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>

                    <div class="panel-body">
                        @if ($done)
                        <form action="{{ url('/') }}" method="GET">
                            <button type="submit" class="btn btn-primary">
                                Show all tasks
                            </button>
                        </form>
                        @else
                        <form action="{{ url('done') }}" method="GET">
                            <button type="submit" class="btn btn-primary" @if (!$hasDone) disabled @endif >
                                Show only done tasks
                            </button>
                        </form>
                        @endif
                        
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Task</th>
                                <th>Date</th>
                                <th>Done</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <!-- Task Edit Form -->
                                        <form action="{{ url('task/'.$task->id) }}" method="POST">
                                            {{ csrf_field() }}
                                        
                                            <td>
                                                <input type="text" name="name" class="form-control" value="{{ $task->name }}">
                                            </td>
                                            
                                            <td>
                                                <input type="date" name="date" class="form-control" value="{{ $task->date }}">
                                            </td>

                                            <td>
                                                <input type="checkbox" name="done" class="form-control" value="1" @if ($task->done) checked @endif >
                                            </td>

                                            <td>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-btn fa-save"></i>Save
                                                </button>
                                            </td>
                                        </form>

                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="{{ url('task/'.$task->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
