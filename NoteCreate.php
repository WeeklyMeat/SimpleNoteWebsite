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
                
                <br><input class="NoteCreate_Text" type="text" name="Title" value="" placeholder="Titel" required><br>
                <br><input class="NoteCreate_Text" type="text" name="Author" value="" placeholder="Author" required><br>
                <br><textarea class="NoteCreate_Note" name="NewNote" rows="5" cols="35" placeholder="Ihre Notiz:" required><?php
                        if(!empty($_POST["NewNote"])) {
                            $ProvNote = $_POST["NewNote"];
                            echo "$ProvNote";
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