document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du canvas
    const canvas = document.getElementById('signatureCanvas');
    const form = document.getElementById('signatureForm');
    const saveBtn = document.getElementById('saveSignature');
    const clearBtn = document.getElementById('clearSignature');
    
    if (!canvas || !form) {
        console.error('Éléments requis non trouvés');
        return;
    }

    // Configuration du canvas
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
    }
    
    // Initialiser SignaturePad
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)',
        minWidth: 1,
        maxWidth: 2.5,
        throttle: 16
    });

    // Redimensionnement initial
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    // Effacer la signature
    clearBtn.addEventListener('click', function() {
        signaturePad.clear();
    });

    // Sauvegarder la signature
    saveBtn.addEventListener('click', function() {
        if (signaturePad.isEmpty()) {
            alert('Veuillez fournir votre signature');
            return;
        }

        // Récupérer les données de la signature
        const signatureData = signaturePad.toDataURL('image/png');
        document.getElementById('signatureData').value = signatureData;

        // Créer une nouvelle promesse pour la soumission
        new Promise((resolve, reject) => {
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Erreur HTTP');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url || window.location.href;
                } else {
                    throw new Error(data.message || 'Erreur inconnue');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Échec de l\'enregistrement: ' + error.message);
            });
        });
    });
});