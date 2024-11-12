<?php
require 'model/Contact.php';

class ContactController
{
    public function show()
    {
        $contactModel = new Contact();
        $contacts = $contactModel->getAllWithDetails();

        require 'views/contacts/show.view.php';
    }
    public function updateReplyStatus()
    {
        $contactModel = new Contact();

        // Get the contact ID and is_reply value from the form submission
        $contactId = $_POST['id'];
        $isReply = $_POST['is_reply'] == '1' ? true : false;

        // Update only the is_reply field in the database
        $data = [
            'is_reply' => $isReply
        ];
        $contactModel->update($contactId, $data);

        // Output JavaScript to open the mail client and then redirect back to the contact management page
        echo "<script>
        window.location.href = 'mailto:user@example.com';
        setTimeout(() => { window.location.href = '/contacts'; }, 1000);
    </script>";
        exit;
    }
}
