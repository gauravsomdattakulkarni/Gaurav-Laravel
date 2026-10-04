@extends('admin.layout.app')

@section('title')
    Manage Books
@endsection

@section('page_header')
    Manage Books
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
                    <h5 class="card-title">Books</h5>
                    <div class="card-header-action">
                        <div class="card-header-btn">
                            <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"> </a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown" data-bs-offset="25, 25">
                                <div data-bs-toggle="tooltip" title="Options">
                                    <i class="feather-more-vertical"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{url('add_book')}}" class="dropdown-item"><i class="feather-at-sign"></i>Add Book</a>
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
                                    <th scope="row">Name</th>
                                    <th>Book Photo</th>
                                    <th>ISBN</th>
                                    <th>Category</th>
                                    <th>Publisher Info</th>
                                    <th>Description</th>
                                    <th>Total Copies</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr class="border-b">
                                    <th>Id</th>
                                    <th scope="row">Name</th>
                                    <th>Book Photo</th>
                                    <th>ISBN</th>
                                    <th>Category</th>
                                    <th>Publisher Info</th>
                                    <th>Description</th>
                                    <th>Total Copies</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                @php
                                    $i=1;    
                                @endphp
                                @foreach($book_details as $books)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$books->book_name}}</td>
                                        <td>
                                            <div class="avatar-image avatar-lg rounded">
                                                <img src="{{$books->cover_image}}" class="img img-fluid img-responsive" style="height:400px;width:400px;">
                                            </div>
                                        </td>
                                        <td>{{$books->isbn}}</td>
                                        <td>{{$books->category}}</td>
                                        <td>
                                            Publisher : {{$books->publisher}}
                                            <br>
                                            Publication Year : {{$books->publication_year}}
                                        </td>
                                        <td>{{$books->description}}</td>
                                        <td>{{$books->total_copies}}</td>
                                        <td>{{$books->created_at}}</td>
                                        <td>{{$books->updated_at}}</td>
                                        <td>
                                            @php
                                                $book_id = $books->id;
                                                $enc_book_id = $encryptionModel->encrypt($book_id);
                                            @endphp
                                            <a href='{{url("edit_book/$enc_book_id")}}'><i class="feather-edit"></i></a>
                                            <i class="feather-trash text-danger" onclick="delete_book_confirmation('{{$books->id}}', '{{$books->book_name}}')"></i>
                                        </td>
                                    </tr>
                                @endforeach

                                @if(count($book_details)==0)
                                    <tr>
                                        <td colspan="12">
                                            <div class="alert alert-danger" role="alert">
                                                Books Data Not Avaliable
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
    function delete_book_confirmation(book_id, book_name) {
        $("#book_id_delete").val(book_id);
        $("#book_name").html(book_name);
        $("#delete_book_confirmation_model").modal("show");
    }
</script>
@endsection
