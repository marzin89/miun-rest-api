<?php
// Inkluderar klasserna
include_once '../classes/Database.php';
include_once '../classes/Education.php';

// Headers
// Typ av innehåll
header('Content-Type: application/json; charset=UTF8');
// Tillåter åtkomst från alla domäner
header('Access-Control-Allow-Origin: *');
// Tillåtna metoder
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');
// Tillåter CORS
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

// Läser in metod i anropet
$method = $_SERVER['REQUEST_METHOD'];

// Läser in ID om det finns
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
// Nya instanser av klasserna som hanterar anslutningen till databasen och utbildningarna
$database = new Database();
$education = new Education();

// Switch-sats
switch ($method) {
    // Om utbildningar ska hämtas
    case 'GET':

        // Om det finns utbildningar
        if (count($education->educationArr) > 0) {

            // Bekräftar anropet
            http_response_code(200);
            // Lagrar arrayen med utbildningar
            $response = $education->educationArr;
        
        // Om inga utbildningar finns
        } else {

            // Skickar ett felmeddelande
            http_response_code(404);
            $response = array('message' => 'Inga utbildningar hittades.');
        }
    break;

    // Om utbildningar ska läggas till
    case 'POST':

        // Läser in all data i anropet
        $data = json_decode(file_get_contents('php://input'));

        // Lagrar parametervärden i objektets properties
        $education->course_code = $data->course_code;
        $education->course_name = $data->course_name;
        $education->course_progression = $data->course_progression;
        $education->course_syllabus = $data->course_syllabus;

        // Om utbildningen har lagts till
        if ($education->addCourse()) {

            // Bekräftar anropet
            http_response_code(200);
            $response = array('message' => 'Utbildningen har lagts till.');

        // Om utbildningen inte kunde läggas till
        } else {

            // Skickar ett felmeddelande
            http_response_code(503);
            $response = array('message' => 'Det gick inte att lägga till utbildningen.');
        }
    break;

    // Om utbildningar ska uppdateras
    case 'PUT':

        // Läser in all data i anropet
        $data = json_decode(file_get_contents('php://input'));

        // Lagrar parametervärden i objektets properties
        $education->course_code = $data->course_code;
        $education->course_name = $data->course_name;
        $education->course_progression = $data->course_progression;
        $education->course_syllabus = $data->course_syllabus;        

        // Om ett ID finns
        if (isset($id)) {

            // Hämta utbildningen
            $education->getID($id);

            // Om det går att uppdatera utbildningen
            if ($education->updateCourse()) {

                // Bekräftar anropet
                http_response_code(200);
                $response = array('message' => 'Utbildningen har uppdaterats.');
            
            // Om det inte går att uppdatera utbildningen
            } else {

                // Skickar ett felmeddelande
                http_response_code(503);
                $response = array('message' => 'Det gick inte att uppdatera utbildningen.');
            }

        // Om inget ID finns
        } else {

            // Skickar ett felmeddelande
            http_response_code(503);
            $response = array('message' => 'ID saknas.');
        }
    break;

    // Om utbildningar ska raderas
    case 'DELETE':

        // Om ett ID finns
        if (isset($id)) {

            // Hämta utbildningen
            $education->getID($id);

            // Om det går att radera utbildningen
            if ($education->deleteCourse()) {

                // Bekräftar anropet
                http_response_code(200);
                $response = array('message' => 'Utbildningen har raderats.');

            // Om det inte går att radera utbildningen
            } else {

                // Skickar ett felmeddelande
                http_response_code(503);
                $response = array('message' => 'Det gick inte att radera utbildningen.');
            }

        // Om inget ID finns
        } else {

            // Skickar ett felmeddelande
            $response = array('message' => 'ID saknas.');
        }
    break;
}
// Skickar svaret i JSON-format
echo json_encode($response);