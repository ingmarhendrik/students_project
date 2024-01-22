

<?php
// Saves submitted information to xml file
$students=simplexml_load_file('data.xml');


if (isset($_POST['submit'])) {
    $xmlDoc = new DOMDocument("1.0", "UTF-8");
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load('data.xml');
    $xmlDoc->formatOutput = true;

    $xml_root = $xmlDoc->documentElement;
    $xmlDoc->appendChild($xml_root);

    $xml_student = $xmlDoc->createElement("student");
    $xmlDoc->appendChild($xml_student);

    $xml_root->appendChild($xml_student);

    unset($_POST['submit']);

    $website = isset($_POST['website']) ? $_POST['website'] : '';
    if ($website && !preg_match("~^(?:f|ht)tps?://~i", $website)) {
        $website = "https://" . $website;
    }

    foreach ($_POST as $key => $value) {
        $entry = $xmlDoc->createElement($key, $key === 'website' ? $website : $value);
        $xml_student->appendChild($entry);
    }
    $xmlDoc->save('data.xml');

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>TARpe22 õpilased</title>
</head>
<body>
<header>
    <h1>TARpe22 õpilased</h1>
</header>

<div class="container">
    <section class="add-student">
        <h2>Õpilaste lisamine</h2>
        <div class="form">
            <form action="" method="post" name="form1">
                <label for="student_name">Nimi:</label>
                <input type="text" name="name" id="student_name" autofocus>

                <label for="website">Veebilehekülg:</label>
                <input type="text" name="website" id="website">

                <label for="gender">Sugu:</label>
                <input type="text" name="gender" id="gender">

                <input type="submit" name="submit" id="submit" value="Sisesta">
            </form>
        </div>
        <button><a href="data.xml">XML fail</a></button>
        <button><a href="www.github.com/students_project">GitHub kood</a></button>

    </section>

    <section class="students-list">
        <h2>Õpilaste nimekiri</h2>
        <div class="students">
            <table>
                <?php
                // Shows submitted information
                echo "<tr><th>Nimi</th></tr>";
                foreach ($students as $student) {
                    echo "<tr>";
                    echo '<td><a href="' . $student->website . '">' . $student->name . '</a></td>';
                    echo "</tr>";
                }
                ?>

            </table>
        </div>
    </section>
</div>

</body>
</html>

