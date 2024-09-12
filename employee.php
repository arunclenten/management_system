<?php
include("header.php");
require_once 'db.php';


$sql = "SELECT * FROM employees";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="text-end">
    <button class="btn btn-danger"><a href="add_employee.php" class="text-white">Add Employee</a></button>
</div>
<div class="container mt-5">
    <h2>Employee List</h2>
    <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Unique id</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sno = 1;
            foreach ($employees as $emp) { ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $emp['unique_id']; ?></td> 
                    <td><?php echo $emp['name']; ?></td>
                    <td><?php echo $emp['department']; ?></td>
                    <td><?php echo $emp['position']; ?></td>
                    <td><?php echo $emp['email']; ?></td>
                    <td>
                   
                        <a href="edit_employee.php?id=<?php echo $emp['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square text-white"></i></a>
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $emp['id']; ?>)" class="btn btn-danger"><i class="fa-solid fa-trash text-white"></i></a>

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
                url: 'delete_employee.php',
                type: 'POST',
                data: { id: userId },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'The employee has been deleted.',
                        'success'
                    ).then(function() {
                        
                        window.location.href = 'employee.php';
                    });
                },
                error: function() {
                    Swal.fire(
                        'Failed!',
                        'There was an error deleting the employee.',
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