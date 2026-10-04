@extends('admin.layout.app')

@section('title')
    Edit Book Details
@endsection

@section('page_header')
    Edit Book Details
@endsection

@section('body')
<div class="main-content">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card stretch stretch-full">
                <div class="card-body general-info">
                    <div class="mb-5 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 me-4">
                            <span class="d-block mb-2">Edit Book :</span>
                        </h5>
                    </div>
                <form name="book_edit_form" id="book_edit_form" method="POST" action="{{url('update_book_success')}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="book_name" class="fw-semibold">Book Name: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-book"></i></div>
                                <input type="hidden" name="enc_book_id" value="{{$enc_book_id}}">
                                <input type="text" class="form-control" name="book_name" id="book_name" value="{{ $book_details[0]->book_name }}" placeholder="Book Name">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="isbn_number" class="fw-semibold">ISBN Number: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-book"></i></div>
                                <input type="text" class="form-control" name="isbn_number" id="isbn_number" value="{{ $book_details[0]->isbn }}" placeholder="ISBN Number">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="author_name" class="fw-semibold">Author Name: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-user"></i></div>
                                <input type="text" class="form-control" name="author_name" id="author_name" value="{{ $book_details[0]->author_name }}" placeholder="Author Name">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="book_category" class="fw-semibold">Book Category: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-book"></i></div>
                                <select class="form-control" name="book_category" id="book_category">
                                    <option value="NOVAL" {{ $book_details[0]->category == 'NOVAL' ? 'selected' : '' }}>Noval</option>
                                    <option value="Historical" {{ $book_details[0]->category == 'Historical' ? 'selected' : '' }}>Historical</option>
                                </select>
                            </div>
                        </div>  
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="publisher" class="fw-semibold">Publisher: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-users"></i></div>
                                <input type="text" class="form-control" name="publisher" id="publisher" value="{{ $book_details[0]->publisher }}" placeholder="Enter Publisher Name">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="publication_year" class="fw-semibold">Publication Year: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-calendar"></i></div>
                                <input type="text" class="form-control" name="publication_year" id="publication_year" value="{{ $book_details[0]->publication_year }}" placeholder="Enter Publication Year">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="cover_image" class="fw-semibold">Cover Image: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-image"></i></div>
                                <input type="file" class="form-control" name="cover_image" id="cover_image">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="description" class="fw-semibold">Description: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-edit"></i></div>
                                <input type="text" class="form-control" name="description" id="description" value="{{ $book_details[0]->description }}" placeholder="Enter Description">
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

                    <button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit">Update Book</button>
                </form>  
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#btn_submit").click(function(){
        $("#btn_submit").attr("disabled", true);
        $("#btn_submit").html("<i class='feather-loader'></i> &nbsp;&nbsp; Please Wait .....");
        $("#book_edit_form").submit();
    });
</script>

@endsection
