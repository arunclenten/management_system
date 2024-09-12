<?php
include("header.php");
require_once 'db.php';


$sql = "SELECT * FROM user_table";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['login_success'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Login Successful!',
            text: 'Welcome back, {$_SESSION['user_name']}!',
            icon: 'success',
            confirmButtonText: 'OK'
      
        });
    </script>";
}
?>
<div class="text-end">
    <button class="btn btn-danger"><a href="add_user.php" class="text-white">Add User</a></button>
</div>

<div class="container mt-5">
    <h2>User List</h2>
    <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Unique Id</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Profile Picture</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sno = 1; 
            foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $sno++; ?></td> 
                    <td><?php echo $user['unique_id']; ?></td> 
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['phone']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['user_type']; ?></td>
                    <td><img src="uploads/<?php echo $user['profile_picture']; ?>" width="50"></td>
                    <td>
                    <a href="user-view.php?id=<?php echo $user['id']; ?>" class="btn btn-info"><i class="fa-solid fa-eye text-white"></i></a>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square text-white"></i></a>
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $user['id']; ?>)" class="btn btn-danger"><i class="fa-solid fa-trash text-white"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>



<script>

function confirmDelete(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
           
            $.ajax({
                url: 'delete_user.php',
                type: 'POST',
                data: { id: userId },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'The user has been deleted.',
                        'success'
                    ).then(function() {
                        
                        window.location.href = 'user.php';
                    });
                },
                error: function() {
                    Swal.fire(
                        'Failed!',
                        'There was an error deleting the user.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>

<?php
include("footer.php");
?>
