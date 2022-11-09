<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM students ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_students = $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
?>

<?=template_header('Students')?>

<div class="content read">
	<h2>Students</h2>
	<a href="create.php" class="create-student">Register</a>
	<table>
        <thead>
            <tr>
                <td>ID #</td>
                <td>Name</td>
                <td>Phone #</td>
                <td>Course</td>
                <td>Birthdate</td>
                <td>Address</td>
                <td>Guardian</td>
                <td>Guardian Phone #</td>
                <td>Subjects</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?=$student['id']?></td>
                <td><?=$student['name']?></td>
                <td><?=$student['phone']?></td>
                <td><?=$student['course']?></td>
                <td><?=$student['created']?></td>
                <td><?=$student['address']?></td>
                <td><?=$student['gname']?></td>
                <td><?=$student['gphone']?></td>
                <td><?=$student['sub']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$student['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$student['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_students): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>