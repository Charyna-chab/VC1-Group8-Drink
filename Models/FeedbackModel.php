<?php
require_once 'Database/database.php';

class FeedbackModel
{
    private $pdo;

    function __construct()
    {
        $this->pdo = new Database();
    }

    function getUser()
    {
        $feedbacks = $this->pdo->query("SELECT * FROM users ");
        $feedbacks->execute();
        return $feedbacks->fetchAll();
    }
    function getFeedbacks()
{
    $stmt = $this->pdo->query("SELECT feedbacks.feedback_id,feedbacks.comment,feedbacks.date,users.name AS user_name,users.email AS user_email
    FROM feedbacks LEFT JOIN users ON feedbacks.user_id = users.user_id ORDER BY feedbacks.date DESC");
    return $stmt->fetchAll();
}

    function createFeedback($data)
    {
        try {
            $query = "INSERT INTO feedbacks (user_name,comment,date, user_id)
                      VALUES (:user_name, :comment, :date , :user_id)";

            // Use the query method from your Database class
            $result = $this->pdo->query($query, [
                'user_name' => $data['message'],
                'comment' => $data['comment'],
                'date' => $data['date'],
                'user_id' => $data['user_id']
            ]);

            return $result;
        } catch (PDOException $e) {
            // Handle or log the error
            error_log("Error creating feedback: " . $e->getMessage());
            return false;
        }
    }

    function getFeedback($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM feedbacks WHERE feedback_id = :feedback_id", ['feedback_id' => $id]);
        $feedback =  $stmt->fetch();
        return $feedback;

    }

    function deleteFeedback($id)
    {
        $stmt = $this->pdo->query("DELETE FROM feedbacks WHERE feedback_id = :feedback_id", ['feedback_id' => $id]);
      
    }
}
