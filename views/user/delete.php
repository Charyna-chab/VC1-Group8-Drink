<div class="modal fade" id="users<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure to delete it ?
            </div>
            <div class="modal-footer">
                <form action="/admin/users/delete?id=<?= $user['user_id'] ?>" method="POST">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Discard</button>
                </form>
            </div>
        </div>
    </div>
</div>