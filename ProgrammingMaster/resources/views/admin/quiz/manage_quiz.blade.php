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
                        <h5 class="card-title">Quiz</h5>
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
                                    <a href="{{ url('add_quiz') }}" class="dropdown-item"><i class="feather-at-sign"></i>Add
                                        Quiz</a>
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
                                        <th scope="row">Title</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Difficulty</th>
                                        <th>Programming Language</th>
                                        <th>Quiz status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Quiz Questions</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr class="border-b">
                                        <th>Id</th>
                                        <th scope="row">Title</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Difficulty</th>
                                        <th>Programming Language</th>
                                        <th>Quiz status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Quiz Questions</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($quizDetails as $quiz_details)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $quiz_details->quiz_title }}</td>
                                            <td>{{ $quiz_details->quiz_description }}</td>
                                            <td>
                                                <div class="avatar-image avatar-lg rounded">
                                                    <img src="{{ $quiz_details->quiz_image }}"
                                                        class="img img-fluid img-responsive"
                                                        style="height:400px;width:400px;">
                                                </div>
                                            </td>
                                            <td>{{ $quiz_details->difficulty_level }}</td>
                                            <td>{{ $quiz_details->programming_language }}</td>
                                            <td>
                                                @php
                                                    $quiz_id = $quiz_details->quiz_id;
                                                @endphp
                                                @if ($quiz_details->quiz_status == 'Active')
                                                    <a class="btn btn-primary"
                                                        href='{{ url("change_quiz_status/$quiz_id") }}'>Active</a>
                                                @else
                                                    <a class="btn btn-danger"
                                                        href='{{ url("change_quiz_status/$quiz_id") }}'>Inactive</a>
                                                @endif
                                            </td>
                                            <td>{{ $quiz_details->created_at }}</td>
                                            <td>{{ $quiz_details->updated_at }}</td>
                                            <td>
                                                @php
                                                    $quiz_id = $quiz_details->quiz_id;
                                                    $enc_quiz_id = $encryptionModel->encrypt($quiz_id);
                                                    $base_64_quiz_id = base64_encode($enc_quiz_id);
                                                @endphp
                                                <a class="btn btn-secondary"
                                                        href='{{ url("manage_quiz_questions/$base_64_quiz_id") }}'>Quiz Questions</a>
                                            </td>
                                            <td>


                                                <i class="feather-trash text-danger"
                                                    onclick="delete_quiz_confirmation('{{ $quiz_details->quiz_id }}', '{{ $quiz_details->quiz_title }}')"></i>

                                                    <a href='{{ url("edit_quiz_details/$enc_quiz_id") }}'><i
                                                        class="feather-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if (count($quizDetails) == 0)
                                        <tr>
                                            <td colspan="12">
                                                <div class="alert alert-danger" role="alert">
                                                    Quiz Data Not Avaliable
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
        function delete_quiz_confirmation(quiz_id, quiz_title) {
            $("#quiz_id_delete").val(quiz_id);
            $("#quiz_title").html(quiz_title);
            $("#delete_quiz_confirmation_model").modal("show");
        }
    </script>
@endsection
