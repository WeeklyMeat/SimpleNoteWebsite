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
            <form enctype="multipart/form-data" action="Index.php" method="post">
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                <?php
                    require_once 'ClassNote.php';
                    session_start();

                    $Title = "";        // Setting standard values.
                    $Author = "";
                    $Note = "";
                    $_SESSION["ToDelete"] = false;

                    if(!empty($_GET["NoteToChange"])) {     // Determines what notes has to change.

                        $TitleToChange = htmlspecialchars(trim($_GET["NoteToChange"]));
                        $NoteToChange = new Note($TitleToChange, "", "");

                        $_SESSION["NoteToDelete"] = $NoteToChange;      // Gives a copy of the current note to Index.php to delete.
                        $_SESSION["ToDelete"] = true;

                        $Title = $NoteToChange->GetTitle();
                        $Author = $NoteToChange->GetAuthor();
                        $Note = $NoteToChange->GetNote();
                    }
                ?>
                
                <br><input class="NoteCreate_Text" type="text" name="Title" value="<?php     // Fills in the title of the note.
                        echo $Title;
                ?>" placeholder="Titel" required><br>

                <br><input class="NoteCreate_Text" type="text" name="Author" value="<?php    // Fills in the author of the note. 
                        echo $Author;
                ?>" placeholder="Author" required><br>

                <br><textarea class="NoteCreate_Note" name="NewNote" rows="5" cols="35" placeholder="Ihre Notiz:" required><?php    // Fills in the prepared note.
                    if(!empty($_POST["NewNote"])) {                                 // Note preview dependend on how you get here (edit/create note).
                        $NewNote = htmlspecialchars(trim($_POST["NewNote"]));
                        echo $NewNote;
                    }
                    else {
                        echo $Note;
                    }
                    ?></textarea><br><br>

                <br><input class="UploadData" type="file" name="Image"><?php
                    if(file_exists("Pictures\\$Title.jpg")) {

                        echo '<label class="DeleteSwitch"><input type="checkbox" name="DeleteImage" value=true> Bild löschen<label>';
                    }
                ?><input class="NoteCreate_Submit" type="submit" name="SubmitPressed">
            </form>
        </div>
    </body>
    <footer class="Footer">
        <a class=FooterText href="Index.php">Abbrechen & zurück zur Hauptseite</a>
    </footer>
</html>