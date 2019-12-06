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
                $Submitted = $_POST["SubmitPressed"];           // Finds out if user submitted the edited note or not.
            }

            session_start();
            if(!empty($_SESSION["OldNote"]) && $Submitted) {    // If user has submitted a change, it deletes the old file. Keeps the picture.

                $OldNote = $_SESSION["OldNote"];                // Object that gets deleted because it got edited.
                $OldNote->DeleteDataset();
                $ImageToChange = $OldNote->getTitle();
            }
            elseif(!empty($_GET["NoteToDelete"])) {

                $Title = htmlspecialchars(trim($_GET["NoteToDelete"]));     // Deletes file when user wants to. Deletes also picture.
                $NoteToDelete = new Note($Title, "", "");       // Object that represents the note that gets deleted.
                if(!empty($NoteToDelete)) {

                    $NoteToDelete->DeletePicture();
                    $NoteToDelete->DeleteDataset();
                }
                $ImageToChange = "";
            }
            session_abort();

            if(!empty($_POST["Title"]) && !empty($_POST["Author"]) && !empty($_POST["NewNote"])) {  // Creates new note, either with edited or completely new data.

                $Title = str_replace("'", "", htmlspecialchars(trim($_POST["Title"])));
                $Author = htmlspecialchars(trim($_POST["Author"]));
                $Note = htmlspecialchars(trim($_POST["NewNote"]));

                $NoteObject = new Note($Title, $Author, $Note);     // Object that represents note.
                $NoteObject->InsertDataset();

                if(isset($ImageToChange) && file_exists("Pictures\\".$ImageToChange.".jpg")) {      // Renames old picture if a namechange happened.
                    
                    rename("Pictures\\".$ImageToChange.".jpg", "Pictures\\".$NoteObject->getTitle().".jpg");
                }

                if(isset($_POST["DeleteImage"])) {  // Deletes image if user decided to in the process of editing it.

                    $OldNote->DeletePicture();
                }
            }

            if(isset($_FILES["Image"])){        // Saves a given picture or overwrites old one with it.

                $TempName = $_FILES["Image"]["name"];   // Next three lines get the extension of a file.
                $FileArray = explode(".", $TempName);
                $Extension = end($FileArray);

                // Saves given data only if it's one of the following datatypes (pictures).
                if(strcasecmp($Extension, "jpg") || strcasecmp($Extension, "jpeg") || strcasecmp($Extension, "gif") || strcasecmp($Extension, "png")) {

                    move_uploaded_file($_FILES["Image"]["tmp_name"], "Pictures\\".$NoteObject->getTitle().".jpg");  // Converts every picture to a jpg to save memory and make handling pictures easier.
                }
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