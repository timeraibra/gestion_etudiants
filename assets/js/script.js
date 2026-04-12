// 🔥 Confirmation suppression
function confirmDelete() {
    return confirm("⚠️ Voulez-vous vraiment supprimer cet étudiant ?");
}

// 🔥 Message automatique (disparaît)
setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
        alert.style.display = 'none';
    }
}, 3000);