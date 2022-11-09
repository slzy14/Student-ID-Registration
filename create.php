<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id'])  ? $_POST['id'] : '';
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $gname = isset($_POST['gname']) ? $_POST['gname'] : '';
    $gphone = isset($_POST['gphone']) ? $_POST['gphone'] : '';
    $sub = isset($_POST['sub']) ? $_POST['sub'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO students VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $course, $phone, $created, $address, $gname, $gphone, $sub]);
    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
    <h2>Student Information</h2>
    <form action="create.php" method="post">
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
        <label for="sub">Subjects</label>
        <label></label>

        <textarea id="sub" class="form-control" rows="8" cols="116"></textarea>


        <input type="submit" value="Submit">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>