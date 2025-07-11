@extends('admin.layouts.app')
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Package Form</h4>
                </div>
            </div>
            <!-- Button Datatable -->
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('packages.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                                    <div class="col-lg-6">
                                        <h6 class="fs-15 mb-3">Name</h6>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="Name">
                                            <label for="name">Name</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <h6 class="fs-15 mb-3">Description</h6>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="description" rows="12"></textarea>
                                            <label for="description">Description</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <h6 class="fs-15 mb-3">Price</h6>
                                        <div class="form-floating mb-3">
                                            <input type="number" name="price" class="form-control" id="price"
                                                placeholder="Price">
                                            <label for="price">Price</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="features" class="form-label">Features</label>
                                        <select name="features[]" class="form-control select2" multiple required>
                                            <option value="Photographic">Photographic</option>
                                            <option value="Video Editing">Video Editing</option>
                                            <option value="Album Design">Album Design</option>
                                            <option value="Website Design">Website Design</option>
                                            <option value="Drone Coverage">Drone Coverage</option>
                                            <option value="Live Streaming">Live Streaming</option>
                                            <option value="Highlight Reel">Highlight Reel</option>
                                            <option value="Trailer Video">Trailer Video</option>
                                            <option value="Full HD Recording">Full HD Recording</option>
                                            <option value="Cinematic Editing">Cinematic Editing</option>
                                            <option value="Free Pre-Wedding Shoot">Free Pre-Wedding Shoot</option>
                                            <option value="Photo Album (40 Pages)">Photo Album (40 Pages)</option>
                                            <option value="USB with Edited Video">USB with Edited Video</option>
                                            <option value="Facebook Upload">Facebook Upload</option>
                                            <option value="Instagram Teaser">Instagram Teaser</option>
                                            <option value="Delivery within 7 days">Delivery within 7 days</option>
                                        </select>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <button class="btn btn-success">Submit</button>
                                        <a href="{{ route('packages.index') }}" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
@endsection
@section('scripts')
    <!-- Select2 CSS + JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Features",
                allowClear: true
            });
        });
    </script>
@endsection
