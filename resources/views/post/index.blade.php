@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <h2 class="mb-1">{{__('Posts')}}</h2>
                    </div>
                    <div class="float-right">
                    @if($trash)
                        <a href="{{route('posts.index')}}" class="btn btn-primary">{{__('View All')}}</a>
                    @else
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">{{__('Add New')}}</a>
                        <a href="{{ route('posts.trash') }}" class="btn btn-primary">{{__('Recycle Bins')}}</a>
                    @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table-table-bordered table-stripped table-responsive-md">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th width="100">{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php  $no = 1 @endphp
                            @foreach($posts as $post)
                            <tr>
                                <td>{{ $no++}}</td>
                                <td>{{ $post->title}}</td>
                                <td>{{ $post->category}}</td>
                                <td>{{ $post->tags}}</td>
                                <td>{{ $post->user->name}}</td>
                                <td>{{ $post->status}}</td>
                                <td>
                                @if($trash)
                                 <a href="{{ route('posts.restore', $post)}}" class="btn btn-success btn-sm">{{__('Restore')}}</a>
                                    <form action="{{ route('posts.remove', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$post->id}}">
                                        <button class="btn btn-danger btn-sm" type="submit">{{__('Delete')}}</button>
                                    </form>
                                @else
                                    <a href="{{ route('posts.show', $post)}}" class="btn btn-info btn-sm">{{__('View')}}</a>
                                    <a href="{{ route('posts.edit', $post)}}" class="btn btn-primary btn-lg active">{{__('Edit')}}</a>
                                    <form action="{{route('posts.destroy', $post)}}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">{{__('Trash')}}</button>
                                    </form>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection