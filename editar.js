// Lógica para edición de celdas en la tabla
document.querySelectorAll('.editable').forEach(function(td) {
    td.ondblclick = function() {
        if (td.querySelector('input')) return; // Si ya hay un input, no hace nada
        var valorOriginal = td.textContent;
        var input = document.createElement('input');
        input.type = (td.dataset.campo === 'Edad' || td.dataset.campo === 'calificacion') ? 'number' : 'text';
        input.value = valorOriginal;
        input.className = 'form-control form-control-sm';
        input.style.width = '100px';
        if(td.dataset.campo === 'calificacion') {
            input.min = 0;
            input.max = 10;
        }
        td.textContent = '';
        td.appendChild(input);
        input.focus();

        input.onblur = function() {
            guardarCambio(td, input.value, valorOriginal);
        };
        input.onkeydown = function(e) {
            if (e.key === 'Enter') {
                input.blur();
            } else if (e.key === 'Escape') {
                td.textContent = valorOriginal;
            }
        };
    };
});

// Función para guardar el cambio realizado en la celda
function guardarCambio(td, nuevoValor, valorOriginal) {
    var id = td.dataset.id;
    var campo = td.dataset.campo;

    if (nuevoValor === valorOriginal) {
        td.textContent = valorOriginal;
        return;
    }

    if (campo === 'calificacion') {
        var num = Number(nuevoValor);
        if (isNaN(num) || num < 0 || num > 10) {
            alert('La calificación debe estar entre 0 y 10');
            td.textContent = valorOriginal;
            return;
        }
    }

    // Enviar actualización al servidor
    fetch('actualizar.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}&campo=${campo}&valor=${encodeURIComponent(nuevoValor)}`
    })
    .then(res => res.text())
    .then(resp => {
        if (resp.trim() === 'OK') {
            td.textContent = nuevoValor;
            if (campo === 'calificacion') location.reload(); // Recargar para actualizar estado
        } else {
            alert('Error al actualizar');
            td.textContent = valorOriginal;
        }
    })
    .catch(() => {
        alert('Error de conexión');
        td.textContent = valorOriginal;
    });
}