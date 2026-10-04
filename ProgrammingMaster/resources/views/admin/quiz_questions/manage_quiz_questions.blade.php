@extends('admin.layout.app')

@section('title')
    Manage Quiz
@endsection

@section('page_header')
    Manage Quiz
@endsection

@php
    $encryptionModel = new \App\Models\EncryptionModel();
@endphp

@section('body')
    <div class="main-content">
        <div class="row">
            <div class="col-xxl-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Quiz Questions</h5>
                        <div class="card-header-action">
                            <div class="card-header-btn">
                                <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                    <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success"
                                        data-bs-toggle="expand"> </a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown"
                                    data-bs-offset="25, 25">
                                    <div data-bs-toggle="tooltip" title="Options">
                                        <i class="feather-more-vertical"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href='{{ url("manage_quiz") }}' class="dropdown-item"><i class="feather-at-sign"></i>
                                        Manage Quiz</a>

                                    <a href='{{ url("add_quiz_questions/$base_64_quiz_id") }}' class="dropdown-item"><i class="feather-at-sign"></i>Add
                                        Quiz Questions</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body custom-card-action p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr class="border-b">
                                        <th>Id</th>
                                        <th>Question</th>
                                        <th>Options</th>
                                        <th>Correct Answer</th>
                                        <th>Marks</th>
                                        <th>Status</th>
                                        <th>Topic</th>
                                        <th>Image</th>
                                        <th>Source</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($quiz_question_details as $question)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $question->question }}</td>
                                            <td>
                                                <ul>
                                                    <li>{{ $question->option_1 }}</li>
                                                    <li>{{ $question->option_2 }}</li>
                                                    <li>{{ $question->option_3 }}</li>
                                                    <li>{{ $question->option_4 }}</li>
                                                </ul>
                                            </td>
                                            <td>{{ $question->correct_answer }}</td>
                                            <td>{{ $question->marks }}</td>
                                            <td>{{ $question->question_status }}</td>
                                            <td>{{ $question->topic_name }}</td>
                                            <td>
                                                @if ($question->question_image!="NA")
                                                    <img src="{{ $question->question_image }}" alt="Image" style="width: 100px; height: auto;">
                                                @else
                                                   <span class="text-danger">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $question->question_source }}</td>
                                            <td class="text-end">
                                                <i class="feather-trash text-danger"
                                                   onclick="delete_question_confirmation('{{ $question->quiz_question_id }}','{{ $question->question }}')"></i>
                                                <a href="{{ url('edit_quiz_question/' . $question->quiz_question_id) }}">
                                                    <i class="feather-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if (count($quiz_question_details) == 0)
                                        <tr>
                                            <td colspan="10">
                                                <div class="alert alert-danger" role="alert">
                                                    No Questions Available for this Quiz.
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer">
                        <ul class="list-unstyled d-flex align-items-center gap-2 mb-0 pagination-common-style">
                            <li>
                                <a href="javascript:void(0);"><i class="bi bi-arrow-left"></i></a>
                            </li>
                            <li><a href="javascript:void(0);" class="active">1</a></li>
                            <li><a href="javascript:void(0);">2</a></li>
                            <li>
                                <a href="javascript:void(0);"><i class="bi bi-dot"></i></a>
                            </li>
                            <li><a href="javascript:void(0);">8</a></li>
                            <li><a href="javascript:void(0);">9</a></li>
                            <li>
                                <a href="javascript:void(0);"><i class="bi bi-arrow-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function delete_question_confirmation(question_id, question_title) {
            $("#question_id_delete").val(question_id);
            $("#question_title").html(question_title);
            $("#delete_question_confirmation_model").modal("show");
        }
    </script>
@endsection
