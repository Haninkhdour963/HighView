<?php
require 'model/Review.php';

class ReviewController
{
    public function show()
    {

        // Initialize alert variables
        $showAlert = false;
        $alertType = '';
        $alertMessage = '';

        // Check session for alert messages
        if (isset($_SESSION['alert'])) {
            $showAlert = true;
            if ($_SESSION['alert'] === 'success') {
                $alertType = 'success';
                $alertMessage = 'Coupon status updated successfully!';
            } else {
                $alertType = 'danger';
                $alertMessage = 'Failed to update coupon status.';
            }

            // Clear the alert from session after getting it
            unset($_SESSION['alert']);
        }

        $reviewModel = new Review();
        $reviews = $reviewModel->getAllWithDetails();

        require 'views/reviews/show.view.php';
    }

    public function view()
    {
        $reviewModel = new Review();

        // Get the review ID from the request parameters
        $reviewId = $_GET['id'] ?? null;

        // Validate if ID is provided
        if (!$reviewId) {
            header('Location: /reviews');
            exit;
        }

        // Fetch review details from the model
        $review = $reviewModel->getReviewDetails($reviewId);

        if (!$review) {
            // Redirect or show an error if review not found
            $_SESSION['alert'] = 'Review not found.';
            header('Location: /reviews');
            exit;
        }

        // Include the view to display review details
        require 'views/reviews/view.view.php';
    }


    // Method to update visibility
    public function updateStatus()
    {
        $reviewModel = new Review();
        $reviewId = $_POST['id'];

        // Toggle the active status
        $success = $reviewModel->toggleActiveStatus($reviewId);

        // Set a session message based on success or failure
        $_SESSION['alert'] = $success ? 'success' : 'danger';

        // Redirect back to the coupon listing page
        header('Location: /reviews');
        exit;
    }
    public function delete()
    {
        $reviewModel = new Review();
        $id = $_POST['id'];
        $reviewModel->delete($id);

        header('Location: /reviews');
        exit;
    }
}
