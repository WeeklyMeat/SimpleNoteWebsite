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

            if(!empty($_GET["DeleteNote"]) && file_exists("Notes\\".$_GET["DeleteNote"].".txt")) {

                $TitleOfNote = strtolower(htmlspecialchars(trim($_GET["DeleteNote"])));

                $NoteToDelete = new Note($TitleOfNote, "", "");
                $NoteToDelete->DeleteDataset();
            }

            if(!empty($_POST["ChangedNote"])) {

                $NewNote = strtolower(htmlspecialchars(trim($_POST["ChangedNote"])));

                session_start();
                $NoteToChange = $_SESSION["NoteObject"];
                session_destroy();

                if(file_exists("Notes\\".$NoteToChange->GetTitle().".txt")) {
                    $NoteToChange->DeleteDataset();
                }
                $NoteToChange->ChangeDataset($NewNote);
            }
            if(!empty($_POST["NewNote"]) && !empty($_POST["Author"]) && !empty($_POST["Title"])) {
                
                $Title = strtolower(htmlspecialchars(trim($_POST["Title"])));
                $Author = htmlspecialchars(trim($_POST["Author"]));
                $Note = htmlspecialchars(trim($_POST["NewNote"]));

                $Path = "Notes\\".$Title.".txt";
                $OriginalTitle = $Title;
                $Count = 0;

                while(file_exists($Path)) {

                    $Title = $OriginalTitle.$Count;
                    $Path = "Notes\\".$Title.".txt";
                    $Count++;
                }

                $NewNote = new Note($Title, $Author, $Note);
                $NewNote->InsertDataset();
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