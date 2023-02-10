@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body add-customer">

                        <span>
                            {{ __('You are logged in!') }}
                        </span>
                        <a href="{{ route('add_customer') }}">
                            <button type="button" class="btn btn-primary">Add Customer</button>
                        </a>
                    </div>

                </div>
            </div>


            @if (session('status'))
                <div class="alert alert-success col-md-6 update-user" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('status_delete'))
                <div class="alert alert-success col-md-6 update-user" role="alert">
                    {{ session('status_delete') }}
                </div>
            @endif

            <div class="row justify-content-center">
                @if (!isset($customers_data['status'] ))
                    <table class="responsive-table col-md-8 custom-table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers_data as $customer)
                                <tr>
                                    <th scope="row">{{ $customer['name'] }}</th>
                                    <td class="col-sm-2">{{ $customer['mobile'] }}</td>
                                    <td>{{ $customer['status'] }}</td>
                                    <td>
                                        <a href="{{ route('edit_customer', ['customer_id' => $customer['id']]) }}"
                                            class="btn btn-primary">Edit</a>
                                        <a href="{{ route('delete_customer', ['customer_id' => $customer['id']]) }}"
                                            class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
