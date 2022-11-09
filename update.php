<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $course = isset($_POST['course']) ? $_POST['course'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $gname = isset($_POST['gname']) ? $_POST['gname'] : '';
        $gphone = isset($_POST['gphone']) ? $_POST['gphone'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE students SET id = ?, name = ?, course = ?, phone = ?, created = ?, address = ?, gname = ?, gphone = ? WHERE id = ?');
        $stmt->execute([$id, $name, $course, $phone, $created, $address, $gname, $gphone, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        exit('Student Information doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
    <h2>Update Student Information #<?=$student['id']?></h2>
    <form action="update.php?id=<?=$student['id']?>" method="post">
        <label for="id">ID #</label>
        <label for="name">Name</label>
        <input type="text" name="id" id="id">
        <input type="text" name="name"  id="name">
        <label for="course">Course</label>
        <label for="phone">Student Phone #</label>
        <input type="text" name="course"  id="course">
        <input type="text" name="phone" id="phone">
        <label for="address">Address</label>
        <label for="created">Birthday</label>
        <input type="text" name="address" id="address">
        <input type="date" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <label for="gname">Name of Guardian</label>
        <label for="gphone">Guardian Phone #</label>
        <input type="text" name="gname" id="gname">
        <input type="text" name="gphone" id="gphone">
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>