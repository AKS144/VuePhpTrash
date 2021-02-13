@extends('layouts.app')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="float-left">
                <h2 class="mb-1">{{__('New Post')}}</h2>
            </div>
            <div class="float-right">
                <a href="{{route('posts.index')}}" class="btn btn-primary">{{__('Back')}}</a>
            </div>
        </div>
        <div class="card-body">
            @if ($error ?? '')
            <div class="alert alert-danger">
                <strong>{{ $error }}</strong>
            </div>
            @endif
            <form action="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="@if($post ?? '') {{ $post->title }} @endif">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="slug" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="@if($post ?? '') {{ $post->slug }} @endif">
                            @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <input type="text" id="content" name="content" class="form-control @error('content')is-invalid @enderror" value="@if($post ?? '') {{ $post->content }} @endif">
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" class="form-control @error('category')is-invalid @enderror" value="@if($post ?? '') {{ $post->category }} @endif">
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" id="tags" name="tags" class="form-control @error('tags')is-invalid @enderror" value="@if($post ?? '') {{ $post->tags }} @endif">
                            @error('tags')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail</label>
                            <input type="text" id="thumbnail" name="thumbnail" class="form-control @error('thumbnail')is-invalid @enderror" value="@if($post ?? '') {{ $post->thumbnail }} @endif">
                            @error('thumbnail')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">{{__('Status')}}</label>                            
                            <select name="status" id="status" class="form-control is-invalid">
                                <option>@if($post ?? '') {{ $post->status }} @endif</option>
                                <option>Draft</option>
                                <option>Publish</option>
                                <option>Private</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="author" value="{{ $author ?? '' }}">
                            @if($post ?? '')
                            @method('PUT')
                            <button class="btn btn-warning" type="submit" formaction="{{route('posts.update',$post)}}">{{__('Update')}}</button>
                            @else
                            <button class="btn btn-primary" type="submit" formaction="{{route('posts.store')}}">{{__('Submit')}}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection