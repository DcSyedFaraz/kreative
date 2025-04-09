@extends('admin.layouts.app')
@section('content')
    @foreach ($errors->all() as $error)
        <li class="alert alert-danger">{{ $error }}</li>
    @endforeach


    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Role Form</h4>
                    </div>


                </div>
                <!-- Button Datatable -->
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('users.update', $users->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h6 class="fs-15 mb-3">Name</h6>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="name" id="Name"
                                                    placeholder="Name" value="{{ $users->name }}">
                                                <label for="Name">Name</label>
                                            </div>

                                            <h6 class="fs-15 mb-3">Password</h6>
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" name="password" id="Password"
                                                    placeholder="Password">
                                                <label for="Password">Password</label>
                                            </div>


                                            <h6 class="fs-15 mb-3">Selects Role</h6>

                                            <div class="form-floating mb-3">
                                                <select class="form-select" id="role" name="role" multiple
                                                    aria-label="Floating label select example">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="roles">Select a user role</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <h6 class="fs-15 mb-3">Email</h6>
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" id="Email" name="email"
                                                    placeholder="Email" value="{{ $users->email }}">
                                                <label for="Email">Email</label>
                                            </div>

                                            <h6 class="fs-15 mb-3">Confirm Password</h6>
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" id="Confirm Password"
                                                    name="password_confirmation" placeholder="Confirm Password">
                                                <label for="Confirm Password">Confirm Password</label>
                                            </div>

                                            <h6 class="fs-15 mb-3">Selects Role</h6>

                                            <div class="form-floating mb-3">

                                                <select name="permissions[]" id="permission" class="form-select" multiple>
                                                    @foreach ($allPermissions as $permission)
                                                        <option value="{{ $permission->id }}"
                                                            >
                                                            {{ $permission->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="Name">Select a user role</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-success">save</button>
                            <a href="{{ route('users.index') }}" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>

            </div> <!-- container-fluid -->

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col fs-13 text-muted text-center">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script> - Made with <span class="mdi mdi-heart text-danger"></span> by <a
                            href="#!" class="text-reset fw-semibold">Zoyothemes</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
@endsection
