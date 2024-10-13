document.addEventListener('DOMContentLoaded', function() {
    var datos = datosFromPHP; // Los datos enviados desde PHP
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    datos.forEach((item, index) => {
        doc.text(20, 10 + (10 * index), `ID: ${item.id_project}, Address: ${item.address}, Date: ${item.date}`);
    });

    doc.save('informe.pdf');
});
