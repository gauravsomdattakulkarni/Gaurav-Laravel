<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="jumbotron text-center">
        <h1>Images S3 Bucket</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ url('upload_images_success') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" class="form-control" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach ($files as $file)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ Storage::disk('s3')->url($file) }}" class="img img-responsive img-fluid card-img-top img-thumbnail" style="height:200px;width:400px" alt="Image">
                    <div class="card-body text-center">
                        <form action="{{ url('delete_image') }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="file_to_delete" value="{{$file}}">
                            <button type="button" class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteModal" data-key="{{ $file }}">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this image?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteModal = document.getElementById('deleteModal');
        var confirmDeleteButton = document.getElementById('confirmDelete');
        var deleteForm;

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var key = button.data('key');
            deleteForm = button.closest('form');
        });

        confirmDeleteButton.addEventListener('click', function () {
            deleteForm.submit();
            confirmDeleteButton.disabled = true;
            confirmDeleteButton.textContent = 'Deleting...';
        });
    });
</script>
</body>
</html>
