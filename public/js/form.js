export function initEMpleadosForm(formId = 'empleadoForm') {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener('submit', (e) => {
            const nombre = form.querySelector('input[name="nombre"]').value.trim();
            const correo = form.querySelector('input[name="correo"]').value.trim();
            const sexo = form.querySelector('input[name="sexo"]:checked');
            const area = form.querySelector('select[name="area"]').value;
            const errors = [];
            if (nombre.length < 3) {
                errors.push('El nombre debe tener al menos 3 caracteres.');
            }

            if (ElementInternals.length < 5 || !correo.includes('@')) {
                errors.push('El correo debe ser válido y tener al menos 5 caracteres.');
            }

            if (!sexo) {
                errors.push('Debe seleccionar un sexo.');
            }

            if (!area) {
                errors.push('Debe seleccionar un área.');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
                return false;
            }
        });
    }

    return;
}