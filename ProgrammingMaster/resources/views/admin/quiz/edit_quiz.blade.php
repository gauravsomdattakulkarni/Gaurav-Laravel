@extends('admin.layout.app')

@section('title')
    Edit Quiz
@endsection

@section('page_header')
    Edit Quiz
@endsection

@section('body')
<div class="main-content">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card stretch stretch-full">
                <div class="card-body general-info">
                    <div class="mb-5 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 me-4">
                            <span class="d-block mb-2">Edit Quiz:</span>
                        </h5>
                    </div>
                    <form name="quiz_edit_form" id="quiz_edit_form" method="POST" action="{{url('update_quiz')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="quiz_id" value="{{ $quizDetails->quiz_id }}">

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="quiz_title" class="fw-semibold">Quiz Title: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-book"></i></div>
                                <input type="text" class="form-control" name="quiz_title" id="quiz_title" value="{{ $quizDetails->quiz_title }}" placeholder="Quiz Title">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="difficulty_level" class="fw-semibold">Difficulty Level: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-book"></i></div>
                                <select class="form-control" name="difficulty_level" id="difficulty_level">
                                    <option value="Easy" {{ $quizDetails->difficulty_level == 'Easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="Medium" {{ $quizDetails->difficulty_level == 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="Difficult" {{ $quizDetails->difficulty_level == 'Difficult' ? 'selected' : '' }}>Difficult</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="programming_language" class="fw-semibold">Programming Language: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-book"></i></div>
                                <input type="text" class="form-control" name="programming_language" id="programming_language" value="{{ $quizDetails->programming_language }}" placeholder="Programming Language">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="quiz_image" class="fw-semibold">Quiz Image: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-image"></i></div>
                                <input type="file" class="form-control" name="quiz_image" id="quiz_image">
                            </div>
                            @if($quizDetails->image_path)
                                <img src="{{ asset($quizDetails->image_path) }}" alt="Quiz Image" class="mt-2" style="width: 150px; height: auto;">
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="quiz_description" class="fw-semibold">Description: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-edit"></i></div>
                                <textarea class="form-control" name="quiz_description" id="quiz_description" placeholder="Enter Quiz Description">{{ $quizDetails->quiz_description }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="quiz_status" class="fw-semibold">Quiz Status: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-check-circle"></i></div>
                                <select class="form-control" name="quiz_status" id="quiz_status">
                                    <option value="Active" {{ $quizDetails->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $quizDetails->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="quiz_description" class="fw-semibold">Quiz Category: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-edit"></i></div>
                                <select name="quiz_category" class="form-control">
                                    @foreach($quiz_categories as $categories)
                                        <option value="{{$categories->quiz_category_id}}">{{$categories->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="quiz_description" class="fw-semibold">Negative Marking: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-edit"></i></div>
                                <select name="negative_marking" class="form-control">
                                   <option value="Yes">Yes</option>
                                   <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    @if($errors->any())
                        <div class="my-3 alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li class="my-1"><b>{{ $error }}<b></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit">Update Quiz</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
