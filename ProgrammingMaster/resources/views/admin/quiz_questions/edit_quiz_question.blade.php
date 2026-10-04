@extends('admin.layout.app')

@section('title')
    Edit Quiz Question
@endsection

@section('page_header')
    Edit Quiz Question
@endsection

@section('body')
<div class="main-content">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card stretch stretch-full">
                <div class="card-body general-info">
                    <div class="mb-5 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 me-4">
                            <span class="d-block mb-2">Edit Quiz Question:</span>
                        </h5>
                    </div>
                    <form name="quiz_question_edit_form" id="quiz_question_edit_form" method="POST" action="{{url('update_quiz_question')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="quiz_question_id" value="{{ $question[0]->id }}">

                        <div class="row mb-4 align-items-center">
                            <div class="col-lg-2">
                                <label for="topic_name" class="fw-semibold">Topic Name: </label>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <div class="input-group-text"><i class="feather-book"></i></div>
                                    <input type="text" class="form-control" name="topic_name" id="topic_name" value="{{ $question[0]->topic_name }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <div class="col-lg-2">
                                <label for="question" class="fw-semibold">Question: </label>
                            </div>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="question" id="question">{{ $question[0]->question }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <div class="col-lg-2">
                                <label for="option_1" class="fw-semibold">Option 1: </label>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="option_1" value="{{ $question[0]->option_1 }}">
                            </div>

                            <div class="col-lg-2">
                                <label for="option_2" class="fw-semibold">Option 2: </label>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="option_2" value="{{ $question[0]->option_2 }}">
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <div class="col-lg-2">
                                <label for="option_3" class="fw-semibold">Option 3: </label>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="option_3" value="{{ $question[0]->option_3 }}">
                            </div>

                            <div class="col-lg-2">
                                <label for="option_4" class="fw-semibold">Option 4: </label>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="option_4" value="{{ $question[0]->option_4 }}">
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <div class="col-lg-2">
                                <label for="correct_answer" class="fw-semibold">Correct Answer: </label>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="correct_answer" value="{{ $question[0]->correct_answer }}">
                            </div>

                            <div class="col-lg-2">
                                <label for="marks" class="fw-semibold">Marks: </label>
                            </div>
                            <div class="col-lg-4">
                                <input type="number" class="form-control" name="marks" value="{{ $question[0]->marks }}">
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <div class="col-lg-2">
                                <label for="question_image" class="fw-semibold">Question Image: </label>
                            </div>
                            <div class="col-lg-4">
                                <input type="file" class="form-control" name="question_image">
                                @if($question[0]->question_image !== 'NA')
                                    <img src="{{ $question[0]->question_image }}" alt="Question Image" class="mt-3" width="100">
                                @endif
                            </div>

                            <div class="col-lg-2">
                                <label for="question_status" class="fw-semibold">Status: </label>
                            </div>
                            <div class="col-lg-4">
                                <select class="form-control" name="question_status">
                                    <option value="Active" {{ $question[0]->question_status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $question[0]->question_status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
