function showModal(fecha, entrega, recibe, cc, cctv, c_acc, pabellones, upc, p_superiores, incendio, central_termica, data_center, comentarios, observaciones) {
    
    document.getElementById('leerFecha').textContent = fecha;
    document.getElementById('leerEntrega').textContent = entrega;

    if (recibe === 'no') {
        document.getElementById('leerRecibe').textContent = '';
        document.getElementById('noFirmado').textContent = 'No firmado';
    } else {
        document.getElementById('leerRecibe').textContent = recibe;
        document.getElementById('noFirmado').textContent = '';
    }

    const registroDetalles = document.getElementById('registroDetalles');
    registroDetalles.innerHTML = ''; 

    const secciones = [
        { label: 'CC', value: cc },
        { label: 'CCTV', value: cctv },
        { label: 'Control de Acceso', value: c_acc },
        { label: 'Pabellones', value: pabellones },
        { label: 'UPC', value: upc },
        { label: 'Pisos Superiores', value: p_superiores },
        { label: 'Incendio', value: incendio },
        { label: 'Central Térmica', value: central_termica },
        { label: 'Data Center', value: data_center },
        { label: 'Comentarios', value: comentarios },
        { label: 'Observaciones', value: observaciones }
    ];

    secciones.forEach(section => {
        if (section.value) {
            const h3 = document.createElement('h3');
            h3.textContent = section.label; 

            const p = document.createElement('p');
            // Aquí reemplazamos los saltos de línea (\n) con etiquetas <br> en el JavaScript
            p.innerHTML = section.value.replace(/(?:\r\n|\r|\n)/g, '<br>');

            registroDetalles.appendChild(h3);
            registroDetalles.appendChild(p);
        }
    });
}


function openModal(turnoId) {
    document.getElementById('turno_id').value = turnoId;
    document.getElementById('modalTexto').innerHTML = "Ingrese el nombre de usuario que firmará la entrega de este turno: " + turnoId;
}

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    const mybutton = document.getElementById("scrollToTopBtn");
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0; // Para Safari
    document.documentElement.scrollTop = 0; // Para Chrome, Firefox, IE y Opera
}
