function validateLogin() {
    let name = document.getElementById("name").value.trim();
    let password = document.getElementById("password").value;
    let message = "";

    if (name.length < 5) {
        message += "Name must be at least 5 characters.\n";
    }
    if (password.length < 8) {
        message += "Password must be at least 8 characters.";
    }

    if (message !== "") {
        alert(message);
        return false;
    }

    return true;
}

function validateRegistration() {
    let name = document.getElementById("full_name").value.trim();
    let password = document.getElementById("password").value;
    let message = "";

    if (name.length < 5) {
        message += "Name must be at least 5 characters.\n";
    }
    if (password.length < 8) {
        message += "Password must be at least 8 characters.";
    }

    if (message !== "") {
        alert(message);
        return false;
    }

    return true;
}

function validateBorrowForm() {
    const bookTitle = document.querySelector('input[name="book_title"]');
    const author = document.querySelector('input[name="author"]');
    const borrowDate = document.querySelector('input[name="borrow_date"]');
    const dueDate = document.querySelector('input[name="due_date"]');

    if (!bookTitle || !author || !borrowDate || !dueDate) {
        return true;
    }

    if (!bookTitle.value.trim() || !author.value.trim()) {
        alert('Book title and author are required.');
        return false;
    }

    if (new Date(dueDate.value) <= new Date(borrowDate.value)) {
        alert('Due date must be after the borrow date.');
        return false;
    }

    return true;
}

function validateMembershipForm() {
    const name = document.getElementById('customer_name');
    const transaction = document.getElementById('transaction_id');
    const paymentDate = document.getElementById('payment_date');

    if (name && !name.value.trim()) {
        alert('Customer name is required.');
        return false;
    }

    if (transaction && !transaction.value.trim()) {
        alert('Transaction ID is required.');
        return false;
    }

    if (paymentDate && !paymentDate.value) {
        alert('Payment date is required.');
        return false;
    }

    return true;
}
