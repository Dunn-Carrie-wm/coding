<?php
$username = 'root';
$password = 'root';

try{
    $dbh = new PDO("mysql:host=localhost;dbname=coding", $username, $password);
    $dbh-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    print "Connection failed: ". $e->getMessage();
    die();
}

if (isset($_POST['formSubmit'])){
    $errorMessage ="";
    if (empty ($_POST['firstname'])){
        $errorMessage ="<li>You forgot to enter your first name.</li>";
    }
    if (empty ($_POST['lastname'])){
        $errorMessage ="<li>You forgot to enter your last name.</li>";
    }
    if (empty ($_POST['empnum'])){
        $errorMessage ="<li>You forgot to enter your employee number</li>";
    }

    $stmt = $dbh->prepare("INSERT INTO employee (firstname, lastname, empnum) VALUES (?,?,?)");
    $result = $stmt->execute(array($_POST['firstname'], $_POST['lastname'], $_POST['empnum']));
    if(!$result){
        print_r($stmt->errorInfo());
    }
    if(!empty($errorMessage)){
        echo("<p>There was an error with your form:</p>\n");
        echo("<ul>" . $errorMessage . "</ul>\n");
    }
}

if(isset($_POST['deleteSubmit'])){
        $stmt = $dbh->prepare("DELETE FROM employee WHERE firstname = :firstname");
        $stmt ->execute(array($_POST['firstname']));
        $result = $stmt ->fetchAll();
        echo '<p>The Employee was successfully removed </p>';
}

?>

<html>
<head>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <ul>
        <img src="logo.jpg">
        <p style="margin-left: 20px;"><a href="index.html">Home</a></p>
        <p><a>Employees</a></p>
        <p><a href="schedule.php">Schedule</a></p>
        <p><a href="customer.php">Attendance</a></p>
    </ul>

    <div id="form">
        <form method="post">
            <fieldset>
            <label>First Name</label>
            <input type="text" placeholder="First Name" name="firstname">
            <label>Last Name</label>
            <input type="text" placeholder="Last Name" name="lastname" >
            <label>Employee Id</label>
            <input type="number" placeholder="Employee Number" name="empnum">
            <input type="submit" name="formSubmit" value="Create Employee">
            </fieldset>
        </form>
    </div>

<?php
$query ="SELECT firstname FROM employee";
if ($stmt = $dbh->prepare($query)){
    $stmt->execute();
    while($row = $stmt->fetch()){
        echo $row["firstname"] .'<input type="submit" name="deleteSubmit" value="Delete Employee">' ."</br>" ;
    }
}
?>


</body>
</html>
