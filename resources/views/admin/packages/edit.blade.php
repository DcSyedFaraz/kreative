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
                    <form action="{{ route('packages.update', $package->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6 class="fs-15 mb-3">Name</h6>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $package->name }}" id="name" placeholder="Name">
                                            <label for="name">Name</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <h6 class="fs-15 mb-3">Description</h6>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="description" rows="12">{{ $package->description }}</textarea>
                                            <label for="description">Description</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <h6 class="fs-15 mb-3">Price</h6>
                                        <div class="form-floating mb-3">
                                            <input type="number" name="price" class="form-control"
                                                value="{{ $package->price }}" id="price" placeholder="Price">
                                            <label for="price">Price</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="features" class="form-label">Features</label>
                                        <select name="features[]" class="form-control select2" multiple required>
                                            <option value="Photographic"
                                                {{ in_array('Photographic', $selectedFeatures) ? 'selected' : '' }}>
                                                Photographic</option>
                                            <option value="Video Editing"
                                                {{ in_array('Video Editing', $selectedFeatures) ? 'selected' : '' }}>Video
                                                Editing</option>
                                            <option value="Album Design"
                                                {{ in_array('Album Design', $selectedFeatures) ? 'selected' : '' }}>Album
                                                Design</option>
                                            <option value="Website Design"
                                                {{ in_array('Website Design', $selectedFeatures) ? 'selected' : '' }}>
                                                Website Design</option>
                                            <option value="Drone Coverage"
                                                {{ in_array('Drone Coverage', $selectedFeatures) ? 'selected' : '' }}>Drone
                                                Coverage</option>
                                            <option value="Live Streaming"
                                                {{ in_array('Live Streaming', $selectedFeatures) ? 'selected' : '' }}>Live
                                                Streaming</option>
                                            <option value="Highlight Reel"
                                                {{ in_array('Highlight Reel', $selectedFeatures) ? 'selected' : '' }}>
                                                Highlight Reel</option>
                                            <option value="Trailer Video"
                                                {{ in_array('Trailer Video', $selectedFeatures) ? 'selected' : '' }}>
                                                Trailer Video</option>
                                            <option value="Full HD Recording"
                                                {{ in_array('Full HD Recording', $selectedFeatures) ? 'selected' : '' }}>
                                                Full HD Recording</option>
                                            <option value="Cinematic Editing"
                                                {{ in_array('Cinematic Editing', $selectedFeatures) ? 'selected' : '' }}>
                                                Cinematic Editing</option>
                                            <option value="Free Pre-Wedding Shoot"
                                                {{ in_array('Free Pre-Wedding Shoot', $selectedFeatures) ? 'selected' : '' }}>
                                                Free Pre-Wedding Shoot</option>
                                            <option value="Photo Album (40 Pages)"
                                                {{ in_array('Photo Album (40 Pages)', $selectedFeatures) ? 'selected' : '' }}>
                                                Photo Album (40 Pages)</option>
                                            <option value="USB with Edited Video"
                                                {{ in_array('USB with Edited Video', $selectedFeatures) ? 'selected' : '' }}>
                                                USB with Edited Video</option>
                                            <option value="Facebook Upload"
                                                {{ in_array('Facebook Upload', $selectedFeatures) ? 'selected' : '' }}>
                                                Facebook Upload</option>
                                            <option value="Instagram Teaser"
                                                {{ in_array('Instagram Teaser', $selectedFeatures) ? 'selected' : '' }}>
                                                Instagram Teaser</option>
                                            <option value="Delivery within 7 days"
                                                {{ in_array('Delivery within 7 days', $selectedFeatures) ? 'selected' : '' }}>
                                                Delivery within 7 days</option>
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
