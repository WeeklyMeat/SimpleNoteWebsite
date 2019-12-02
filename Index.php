<!DOCTYPE html>

<html lang="de">

    <!-- Head -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="cancer.css">
        <title>Happy Notes</title>
    </head>

    <!-- Body -->
    <body>

        <!-- PHP -->
        <?php
            require_once 'ClassNote.php';

            $Submitted = false;
            if(!empty($_POST["SubmitPressed"])) {
                $Submitted = $_POST["SubmitPressed"];
            }

            session_start();
            if(!empty($_SESSION["NoteToDelete"]) && $Submitted) {

                $NoteToDelete = $_SESSION["NoteToDelete"];
                $NoteToDelete->DeleteDataset();
            }
            session_abort();

            if(!empty($_POST["Title"]) && !empty($_POST["Author"]) && !empty($_POST["NewNote"])) {
                $Title = htmlspecialchars(trim($_POST["Title"]));
                $Author = htmlspecialchars(trim($_POST["Author"]));
                $Note = htmlspecialchars(trim($_POST["NewNote"]));

                $NoteObject = new Note($Title, $Author, $Note);
                $NoteObject->InsertDataset();
            }
        ?>

        <!-- Actual Content -->
        <div class="Content">

            <!--Notes to Output come here-->
            <?php
                foreach(glob("Notes\\*.txt") as $Note) {

                    $Title = basename($Note, ".txt");
                    $NoteObject = new Note($Title, "", "");

                    $NoteObject->OutputDataset();
                }
            ?>
        </div>

        <!-- Footer -->
        <footer class="Footer">
            <form action="NoteCreate.php" method="post">
                <textarea name="NewNote" class="InputNewNote" placeholder="Make a Note :D" rows="2"></textarea>
                <input type="submit" class="Submit" value="Erstellen">
            </form>
        </footer>
    </body>
</html>