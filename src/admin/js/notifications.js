// Function to display the custom toast
function notif(type, icon, title, subtitle, message) {
    // Create the toast element template
    var toastTemplate = `
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 2147483647">
        <div id="customToast" class="bs-toast toast fade hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
            <div class="toast-header">
                <i class="" id="toastIcon"></i>
                <strong class="me-auto ms-2" id="toastTitle">Title</strong>
                <small id="toastSubtitle">Subtitle</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Message
            </div>
        </div>
    </div>
`;

    // Append the toast element template to the DOM
    document.body.insertAdjacentHTML('beforeend', toastTemplate);

    // Get the reference to the newly created toast element
    var toast = document.getElementById('customToast');

    // Update the toast content with the provided data
    var toastTitle = toast.querySelector('#toastTitle');
    var toastSubtitle = toast.querySelector('#toastSubtitle');
    var toastMessage = toast.querySelector('#toastMessage');
    var toastIcon = toast.querySelector('#toastIcon');

    toast.classList.remove('bg-primary', 'bg-success', 'bg-warning', 'bg-info', 'bg-danger');
    toast.classList.add('bg-' + type);

    toastIcon.className = icon;
    toastTitle.textContent = title;
    toastSubtitle.textContent = subtitle;
    toastMessage.textContent = message;

    // Create a new Bootstrap Toast instance
    var toastInstance = new bootstrap.Toast(toast);

    // Show the toast
    toastInstance.show();
}