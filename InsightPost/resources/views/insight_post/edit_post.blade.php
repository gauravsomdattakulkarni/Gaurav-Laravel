<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

@extends("layout.app")

@section("title")
    New post
@endsection

@section("header_title")
    Let's post something great!
@endsection

@section("header_description")
    Share your thoughts, ideas, and experiences with the world. Start a conversation, inspire others, and make an impact!
@endsection

@section("body")

<style>
    .image-container {
        display: inline-block;
        margin-right: 10px;
    }

    .image-container img {
        max-width: 100px;
        max-height: 100px;
        margin-bottom: 5px;
    }

    .image-container {
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px; /* Add margin bottom for spacing */
    }

    .image-container img {
        max-width: 100px;
        max-height: 100px;
        margin-bottom: 5px;
    }

    .remove-image {
        margin-left: 5px; /* Add margin-left for spacing between image and button */
    }

</style>

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

<form name="blog_post_form" id="blog_post_form" method="post" action="{{ url('blog_post_update') }}" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="post_category">Post category</label>
            <input type="hidden" id="post_id" name="post_id" value="{{ $post_id }}" class="form-control">

            <select class="form-control" id="post_category" name="post_category">
                @php
                    $category = $blog_post_details[0]->category;
                @endphp
                <option value="technology" {{ $category == 'technology' ? 'selected' : '' }}>Technology</option>
                <option value="travel" {{ $category == 'travel' ? 'selected' : '' }}>Travel</option>
                <option value="food" {{ $category == 'food' ? 'selected' : '' }}>Food</option>
                <option value="fitness" {{ $category == 'fitness' ? 'selected' : '' }}>Fitness</option>
                <option value="health" {{ $category == 'health' ? 'selected' : '' }}>Health</option>
                <option value="education" {{ $category == 'education' ? 'selected' : '' }}>Education</option>
                <option value="fashion" {{ $category == 'fashion' ? 'selected' : '' }}>Fashion</option>
                <option value="sports" {{ $category == 'sports' ? 'selected' : '' }}>Sports</option>
                <option value="music" {{ $category == 'music' ? 'selected' : '' }}>Music</option>
                <option value="art" {{ $category == 'art' ? 'selected' : '' }}>Art</option>
                <option value="photography" {{ $category == 'photography' ? 'selected' : '' }}>Photography</option>
                <option value="business" {{ $category == 'business' ? 'selected' : '' }}>Business</option>
                <option value="finance" {{ $category == 'finance' ? 'selected' : '' }}>Finance</option>
                <option value="lifestyle" {{ $category == 'lifestyle' ? 'selected' : '' }}>Lifestyle</option>
                <option value="science" {{ $category == 'science' ? 'selected' : '' }}>Science</option>
                <option value="politics" {{ $category == 'politics' ? 'selected' : '' }}>Politics</option>
                <option value="history" {{ $category == 'history' ? 'selected' : '' }}>History</option>
            </select>
            
        </div>
    </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Post title</label>
                <input type="text" class="form-control" id="post_title"  name="post_title" aria-describedby="post_title_help" value= "{{ $encryptionModel->decrypt($blog_post_details[0]->post_title) }}" placeholder="Enter post title">
                <small id="post_title_help" class="form-text text-muted">Enter appling title for your blog post</small>
              </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Post Description</label>
                <textarea class="form-control" id="post_description" name="post_description" rows="8">{{ $encryptionModel->decrypt($blog_post_details[0]->description) }}</textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="post_images">Post Images</label>
                <input type="file" id="post_image" name="post_image" class="form-control">
            </div>
            <div id="image_preview" class="mt-2 text-muted"><small> (Optional)</small></div>

        </div>

        <div class="col-md-12 my-3">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <button type="button" id="edit_blog_post_btn" onclick="edit_blog_post()" class="my-3 btn btn-success">Submit</button>
            </div>
        </div>

</div>
</form>

<script>
    $(document).ready(function() {
        $('#post_images').on('change', function() {
            var files = $(this)[0].files;
            var preview = $('#image_preview');
            var maxFiles = 10;

            preview.empty();

            if (files.length > 0) {
                var numFiles = Math.min(files.length, maxFiles); // Limit the number of files to the maximum

                for (var i = 0; i < numFiles; i++) {
                    var file = files[i];
                    var reader = new FileReader();

                    reader.onload = (function(file) {
                        return function(e) {
                            preview.append('<div class="image-container" data-fileindex="' + i + '"><img src="' + e.target.result + '" class="img-thumbnail"><button class="btn btn-sm btn-danger remove-image">Remove</button></div>');
                        };
                    })(file);

                    reader.readAsDataURL(file);
                }
            }
        });

        // Remove image button functionality
        $(document).on('click', '.remove-image', function() {
            var container = $(this).closest('.image-container');
            var fileIndex = container.data('fileindex');
            var input = $('#post_images')[0];
            
            // Remove the image container
            container.remove();
            
            // Remove the corresponding file from the input files array
            var files = input.files;
            var newFiles = [];
            for (var i = 0; i < files.length; i++) {
                if (i !== fileIndex) {
                    newFiles.push(files[i]);
                }
            }
            input.files = newFiles;
        });

        // Clear all images button functionality
        $('#clear_images').on('click', function() {
            $('#image_preview').empty();
            $('#post_images').val('');
        });
    });

    function edit_blog_post()
    {
        $("#edit_blog_post_btn").prop('disabled', true);
        $("#edit_blog_post_btn").html('<i class="fas fa-spinner fa-spin"></i> Please wait, blog post is getting updated...');
        $("#blog_post_form").submit();
    }
</script>



@endsection