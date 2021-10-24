<?php
include_once 'Database.php';
// Klass som hanterar utbildningar
class Education {

    // Properties
    public $id;
    public $course_code;
    public $course_name;
    public $course_progression;
    public $course_syllabus;
    public $edited;
    public $educationArr = [];
    public $education = [];
    public $error;
    public $confirm;
    public $conn;
    
    //Konstruerare
    public function __construct() {

        $database = new Database();
        $this->conn = $database->conn;

        if ($database->error) {
            $this->error = $database->error;
        }

        $query = 'SELECT * FROM education_2';
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                array_push($this->educationArr, $row);
            }

        } else {
            $this->error = 'Inga utbildningar hittades.';
        }
    }

    // Lägger till utbildningar
    public function addCourse() : bool {

        $query = $this->conn->prepare('INSERT INTO education_2 (course_code, course_name, course_progression, 
        course_syllabus) VALUES (?, ?, ?, ?);');

        $query->bind_param('ssss', $this->course_code, $this->course_name, $this->course_progression, 
            $this->course_syllabus);
        $query->execute();

        if (!$this->conn->connect_error) {

            $this->confirm = 'Utbildningen har lagts till.';
            return true;
        }
    }

    // Tar bort utbildningar
    public function deleteCourse() : bool {

        $query = $this->conn->prepare('DELETE FROM education_2 WHERE education_id = ?');
        $query->bind_param('i', $this->id);
        $query->execute();

        if (!$this->conn->connect_error) {

            $this->confirm = 'Utbildningen har raderats.';
            return true;
        }
    }

    // Uppdaterar utbildningar
    public function updateCourse() : bool {

        $query = $this->conn->prepare('UPDATE education_2 SET course_code = ?, course_name = ?, 
            course_progression = ?, course_syllabus = ?, education_edited = ? WHERE education_id = ?');

        $query->bind_param('sssssi', $this->course_code, $this->course_name, $this->course_progression, 
            $this->course_syllabus, $this->edited, $this->id);

        $this->edited = date('y-m-d'); 

        $query->execute();

        if (!$this->conn->connect_error) {

            $this->confirm = 'Utbildningen har uppdaterats.';
            return true;
        } 
    }

    // Hämtar utbildningens ID ur arrayen
    public function getId($id) : bool {

        if ($this->education = $this->educationArr[$id]) {
            $this->id = $this->education['education_id'];
            return true;
        } else {
            return false;
        }
    }
}
