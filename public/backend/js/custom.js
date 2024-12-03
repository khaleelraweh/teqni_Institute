//show alert function
function showAlert(iconType, titleMessage, textMessage, confirmButtonText = "OK") {
    Swal.fire({
        icon: iconType || 'info', // Default icon is 'info' if not provided
        title: titleMessage || 'Alert',
        text: textMessage || '',
        confirmButtonText: confirmButtonText,
    });
}


//Confirm Delete Function
function confirmDelete(deleteElementId, confirmMessage, confirmButtonText = "Yes", cancelButtonText = "Cancel") {
    Swal.fire({
        title: confirmMessage || 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(deleteElementId).submit();
        }
    });
}


// Copy Button Functionality
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".copyButton").forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default behavior

            // Get the dynamic text to copy
            const textToCopy = button.getAttribute("data-copy-text");

            // Copy text to clipboard
            const tempInput = document.createElement("input");
            tempInput.value = textToCopy;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            // Show the copied message
            const id = button.getAttribute("data-id");
            const copyMessage = document.querySelector(`.copyMessage[data-id="${id}"]`);
            if (copyMessage) {
                copyMessage.style.display = "inline";
                setTimeout(() => {
                    copyMessage.style.display = "none";
                }, 2000); // Hide the message after 2 seconds
            }
        });
    });
});
