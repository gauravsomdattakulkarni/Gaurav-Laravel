@extends('admin.layout.app')

@section('title')
    Add Quiz Question
@endsection

@section('page_header')
    Add Quiz Question
@endsection

@section('body')
<div class="main-content">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card stretch stretch-full">
                <div class="card-body general-info">
                    <div class="mb-5 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 me-4">
                            <span class="d-block mb-2">Add Quiz Question:</span>
                        </h5>
                    </div>
                    <form name="quiz_question_add_form" id="quiz_question_add_form" method="POST" action="{{url('add_quiz_question_success')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="quiz_id" class="fw-semibold">Quiz: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-list"></i></div>
                                <input type ="text" class="form-control" name="quiz_name" value="{{$quiz_details[0]->quiz_title}}">
                                <input type ="hidden" class="form-control" name="quiz_id" value="{{$quiz_details[0]->quiz_id}}">

                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="topic_name" class="fw-semibold">Topic Name: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-book"></i></div>
                                <input type="text" class="form-control" name="topic_name" id="topic_name" placeholder="Topic Name">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="question" class="fw-semibold">Question: </label>
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-edit"></i></div>
                                <textarea class="form-control" name="question" id="question" placeholder="Enter Question"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="option_1" class="fw-semibold">Option 1: </label>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="option_1" id="option_1" placeholder="Option 1">
                        </div>

                        <div class="col-lg-2">
                            <label for="option_2" class="fw-semibold">Option 2: </label>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="option_2" id="option_2" placeholder="Option 2">
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="option_3" class="fw-semibold">Option 3: </label>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="option_3" id="option_3" placeholder="Option 3">
                        </div>

                        <div class="col-lg-2">
                            <label for="option_4" class="fw-semibold">Option 4: </label>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="option_4" id="option_4" placeholder="Option 4">
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="correct_answer" class="fw-semibold">Correct Answer: </label>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="correct_answer" id="correct_answer" placeholder="Correct Answer">
                        </div>

                        <div class="col-lg-2">
                            <label for="marks" class="fw-semibold">Marks: </label>
                        </div>
                        <div class="col-lg-4">
                            <input type="number" class="form-control" name="marks" id="marks" placeholder="Marks">
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="question_status" class="fw-semibold">Question Status: </label>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-control" name="question_status" id="question_status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <label for="question_image" class="fw-semibold">Question Image: </label>
                        </div>
                        <div class="col-lg-4">
                            <input type="file" class="form-control" name="question_image" id="question_image">
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="question_description" class="fw-semibold">Description: </label>
                        </div>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="question_description" id="question_description" placeholder="Enter Description"></textarea>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="question_source" class="fw-semibold">Source: </label>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="question_source" id="question_source" placeholder="Source">
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

                    <button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit">Add Question</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#btn_submit").click(function(){
        $("#btn_submit").attr("disabled", true);
        $("#btn_submit").html("<i class='feather-loader'></i> &nbsp;&nbsp; Please Wait ..... ");
        $("#quiz_question_add_form").submit();
    });
</script>

@endsection
