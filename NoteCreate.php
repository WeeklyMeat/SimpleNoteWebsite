<!DOCTYPE html>

<html lang="de">

    <!-- Head -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="cancer.css">
        <title>Create your note! :D</title>
    </head>

    <!-- Body -->
    <body>
        <div class="NoteCreate">
            <form action="Index.php" method="post">
                <?php
                    require_once 'ClassNote.php';

                    $Title = "";
                    $Author = "";
                    $Note = "";

                    if(!empty($_GET["NoteToChange"])) {

                        $TitleToChange = strtolower(htmlspecialchars(trim($_GET["NoteToChange"])));
                        $NoteToChange = new Note($TitleToChange, "", "");

                        session_start();
                        $_SESSION["NoteToDelete"] = $NoteToChange;

                        $Title = $NoteToChange->GetTitle();
                        $Author = $NoteToChange->GetAuthor();
                        $Note = $NoteToChange->GetNote();
                    }
                ?>
                
                <br><input class="NoteCreate_Text" type="text" name="Title" value="<?php     // Fills in the title of the Note.
                        echo $Title;
                ?>" placeholder="Titel" required><br>

                <br><input class="NoteCreate_Text" type="text" name="Author" value="<?php    // Fills in the author of the Note. 
                        echo $Author;
                ?>" placeholder="Author" required><br>

                <br><textarea class="NoteCreate_Note" name="NewNote" rows="5" cols="35" placeholder="Ihre Notiz:" required><?php    // Fills in the prepared Note.
                    if(!empty($_POST["NewNote"])) {
                        $NewNote = htmlspecialchars(trim($_POST["NewNote"]));
                        echo $NewNote;
                    }
                    else {
                        echo $Note;
                    }
                    ?></textarea><br><br>
                    
                <input class="NoteCreate_Submit" type="submit" name="SubmitPressed">
            </form>
        </div>
    </body>
    <footer class="Footer">
        <a class=FooterText href="Index.php">Abbrechen & zurück zur Hauptseite</a>
    </footer>
</html>