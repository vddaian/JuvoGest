  // Función genérica para validar longitud de un campo
  function validateLength(field, minLength, maxLength) {
    const value = field.value.trim();
    if (value.length < minLength || value.length > maxLength) {
        field.classList.add("error");
        return false;
    } else {
        field.classList.remove("error");
        return true;
    }
}

// Función para validar campos numéricos (teléfono, CP, asistentes)
function validateNumber(field, length) {
    const pattern = new RegExp(`^\\d{${length}}$`);
    if (!pattern.test(field.value)) {
        field.classList.add("error");
        return false;
    } else {
        field.classList.remove("error");
        return true;
    }
}

// Función para validar emails
function validateEmail(field) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(field.value)) {
        field.classList.add("error");
        return false;
    } else {
        field.classList.remove("error");
        return true;
    }
}

// Función para validar fechas
function validateDate(field) {
    if (!field.value) {
        field.classList.add("error");
        return false;
    } else {
        field.classList.remove("error");
        return true;
    }
}

// Función para validar horas
function validateTime(field) {
    const timePattern = /^([01]\d|2[0-3]):([0-5]\d)$/;
    if (!timePattern.test(field.value)) {
        field.classList.add("error");
        return false;
    } else {
        field.classList.remove("error");
        return true;
    }
}

// Función para validar imágenes (máx 400x400)
function validateImage(field) {
    if (field.files[0]) {
        const img = new Image();
        img.src = URL.createObjectURL(field.files[0]);
        img.onload = function() {
            if (img.width > 400 || img.height > 400) {
                field.classList.add("error");
            } else {
                field.classList.remove("error");
            }
        }
    }
}

function validateUserForm(form) {
    let valid = true;
    valid = validateLength(form.nombreEntidad, 1, 30) && valid;
    valid = validateLength(form.username, 1, 20) && valid;
    valid = validateLength(form.password, 1, 60) && valid;
    valid = validateLength(form.direccion, 1, 50) && valid;
    valid = validateLength(form.localidad, 1, 20) && valid;
    valid = validateNumber(form.cp, 5) && valid;
    valid = validateNumber(form.telefono, 9) && valid;
    valid = validateEmail(form.email) && valid;
    validateImage(form.foto);
    return valid;
}

function validatePartnerForm(form) {
    let valid = true;
    const dniPattern = /^[XYZ]?\d{5,8}[A-Z]$/;
    if (!dniPattern.test(form.dni.value)) {
        form.dni.classList.add("error");
        valid = false;
    } else {
        form.dni.classList.remove("error");
    }
    valid = validateLength(form.prNombre, 1, 20) && valid;
    if (form.sgNombre.value && form.sgNombre.value.trim().length > 20) {
        form.sgNombre.classList.add("error");
        valid = false;
    } else {
        form.sgNombre.classList.remove("error");
    }
    valid = validateLength(form.prApellido, 1, 20) && valid;
    if (form.sgApellido.value && form.sgApellido.value.trim().length > 20) {
        form.sgApellido.classList.add("error");
        valid = false;
    } else {
        form.sgApellido.classList.remove("error");
    }
    valid = validateDate(form.fechaNacimiento) && valid;
    valid = validateLength(form.direccion, 1, 50) && valid;
    valid = validateLength(form.localidad, 1, 20) && valid;
    valid = validateNumber(form.cp, 5) && valid;
    valid = validateNumber(form.tel, 9) && valid;
    valid = validateNumber(form.prTelResp, 9) && valid;
    if (form.sgTelResp.value && !validateNumber(form.sgTelResp, 9)) {
        valid = false;
    }
    valid = validateEmail(form.email) && valid;
    validateImage(form.foto);
    return valid;
}

function validateRoomForm(form) {
    let valid = true;
    valid = validateLength(form.nombre, 1, 30) && valid;
    const validTypes = ['PEQUEÑA', 'MEDIANA', 'GRANDE', 'MUY GRANDE'];
    if (!validTypes.includes(form.tipo.value)) {
        form.tipo.classList.add("error");
        valid = false;
    } else {
        form.tipo.classList.remove("error");
    }
    return valid;
}

function validateIncidentForm(form) {
    let valid = true;
    if (!form.socio.value) {
        form.socio.classList.add("error");
        valid = false;
    } else {
        form.socio.classList.remove("error");
    }
    const validTypes = ['LEVE', 'GRAVE', 'MUY GRAVE'];
    if (!validTypes.includes(form.tipo.value)) {
        form.tipo.classList.add("error");
        valid = false;
    } else {
        form.tipo.classList.remove("error");
    }
    valid = validateDate(form.fechaFinExp) && valid;
    return valid;
}

function validateEventForm(form) {
    let valid = true;
    valid = validateLength(form.titulo, 1, 30) && valid;
    if (!form.sala.value) {
        form.sala.classList.add("error");
        valid = false;
    } else {
        form.sala.classList.remove("error");
    }
    valid = validateLength(form.entidad, 1, 30) && valid;
    valid = validateNumber(form.asistentes, 1) && valid;
    valid = validateDate(form.fecha) && valid;
    valid = validateTime(form.hora) && valid;
    return valid;
}