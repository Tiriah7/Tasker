<?php
function sendTaskEmail($to, $title, $description, $deadline, $username) {
    $subject = "New Task Assigned: $title";
    $message = "Hello $username,\n\n"
             . "You have been assigned a new task:\n\n"
             . "Title: $title\n"
             . "Description: $description\n"
             . "Deadline: $deadline\n\n"
             . "Please log in to your dashboard to view and update the task.\n\n"
             . "Regards,\nTasker Admin";

    $headers = "From: taskmanager@example.com";

    return mail($to, $subject, $message, $headers);
}
