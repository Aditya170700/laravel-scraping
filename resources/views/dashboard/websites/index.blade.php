@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Websites</h2>

            <a href="{{ route('websites.create') }}" class="btn btn-warning pull-right">Add new</a>

            <table class="table table-bordered">
                <tr>
                    <td>Title</td>
                    <td>Logo</td>
                    <td>Url</td>
                    <td>Actions</td>
                </tr>
                @forelse ($results as $results)
                    <tr>
                        <td>{{ $results->title }}</td>
                        <td><img width="150" src="{{ url('uploads/' . $results->logo) }}" /></td>
                        <td><a href="{{ $results->url }}">{{ $results->url }}</a> </td>
                        <td>
                            <a href="{{ url('dashboard/websites/' . $results->id . '/edit') }}"><i
                                    class="glyphicon glyphicon-edit"></i> </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No websites</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection
