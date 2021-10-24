CREATE TABLE IF NOT EXISTS education (
    education_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(10) NOT NULL,
    course_name VARCHAR(50) NOT NULL,
    course_progression VARCHAR(1) NOT NULL,
    education_edited DATE,
    course_syllabus VARCHAR(200) NOT NULL
);