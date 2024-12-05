# Medo's Museum of Curiosities
 
Medos Museum Admin System is a web-based application designed to streamline the management of artifacts, visitors, events, and ticket purchases for a museum. This project uses PHP, MySQL, and HTML/CSS to provide an efficient and user-friendly administrative interface.

## Features
Admin Features:
* Manage Artifacts: View, add, edit, and delete museum artifacts.
* Visitor Management: Manage visitor information and profiles.
* Event Scheduling: Organize and manage museum events.
* Ticket Sales: Allow administrators to process ticket purchases for visitors.
User Interface:
Clean navigation for easy access to functionality. Toggleable forms for quick data entry and updates.

## Project Structure

├── index.html                  # Landing page

├── admin

│   ├── artifact.php            # Manage artifacts 

│   ├── membership.php          # Manage visitors 

│   ├── schedule_programs.php   # Manage events

|   ├── schedule_staff.php      # Manage staff assignments

│   └── tickets.php             # Process ticket purchases

├── other assets

│   ├── navbar.html             # Style for navigation bar

│   └── styles.css              # Shared CSS file for styling

|

└── db

    └── medosmuseum.sql         # SQL script for database 
    

## Setup Instructions
* Clone the repository
* Set up the database, importing medosmuseum into myPHPAdmin
* Configure the database connection:
        Edit the db/connection.php file with your database credentials:

            $servername = "localhost";

            $username = "root";

            $password = "";

            $dbname = "medosmuseum";

* Start a local server:
    Use XAMPP or any local server to host the project.
    Place the project files in the server's htdocs or equivalent folder.

* Access the application:
    Open your web browser and navigate to http://localhost/medosMuseum/.

## Technologies Used
Frontend: HTML, CSS, little JavaScript
Backend: PHP
Database: MySQL
Tools: XAMPP

## Contributions
Caitlyn Hartmann
* chartmann22

Sharon Dasari
* sharon-ds