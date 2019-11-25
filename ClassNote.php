<?php

    class Note {

        // Member Variables

        protected $DateOfChange;
        protected $Author;
        protected $NameOfFile;
        protected $Note;

        // Member Functions

        public function InsertDataset() {       // Inserts data of current object into a TXT file.

            $NewDataset = fopen("Notes/$this->NameOfFile.txt", "w");
            fwrite($NewDataset, $this->DateOfChange."\n".$this->Author."\n".$this->Note);
            fclose($NewDataset);
        }

        public function DeleteDataset() {       // Deletes the TXT file with the name that was given to the object.

            unlink("Notes/$this->NameOfFile.txt");
        }

        public function ChangeDataset($NewNote) {   // TOOOOOOOOOOODOOOOOOOOOOOOOOOOOOOOOOO

            $this->Note = $NewNote;
            $this->DateOfChange = $this->GetCurrentDate();

            $this->DeleteDataset();
            $this->InsertDataset();
        }

            // Getter

            public function GetNote() {     // Returns Note.

                return $this->Note;
            }

            public function GetTitle() {    // Returns Title.

                return $this->NameOfFile;
            }

            public function GetAuthor() {

                return $this->Author;
            }

            // Protected Functions

            protected function GetCurrentDate() {   // Gets current date and returns it in format dd/MM//yyyy.

                $Date = getdate();
                $CurrentDate = $Date["mday"] . "/" . $Date["mon"] . "/" . $Date["year"];
                return $CurrentDate;
            }

        // Constructor

        public function __construct($NameOfFile, $Note, $Author) {

            $this->NameOfFile = $NameOfFile;

            if(!empty($Note)) {     // If a second Parameter was given, he inserts the value of it to this.Note.

                $this->Note = $Note;
                $this->Author = $Author;
                $this->DateOfChange = $this->GetCurrentDate();
            }
            else {                  // If it doesn't have a second parameter given with it, we assume the note already exists.

                $FileRows = file("Notes/$NameOfFile.txt");
                
                $this->DateOfChange = trim(array_shift($FileRows));
                $this->Author = trim(array_shift($FileRows));
                $this->Note = trim(implode($FileRows));
            }
        }
    }
?>