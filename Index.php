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

            session_start();                                                                         // Deletes files if needed.
            if(!empty($_SESSION["NoteToDelete"]) && $Submitted && $_SESSION["ToDelete"]) {           // Deletes old file when a chance happened.

                $NoteToDelete = $_SESSION["NoteToDelete"];
                $NoteToDelete->DeleteDataset();
            }
            elseif(!empty($_GET["NoteToDelete"])) {

                $Title = htmlspecialchars(trim($_GET["NoteToDelete"]));     // Deletes file when user wants to.
                $NoteToDelete = new Note($Title, "", "");
                if(!empty($NoteToDelete)) {
                    $NoteToDelete->DeleteDataset();
                }
            }
            session_abort();

            if(!empty($_POST["Title"]) && !empty($_POST["Author"]) && !empty($_POST["NewNote"])) {      // Creates new note.
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
                foreach(glob("Notes\\*.txt") as $Note) {        // Outputs every note and gives option to delete or edit it.

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