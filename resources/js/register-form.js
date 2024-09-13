function toggleUserType() {
    const userType = document.getElementById('user_type').value;
    const volunteerFields = document.getElementById('volunteer-fields');
    const organizationFields = document.getElementById('organization-fields');

    if (userType === 'organization') {
        volunteerFields.style.display = 'none';
        organizationFields.style.display = 'block';
        disableFields(volunteerFields);
        enableFields(organizationFields);
    } else {
        volunteerFields.style.display = 'block';
        organizationFields.style.display = 'none';
        enableFields(volunteerFields);
        disableFields(organizationFields);
    }
}

function disableFields(container) {
    container.querySelectorAll('input, select, textarea').forEach(el => {
        el.disabled = true;
        el.required = false;
    });
}

function enableFields(container) {
    container.querySelectorAll('input, select, textarea').forEach(el => {
        el.disabled = false;
        el.required = el.hasAttribute('data-required');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    toggleUserType();

    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const userType = document.getElementById('user_type').value;
        const volunteerFields = document.getElementById('volunteer-fields');
        const organizationFields = document.getElementById('organization-fields');

        if (userType === 'volunteer') {
            disableFields(organizationFields);
        } else {
            disableFields(volunteerFields);
        }
    });
});

window.toggleUserType = toggleUserType;