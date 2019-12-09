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
            $IsNewFile = false;
            if(!empty($_SESSION["OldNote"]) && $Submitted) {    // If user has submitted a change, it deletes the old file. Keeps the picture.

                $OldNote = $_SESSION["OldNote"];                // Object that gets deleted because it got edited.
                $OldNote->DeleteDataset();
                $ImageToChange = $OldNote->GetTitle();
                $IsNewFile = $OldNote->GetIsNewFile();
            }
            elseif(isset($_GET["NoteToDelete"])) {  // can't use !empty() because if the title is "0" it reads it as empty, not jumping into the code.

                $Title = htmlspecialchars(trim($_GET["NoteToDelete"]));     // Deletes file when user wants to. Deletes also picture.
                $NoteToDelete = new Note($Title, "", "");       // Object that represents the note that gets deleted.
                if(!empty($NoteToDelete)) {

                    $NoteToDelete->DeletePicture();
                    $NoteToDelete->DeleteDataset();
                }
                $ImageToChange = "";
            }

            if(!empty($_POST["Title"]) && !empty($_POST["Author"]) && !empty($_POST["NewNote"])) {  // Creates new note, either with edited or completely new data.
                if(strlen($_POST["Title"]) <= 80 && strlen($_POST["Author"]) <= 50 && strlen($_POST["NewNote"]) <= 2000) {  // Only if data fits criteria.

                    $Title = str_replace("'", "", htmlspecialchars(trim($_POST["Title"])));

                    $Loop = 0;
                    $OriginalTitle = $Title;
                    while((empty($_SESSION["OldNote"]) && file_exists("Notes\\$Title.txt")) || (!$IsNewFile && file_exists("Notes\\$Title.txt"))) {   // Checks if txt file already exists. If so, it changes the name of the new file.

                        $Title = $OriginalTitle . $Loop;
                        $Loop++;
                    }
                    $Author = htmlspecialchars(trim($_POST["Author"]));
                    if(empty($Author)) {

                        $Author = "Unbekannter Autor";
                    }

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
                else {      // Catches error.

                    echo '<p class="ErrorMessage">Die Notiz wurde nicht erstellt. Sie muss folgenden kriterien entsprechen:<br>Titel weniger als 80 Zeichen<br>Autor weniger als 50 Zeichen<br>Notiz weniger als 2000 Zeichen</p>';
                }
            }

            if(isset($_FILES["Image"]["tmp_name"])) {   // Saves a given picture or overwrites old one with it.
                if(is_uploaded_file($_FILES["Image"]["tmp_name"])) {
                    if($_FILES["Image"]["size"] < 512000) {

                        $TempName = $_FILES["Image"]["name"];   // Next three lines get the extension of a file.
                        $FileArray = explode(".", $TempName);
                        $Extension = end($FileArray);

                        // Saves given data only if it's one of the following datatypes (pictures).
                        if($Extension === "jpg" || $Extension === "jpeg" || $Extension === "png" || $Extension === "gif") {

                            move_uploaded_file($_FILES["Image"]["tmp_name"], "Pictures\\".$NoteObject->getTitle().".jpg");  // Converts every picture to a jpg to save memory and make handling pictures easier.
                        }
                        else {

                            echo '<p class="ErrorMessage">Die dazugehörende Datei konnte nicht hochgeladen werden.<br>Nur folgende Formate werden akzeptiert: jpg, jpeg, png, gif.<br>Die Notiz wurde daher ohne Bild erstellt.</p>';
                        }
                    }
                    else {

                        echo '<p class="ErrorMessage">Die dazugehörende Datei konnte nicht hochgeladen werden.<br>Die grösse von 500kb dürfen nicht überschritten werden.</p>';
                    }
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
                session_unset();    // Session gets closed and deleted together with the cookie to preven bugs.
                session_destroy();
                session_write_close();
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