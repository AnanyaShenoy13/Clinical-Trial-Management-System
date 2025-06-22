// scripts.js

document.addEventListener('DOMContentLoaded', () => {
    // Add any general initialization code here
    loadParticipantDashboard();
    loadResearcherDashboard();
});

function loadParticipantDashboard() {
    // Fetch participant data and update the dashboard
    if (document.getElementById('dashboardContent')) {
        fetch('participant_dashboard.php')
            .then(response => response.json())
            .then(data => {
                const dashboardContent = document.getElementById('dashboardContent');
                dashboardContent.innerHTML = `
                    <h2>Welcome, ${data.name}</h2>
                    <p>Age: ${data.age}</p>
                    <p>Gender: ${data.gender}</p>
                    <p>Contact: ${data.contact_information}</p>
                `;
            })
            .catch(error => console.error('Error fetching participant data:', error));
    }
}

function loadResearcherDashboard() {
    // Fetch trial and participant data and update the dashboard
    if (document.getElementById('dashboardContent')) {
        fetch('researcher_dashboard.php')
            .then(response => response.json())
            .then(data => {
                const dashboardContent = document.getElementById('dashboardContent');
                let trialsHtml = '<h2>Active Trials</h2><ul>';
                data.trials.forEach(trial => {
                    trialsHtml += `<li>${trial.name}: ${trial.description}</li>`;
                });
                trialsHtml += '</ul>';
                dashboardContent.innerHTML = trialsHtml;
            })
            .catch(error => console.error('Error fetching researcher data:', error));
    }
}
