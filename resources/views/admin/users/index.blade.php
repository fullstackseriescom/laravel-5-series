@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3>User list</h3>
            @include('includes.errors')
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="{{ ($user->active == 0) ? 'danger' : '' }}">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach ($user->roles()->pluck('name') as $role)
                                <span class="label label-default">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if (Auth::id() != $user->id)
                                <button type="button" class="btn-modal-change-role btn btn-info btn-sm" data-userid="{{ $user->id }}" data-userrole="{{ $role }}">Change role</button>
                                {{ Form::open(['route' => ['admin.users.active_deactive'], 'method' => 'POST']) }}
                                    {{ Form::hidden('user_id', $user->id) }}
                                    {{ Form::submit(($user->active == 0) ? 'Reactive' : 'Deactivate', ['name' => 'submit', 'class' => 'btn btn-warning btn-sm']) }}
                                {{ Form::close() }}
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5">No results</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="roleModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Change role</h3>
            </div>
            <div class="modal-body">
                {{ Form::open(['route' => ['admin.users.change_role'], 'method' => 'POST']) }}
                    {{ Form::hidden('user_id') }}
                    <p>{{ Form::select('role', $roles, null, ['class' => 'form-control']) }}</p>
                    {{ Form::submit('Change', ['name' => 'submit', 'class' => 'btn btn-success btn-block btn-change-role']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection
