@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-3">My Custom Packages</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Provider</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $package)
                <tr>
                    <td><a href="{{ route('custom-packages.show', $package) }}">{{ $package->name }}</a></td>
                    <td>{{ $package->provider->fname }}</td>
                    <td>{{ $package->price }}</td>
                    <td>{{ $package->payment_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
