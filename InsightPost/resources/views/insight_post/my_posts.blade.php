<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
@extends("layout.app")

@section("title")
    Home
@endsection

@section("header_title")
    My posts!
@endsection

@section("header_description")
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
  $BlogPostComments = new \App\Models\BlogPostComments();
@endphp

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            @foreach($blog_posts as $post)
            <div class="col-lg-3">
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="{{ $post->image }}" alt="..." /></a>
                        <div class="card-body">
                            <div class="small text-muted">{{ $post->created_at }}</div>
                            <h2 class="card-title h4">{{ $encryptionModel->decrypt($post->post_title) }}</h2>
                            <p class="card-text">{{ Illuminate\Support\Str::limit($encryptionModel->decrypt($post->description, 90) )}}</p>
                            <a class="btn btn-primary" href="{{ url('blog_post_details', ['post_id' => $post->post_id]) }}">Read more →</a>
                        </div>
                        <div class="card-footer">
                            @php
                                $post_id = $post->post_id;
                                $total_comments = $BlogPostComments::where('post_id','=',$post_id)->count();
                            @endphp
                            <small>Total Comments : {{ $total_comments }} </small>  
                            &nbsp;&nbsp; <a href="{{ url('edit_post', ['post_id' => $post->post_id]) }}"><i class="fa fa-pencil" onclick="edit_my_comment('<?php echo $post->post_id ?>')"></i></a>
                            &nbsp;&nbsp; <i class="fa fa-trash text-danger mx-2" onclick="delete_post('<?php echo $post->post_id ?>')"></i>
 
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
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form name="delete_comment_form" method="post" action="{{ url("delete_post_success") }}" >
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post?
                    <input type="hidden" name="delete_post_id" id="delete_post_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_modal()">Cancel</button>
                    <button type="submit" class="btn btn-danger" >Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function close_modal()
    {
        $("#edit_post_modal").modal("hide");
        $("#confirmDeleteModal").modal("hide");
    }

    function delete_post(post_id)
    {
        $("#delete_post_id").val(post_id);
        $("#confirmDeleteModal").modal("show");
    }
</script>
@endsection