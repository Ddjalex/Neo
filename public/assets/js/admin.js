function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

function editService(service) {
    document.getElementById('edit_id').value = service.id;
    document.getElementById('edit_category').value = service.category;
    document.getElementById('edit_title').value = service.title;
    document.getElementById('edit_description').value = service.description;
    document.getElementById('edit_order_position').value = service.order_position;
    openModal('editServiceModal');
}

function editProject(project) {
    document.getElementById('edit_project_id').value = project.id;
    document.getElementById('edit_project_title').value = project.title;
    document.getElementById('edit_project_description').value = project.description;
    document.getElementById('edit_project_category').value = project.category;
    openModal('editProjectModal');
}

function viewLead(lead) {
    document.getElementById('view_name').textContent = lead.name;
    document.getElementById('view_email').textContent = lead.email;
    document.getElementById('view_phone').textContent = lead.phone || 'N/A';
    document.getElementById('view_date').textContent = new Date(lead.created_at).toLocaleString();
    document.getElementById('view_message').textContent = lead.message;
    document.getElementById('lead_id').value = lead.id;
    document.getElementById('lead_status').value = lead.status;
    openModal('viewLeadModal');
}
