// validation.js

function validateRegisterForm() {
    const name = document.getElementById('name').value.trim();
    const age = document.getElementById('age').value.trim();
    const gender = document.getElementById('gender').value.trim();
    const medicalHistory = document.getElementById('medical_history').value.trim();
    const contactInformation = document.getElementById('contact_information').value.trim();
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!name || !age || !gender || !medicalHistory || !contactInformation || !username || !password) {
        alert('Please fill out all fields.');
        return false;
    }

    // Additional validations can be added here

    return true;
}

function validateLoginForm() {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!username || !password) {
        alert('Please enter both username and password.');
        return false;
    }

    return true;
}
