@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Web servers</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <table>
                            <tr>
                                <th>id</th>
                                <th>fqdn</th>
                                <th>status</th>
                                <th>description</th>
                                <th></th>
                            </tr>
                            @foreach($webservers as $webserver)
                                <tr>
                                    <td> {{ $webserver['id'] }} </td>
                                    <td> {{ $webserver['fqdn'] }} </td>
                                    <td> {{ $webserver['status'] }} </td>
                                    <td> {{ $webserver['description'] }} </td>
                                    @csrf
                                </tr>
                            @endforeach
                        </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Create New Webserver (yeah I know this looks ugly )</div>

                <div class="card-body">
                    <form action="/create" method="POST">
                        @csrf
                        <div>
                            <label>Fully qualified domain name: </label>
                            <input type="text" name="fqdn" placeholder="www.example.com" value="{{ old('title') }}" />
                        </div>
                        <div>
                            <label>description: </label>
                            <input text="description" name="description" placeholder="Server Description" value="{{ old('description') }}" />
                        </div>
                        <div>
                            <label>server status: </label>
                            <input list="statuses" name="status" id="status">
                            <datalist id="statuses">
                                <option value="up">
                                <option value="down">
                                <option value="maintenance">
                            </datalist>
                        </div>
                        <div>
                            <button class="create" type="submit">Create web server</button>
                        </div>
                    </form>
                </div>
            </div>




        </div>
    </div>
</div>
@endsection
