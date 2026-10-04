@extends('admin.layout.app')

@section('title')
    Manage Quiz Categories
@endsection

@section('page_header')
    Manage Quiz Categories
@endsection

@section('body')
    <div class="main-content">
        <div class="row">
            <div class="col-xxl-12">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Quiz Categories</h5>
                        <div class="card-header-action">
                            <a href="javascript:void(0);" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#addCategoryModal">Add Category</a>
                        </div>
                    </div>
                    <div class="card-body custom-card-action p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr class="border-b">
                                        <th>Id</th>
                                        <th>Category Name</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $index=>$category)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $category->category_name }}</td>
                                            <td>
                                                @if ($category->category_status == 'Active')
                                                    <a class="btn btn-primary"
                                                        href="{{ url('change_category_status', $category->quiz_category_id) }}">Active</a>
                                                @else
                                                    <a class="btn btn-danger"
                                                        href="{{ url('change_category_status', $category->quiz_category_id) }}">Inactive</a>
                                                @endif
                                            </td>
                                            <td>{{ $category->created_at }}</td>
                                            <td>{{ $category->updated_at }}</td>
                                            <td class="text-end">
                                                <a href="javascript:void(0);" class="btn btn-secondary"
                                                    onclick="editCategory('{{ $category->quiz_category_id }}', '{{ $category->category_name }}')">Edit</a>

                                                    <a href="javascript:void(0);" class="my-2 btn btn-danger"
                                                    onclick="deleteCategory('{{ $category->quiz_category_id }}', '{{ $category->category_name }}')">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($categories->isEmpty())
                                        <tr>
                                            <td colspan="6">
                                                <div class="alert alert-danger" role="alert">
                                                    No Quiz Categories Found.
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function editCategory(id, name) {
            document.getElementById('editCategoryForm').action = `{{ url('update_quiz_category') }}/${id}`;
            document.getElementById('editCategoryName').value = name;
            new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
        }

        function deleteCategory(id, name) {
            document.getElementById('deleteCategoryForm').action = `{{ url('delete_quiz_category') }}/${id}`;
            document.getElementById('deleteCategoryName').innerText = name;
            new bootstrap.Modal(document.getElementById('deleteCategoryModal')).show();
        }
    </script>
@endsection
