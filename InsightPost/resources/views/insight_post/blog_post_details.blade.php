<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

@extends("layout.app")

@section("title")
    Post details
@endsection

@section("header_title")
    {{ $blog_post_details[0]->post_title }} !
@endsection

@section("header_description")

@endsection

@section("body")

@php
  $encryptionModel = new \App\Models\EncryptionModel();
@endphp

<style>
.blog-post-description {
    line-height: 1.6; /* Adjust line height for readability */
    text-align: justify; /* Justify text for a clean appearance */
    /* You can add more styling here as needed */
}
</style>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12s">
            <article>
                <header class="mb-4">
                    <h1 class="fw-bolder mb-1">{{ $encryptionModel->decrypt($blog_post_details[0]->post_title) }}</h1>
                    <div class="text-muted fst-italic mb-2">Posted on {{ $blog_post_details[0]->created_at }} by {{ $user_name }}</div>
                    <a class="badge bg-secondary text-decoration-none link-light" href="#!">{{ ucfirst($blog_post_details[0]->category) }}</a>
                </header>
                <figure class="mb-4">
                    <img class="img-fluid rounded" src="{{ $blog_post_details[0]->image }}" alt="..." style="width:800px;height:400px;max-width: 800px; max-height: 400px;" />
                </figure>                <section class="mb-5">
                    <div class="blog-post-description">
                        <p class="fs-5 mb-4">{{ $encryptionModel->decrypt($blog_post_details[0]->description) }}</p>
                    </div>
                </section>
            </article>
            <!-- Comments section-->
            <section class="mb-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <!-- Comment form-->
                        <form class="mb-4" name="comments_form" method="post" action="{{ url("add_comment_success") }}">
                        @csrf
                            <textarea class="form-control" rows="3" placeholder="Join the discussion and leave a comment!" name="blog_post_comment"></textarea>
                            <input type="hidden" value="{{ $blog_post_details[0]->post_id }}" name="post_id" id="post_id">
                            @error('blog_post_comment')
                                <div class="text-danger"> * {{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-primary my-3">Add Comment</button>
                        </form>
                        <!-- Comment with nested comments-->
                        @foreach($BlogPostComments as $comments)
                            <div class="d-flex my-3">
                                <div class="flex-shrink-0"><img class="rounded-circle" src="{{ asset('assets/assets/images/user_profile.jpg') }}" alt="User Profile" style="height:40px;width:40px;"/></div>
                                <div class="ms-3">
                                    <div class="fw-bold">{{ $comments->comment_by }} <small style="font-size:10px">({{ $comments->created_at }})</small></div>
                                    {{ $comments->comment }} 
                                    @if($comments->comment_by == $user_name)
                                        <i class="fa fa-pencil" onclick="edit_my_comment('<?php echo $comments->id?>' , '<?php echo $comments->comment?>')"></i>
                                        
                                        <i class="fa fa-trash text-danger mx-2" onclick="delete_my_comment('<?php echo $comments->id?>' , '<?php echo $comments->comment?>')"></i>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
       
    </div>
</div>

<div class="modal fade" id="edit_post_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Comment</h5>
        </div>
        <form name="edit_comment_form" method="post" action="{{ url("edit_user_comment") }}">
        @csrf
        <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Comment</label>
                    <input type="text" class="form-control" id="edit_user_comment" name="edit_user_comment" aria-describedby="emailHelp" placeholder="Enter Comment">
                    <input type="hidden" name="comment_id" id="comment_id" value="">
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_modal()">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form name="delete_comment_form" method="post" action="{{ url("delete_comment_success") }}" >
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this comment?
                    <input type="hidden" name="delete_comment_id" id="delete_comment_id" value="">
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
    function edit_my_comment(comment_id , comment)
    {
        $("#comment_id").val(comment_id);
        $("#edit_user_comment").val(comment);
        $("#edit_post_modal").modal("show");
    }

    function delete_my_comment(comment_id , comment)
    {
        $("#delete_comment_id").val(comment_id);
        $("#confirmDeleteModal").modal("show");
    }

    function close_modal()
    {
        $("#edit_post_modal").modal("hide");
        $("#confirmDeleteModal").modal("hide");
    }
</script>
@endsection