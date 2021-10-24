## Description
This repository consists of a PHP REST API which handles my MIUN courses.
The courses are stored in a database, please refer to the _Create.sql_ file in the _db_ folder. 
There is also a web application which outputs the current courses. 
For more information on this application, please refer to its [repository](https://github.com/marzin89/miun-courses).
### REST API/CLASSES
The API has CRUD support and can be accessed from any domain using HTTPS. Responses are in JSON. 
The REST API uses two classes, _Education.php_ and _Database.php_. Those can be found in the _classes_ folder.
The API can be accessed [here](https://studenter.miun.se/~mazi2001/writeable/dt173g/moment5/rest-api/api/api.php).
#### Methods
##### GET
All currently stored courses will be returned. If the database table is empty, a 404 error code will be returned.
##### POST
In order to add a course, the following parameters are required:
- Course code
- Course name
- Course progression
- Course syllabus
For details, please refer to the repository above. When a course cannot be added, a 503 error code is returned.
##### PUT
In order to edit a course, in addition to the parameters above (POST), you will also need to provide its ID.
When a course cannot be edited, or if the ID is missing, a 503 error code is returned.
##### DELETE
Deleting a course only requires an ID. When a course cannot be deleted, or if the ID is missing, a 503 error code is returned.
