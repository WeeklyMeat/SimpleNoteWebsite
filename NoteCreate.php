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

                    if(!empty($_GET["NoteToChange"])) {

                        $TitleToChange = strtolower(htmlspecialchars(trim($_GET["NoteToChange"])));
                        $NoteToChange = new Note($TitleToChange, "", "");
                    }
                ?>
                
                <br><input class="NoteCreate_Text" type="text" name="Title" value="<?php     // Fills in the title of the Note.
                    if(!empty($NoteToChange)) {
                        $Title = $NoteToChange->GetTitle();
                        echo $Title;
                    }
                ?>" placeholder="Titel" required><br>

                <br><input class="NoteCreate_Text" type="text" name="Author" value=<?php    // Fills in the author of the Note.
                    if(!empty($NoteToChange)) {
                        $Author = $NoteToChange->GetAuthor();
                        echo $Author;
                    }
                ?>placeholder="Author" required><br>

                <br><textarea class="NoteCreate_Note" name="NewNote" rows="5" cols="35" placeholder="Ihre Notiz:" required><?php    // Fills in the prepared Note.
                    if(!empty($NoteToChange)) {
                        $Note = $NoteToChange->GetNote();
                        echo $Note;
                    }
                    ?></textarea><br><br>
                    
                <input class="NoteCreate_Submit" type="submit">
            </form>
        </div>
    </body>
    <footer class="Footer">
        <a class=FooterText href="Index.php">Abbrechen & zurück zur Hauptseite</a>
    </footer>
</html>