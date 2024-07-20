@extends('admin.layout.app')

@section('title')
    Add Book Quantity
@endsection

@section('page_header')
Add Book Quantity
@endsection

@section('body')
<div class="main-content">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card stretch stretch-full">
                <div class="card-body general-info">
                    <div class="mb-5 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 me-4">
                            <span class="d-block mb-2">Add Book Quantity:</span>
                        </h5>
                        
                    </div>
                <form name="add_book_quantity_form" id="add_book_quantity_form" method="POST" action="{{url('add_book_quantity_success')}}" enctype="multipart/form-data">
                @csrf
                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="book_name" class="fw-semibold">Select Book: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-book"></i></div>
                                <select class="form-control" name="book" id="book">
                                    @foreach($book_details as $books)
                                        <option value="{{$books->id}}">{{$books->book_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="fullnameInput" class="fw-semibold">Enter Quantity: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-book"></i></div>
                                <input type="number" min="1" class="form-control" name="book_quantity" id="book_quantity" placeholder="Enter Quantity">
                            </div>
                        </div>

                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-lg-2">
                            <label for="fullnameInput" class="fw-semibold">Acquisition Type: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-user"></i></div>
                                <input type="text" class="form-control" name="acquisition_type" id="acquisition_type" placeholder="Enter Acquisition Type">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="fullnameInput" class="fw-semibold">Acquisition Date: </label>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <div class="input-group-text"><i class="feather-calendar"></i></div>
                                <input type="date" name="acquisition_date" id="acquisition_date" class="form-control">
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


                    <button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit">Add Book Quantity</button>
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
        $("#add_book_quantity_form").submit();
    });
</script>

@endsection
