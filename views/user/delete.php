<div class="modal fade" id="user<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="deleteUser(<?= $user['user_id'] ?>)">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Discard</button>
            </div>
        </div>
    </div>
</div>