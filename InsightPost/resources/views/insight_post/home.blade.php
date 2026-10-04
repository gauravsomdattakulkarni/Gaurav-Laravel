@extends("layout.app")

@section("title")
    Home
@endsection

@section("header_title")
    Welcome to Insight Post!
@endsection

@section("header_description")
    Designed & developed by Gaurav somdatta kulkarni
@endsection

@section("body")
<header class="py-5 bg-light border-bottom mb-4">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder">@yield('header_title')</h1>
            <p class="lead mb-0">@yield('header_description')</p>
        </div>
    </div>
</header>

@php
  $encryptionModel = new \App\Models\EncryptionModel();
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="row">
            @foreach($blog_posts as $post)
            <div class="col-lg-4">
                <div class="card mb-4" style="height: 460px;"> <!-- Set a fixed height for the card -->
                    <a href="#!"><img class="card-img-top" src="{{ $post->image }}" style="height:200px" alt="..." /></a>
                    <div class="card-body" style="height: calc(450px - 200px); overflow: hidden;"> <!-- Set a fixed height for the card body and enable overflow: hidden -->
                        <div class="small text-muted">{{ $post->created_at }} @if($post->edit_status=="EDITED")<a href="#" class="badge badge-dark">EDITED</a>@endif</div>
                        <h2 class="card-title h4">{{ Illuminate\Support\Str::limit($encryptionModel->decrypt($post->post_title, 12), 18) }}</h2> <!-- Truncate the title to a certain number of characters -->
                        <p class="card-text">{{ Illuminate\Support\Str::limit($encryptionModel->decrypt($post->description, 90), 150) }}</p> <!-- Truncate the description to a certain number of characters -->
                        <a class="btn btn-primary" href="{{ url('blog_post_details', ['post_id' => $post->post_id]) }}">Read more →</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        @if($total_blog_post_avaliable>10)
            <nav aria-label="Pagination">
                <hr class="my-0" />
                <ul class="pagination justify-content-center my-4">
                    <li class="page-item <?php if($page_no==1){echo "disabled";}?>">
                        <a class="page-link" href="{{ url('/home', ['page_no' => $page_no - 1]) }}" tabindex="-1" aria-disabled="true">First</a>
                    </li>
                    @for ($i = 1; $i <= $total_blog_post_avaliable; $i++)
                        <li class="page-item @if($i == $page_no) active @endif" aria-current="page">
                            <a class="page-link" href="{{ url('/home', ['page_no' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                    <li class="page-item">
                        <a class="page-link" href="{{ url('/home', ['page_no' => $page_no + 1]) }}">Next</a>
                    </li>
                </ul>
                
            </nav>
        @endif
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">Search</div>
            <div class="card-body">
                <div class="input-group">
                    <form id="blog_post_search_form" name="blog_post_search_form" method="GET" class="row" action="{{ url('/search_post') }}">
                        <div class="col-sm-8"> <!-- Adjust the column width as needed -->
                            <input class="form-control" type="text" name="post_title" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                        </div>
                        <div class="col-sm-4"> <!-- Adjust the column width as needed -->
                            <button class="btn btn-primary w-100" id="button-search" type="submit">Go!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
      
    </div>
</div>
@endsection