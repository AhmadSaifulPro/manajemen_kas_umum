@extends('layout.main')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Form Edit Users</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Update User Admin</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" value="{{ $user->name }}" class="form-control" placeholder="Enter Nama" required
                                                name="name" />
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" value="{{ $user->email }}" class="form-control" placeholder="Enter Email" required
                                                name="email" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="text" value="{{ $user->password }}" class="form-control" placeholder="Enter Password" required
                                                name="password"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action text-end">
                                <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-success">Submit</button>
                                {{-- <button class="btn btn-danger">Cancel</button> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
