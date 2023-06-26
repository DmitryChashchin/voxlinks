<div class="modal fade" id="{{ $modal['id'] }}" tabindex="-1" aria-labelledby="{{ $modal['id'] }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modal['id'] }}Label">{{ $modal['title'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('todo.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <select class="form-select" id="tags" name="tags[]" multiple></select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('editTodoModal'), {
        keyboard: false
    })

    $('#editTodoModal').on('shown.bs.modal', function () {
        $('#title').focus()

        // Load available tags
        $.ajax({
            url: '{{ route('tags.index') }}',
            success: function (data) {
                $('#tags').empty()
                $.each(data, function (key, tag) {
                    $('#tags').append('<option value="' + tag.id + '">' + tag.name + '</option>')
                })
            }
        })
    })

    // Create new tag
    $('#tags').select2({
        tags: true,
        createTag: function (params) {
            return {
                id: params.term,
                text: params.term,
                newTag: true
            }
        },
        templateResult: function (data) {
            var $result = $('<span></span>')
            $result.text(data.text)
            if (data.newTag) {
                $result.append(' <em>(new)</em>')
            }
            return $result
        }
    })

    $('#editTodoModal').on('hidden.bs.modal', function () {
        $('#title').val('')
        $('#description').val('')
        $('#tags').val(null).trigger('change')
    })
</script>